<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/ReservationService.php';
require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';

class BookingController
{
    private ReservationService $reservationService;
    private EventService $eventService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->eventService = new EventService();
    }

    public function eventBooking(int|string $id): void
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


}
