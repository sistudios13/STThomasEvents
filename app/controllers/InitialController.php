<?php

declare(strict_types= 1);

require_once __DIR__ . '/../models/Events.php';
require __DIR__ . '/../../config/helpers.php';
class InitialController
{


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
            'eventsData' => Events::getAll()
        ]);
    }

    public function eventDetails(int|string $id): void
    {
        $event = Events::getById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404.html'));
            return;
        }
        render('event_details', 'main', [
            'pageTitle' => 'Event Details - St. Thomas Tickets',
            'eventData' => $event
        ]);
    }

    



}