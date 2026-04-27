<?php

require_once __DIR__ . '/../models/Events.php';
require_once __DIR__ . '/../models/Reservations.php';
require __DIR__ . '/../../config/helpers.php';
class BookingController
{

    public function eventSeats($id)
    {
        if (hasValidReservation()) {
            redirectToRightStep($id);
        }

        $event = Events::getById($id);
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }
        render('event_seats', 'seats', [
            'pageTitle' => 'Choose Seats - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 1,
            'reservedSeats' => Events::getUnavailableSeats($id)
        ]);
    }

    public function reserveSeats($id)
    {
        $event = Events::getById($id);
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }

        if (!isset($_POST['seats']) || empty($_POST['seats'])) {
            http_response_code(400);
            echo 'No seats selected!';
            return;
        }


        $seats =  explode(',', $_POST['seats']);

        if (count($seats) > 6) {
            http_response_code(400);
            echo 'You cannot book more than 6 seats at once!';
            return;
        }

        foreach ($seats as $seat) {
            if (!Events::seatExists($seat)) {
                http_response_code(400);
                echo "Seat $seat does not exist!";
                return;
            }
        }

        foreach ($seats as $seat) {
            if (!Events::isSeatAvailable($id, $seat)) {
                http_response_code(400);
                echo "Seat $seat is not available! Try refreshing the page.";
                return;
            }
        }

        $reservation = new Reservation($id, $seats);
        $reservation->create_session();
        $reservation->save_seats();

        $_SESSION['reservation_token'] = $reservation->token;
        $_SESSION['reservation_expires'] = $reservation->expires_at;
        $_SESSION['step'] = 2;

        header('HX-Redirect: ' . url('/events/' . $id . '/book'));
        exit;




    }

    public function eventBooking($id)
    {

        if (hasValidReservation()) {
            if ($_SESSION['step'] != 2) {
                header('HX-Redirect: ' . url('/events/' . $id . '/seats'));
                header('Location: ' . url('/events/' . $id . '/seats'));
                exit;
            }
        } else {
                header('HX-Redirect: ' . url('/events/' . $id . '/seats'));
                header('Location: ' . url('/events/' . $id . '/seats'));
                exit;
            }

        $event = Events::getById($id);
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }

        render('event_booking', 'seats', [
            'pageTitle' => 'Enter Details - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 2,
            'seats' => Events::getSeatsByToken($id, $_SESSION['reservation_token'])
        ]);
    }

    public function eventExpired($id) {

        if (hasValidReservation()) {
            redirectToRightStep($id);
        }
        
        $event = Events::getById($id);
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }

        render('event_expired', null, [
            'pageTitle' => 'Reservation Expired - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 1
        ]);
    }

    public function cancelReservation($id) {
        if (hasValidReservation()) {
            cancelReservation();
        } 

        $event = Events::getById($id);
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }

        
        render('event_cancel', null, [
            'pageTitle' => 'Reservation Cancelled - St. Thomas Tickets',
            'eventData' => $event,

        ]);
    }
}