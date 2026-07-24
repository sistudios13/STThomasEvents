<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\EventService;

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
            'pageTitle' => 'St. Thomas Events'
        ]);
    }

    public function events(): void
    {
        render('events', 'main', [
            'pageTitle' => 'Events - St. Thomas Events',
            'eventsData' => $this->eventService->getAllCurrentEvents()
        ]);
    }

    public function eventDetails(int|string $id): void
    {
        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }
        render('event_details', 'main', [
            'pageTitle' => 'Event Details - St. Thomas Events',
            'eventData' => $event
        ]);
    }



    public function eventPassed(): void
    {
        session_destroy();
        render('event_passed', null, [
            'pageTitle' => 'Event Passed - St. Thomas Events',

        ]);
    }


    public function privacy(): void
    {
        render('privacy', 'main', [
            'pageTitle' => 'Privacy Policy - St. Thomas Events',
        ]);
    }

    public function terms(): void
    {
        render('terms', 'main', [
            'pageTitle' => 'Terms of Service - St. Thomas Events',
        ]);
    }





}