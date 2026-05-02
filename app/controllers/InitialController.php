<?php

declare(strict_types=1);

require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';
class InitialController
{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    public function index(): void
    {

        render('home', 'main', [
            'pageTitle' => 'St. Thomas Tickets'
        ]);
    }

    public function events(): void
    {
        render('events', 'main', [
            'pageTitle' => 'Events - St. Thomas Tickets',
            'eventsData' => $this->eventService->getAllEvents()
        ]);
    }

    public function eventDetails(int|string $id): void
    {
        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }
        render('event_details', 'main', [
            'pageTitle' => 'Event Details - St. Thomas Tickets',
            'eventData' => $event
        ]);
    }





}