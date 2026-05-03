<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/BookingService.php';
require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';

class ConfirmationController
{
    private BookingService $bookingService;
    private EventService $eventService;

    public function __construct()
    {
        $this->bookingService = new BookingService();
        $this->eventService = new EventService();
    }

    public function eventConfirmation(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }

        render('event_confirmation', 'main', [
            'pageTitle' => 'Booking Confirmation - St. Thomas Tickets',
            'eventData' => $event,
            'reservationData' => $_SESSION
        ]);
    }
}