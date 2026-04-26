<?php

require_once __DIR__ . '/../models/Events.php';
require __DIR__ . '/../../config/helpers.php';
class InitialController
{


    public function index()
    {
        render('home', 'main', [
            'pageTitle' => 'St. Thomas Tickets'
        ]);
    }

    public function events()
    {
        render('events', 'main', [
            'pageTitle' => 'Events - St. Thomas Tickets',
            'eventsData' => Events::getAll()
        ]);
    }

    public function eventDetails($id)
    {
        $event = Events::getById($id);
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