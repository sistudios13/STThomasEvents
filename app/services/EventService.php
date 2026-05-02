<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/EventRepository.php';

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

    public function getEventById(int $id): ?array
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
        // ADD FOR BOOKED SEATS WHEN IMPLEMENTED
    }

    


}
