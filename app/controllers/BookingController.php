<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/BookingService.php';
require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';

class BookingController
{
    private BookingService $bookingService;
    private EventService $eventService;

    public function __construct()
    {
        $this->bookingService = new BookingService();
        $this->eventService = new EventService();
    }

    public function eventBooking(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        if (!hasValidReservation()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }



        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }

        render('event_booking', 'seats', [
            'pageTitle' => 'Enter Details - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 2,
            'seats' => $this->eventService->getSeatsByToken(intval($id), $_SESSION['reservation_token'])
        ]);
    }

    public function bookSeats(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        if (!hasValidReservation()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));

        if (!$event) {
            http_response_code(404);
            header('HX-Redirect: ' . url('/404'));
            return;
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        try {
            $booking = $this->bookingService->bookSeats(intval($id), $name, $email, $phone);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400);
            echo $exception->getMessage();
            return;
        }

        if (!$booking) {
            http_response_code(500);
            echo 'Failed to create booking.';
            return;
        }

        session_unset();
        $_SESSION['step'] = 3;
        $_SESSION['booking_token'] = $booking->token;
        $_SESSION['code_expires_at'] = $booking->code_expires_at;

        header('HX-Redirect: ' . url('/events/' . $id . '/confirm'));
    }


}
