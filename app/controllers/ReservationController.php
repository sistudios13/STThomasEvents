<?php

declare(strict_types=1);


require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/ReservationService.php';
require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';


class ReservationController
{
    private ReservationService $reservationService;
    private EventService $eventService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->eventService = new EventService();
    }

    public function eventSeats(int|string $id): void
    {

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }
        render('event_seats', 'seats', [
            'pageTitle' => 'Choose Seats - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 1,
            'reservedSeats' => $this->eventService->getUnavailableSeats(intval($id))
        ]);
    }

    public function reserveSeats(int|string $id): void
    {
    
        if ($_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if ($_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }


        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('HX-Redirect: ' . url('/404'));
            return;
        }

        if (!isset($_POST['seats']) || empty($_POST['seats'])) {
            http_response_code(400);
            echo 'No seats selected!';
            return;
        }


        $seats = explode(',', $_POST['seats']);

        try {
            $reservation = $this->reservationService->reserveSeats(intval($id), $seats);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400);
            echo $exception->getMessage();
            return;
        }

        $_SESSION['reservation_token'] = $reservation->token;
        $_SESSION['reservation_expires'] = $reservation->expires_at;
        $_SESSION['step'] = 2;

        header('HX-Redirect: ' . url('/events/' . $id . '/book'));
        exit;




    }

    public function eventExpired(int|string $id): void
    {
        if (hasValidReservation()) {
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        } 

        if (hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }

        render('event_expired', null, [
            'pageTitle' => 'Session Expired - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 1
        ]);
    }

    public function cancelReservation(int|string $id): void
    {

        if (hasValidReservation()) {
            cancelReservation();
        } else {
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }


        render('event_cancel', null, [
            'pageTitle' => 'Reservation Cancelled - St. Thomas Tickets',
            'eventData' => $event,

        ]);
    }
}