<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    public function getAllEvents(): ?array
    {
        return $this->eventRepository->findAll();
    }

    public function getSeatedEventById(int $id): ?array // With Seatmap
    {
        return $this->eventRepository->findSeatedById($id);
    }

    public function getEventById(int $id): ?array // with or without seatmap
    {
        return $this->eventRepository->findById($id);
    }

    public function getSeatsByToken(int $event_id, string $token): ?array 

    {
        return $this->eventRepository->getSeatsByToken($event_id, $token);
    }

    public function getUnavailableSeats(int $event_id): ?array
    {
        return $this->eventRepository->getUnavailableSeats($event_id);

    }

    


}
