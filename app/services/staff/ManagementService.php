<?php

declare(strict_types=1);

namespace App\Staff\Services;

use App\Repositories\EventRepository;

class ManagementService
{
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    public function getCalendarData(): ?array
    {
        $data = $this->eventRepository->findAll();

        $grouped = [];

        foreach ($data as $event) {
            $startsAt = strtotime($event['StartsAt']);

            // format '2026-7-3' 
            $dateKey = date('Y-n-j', $startsAt);

            $grouped[$dateKey][] = [
                'title' => $event['Name'],
                'time' => date('g:i A', $startsAt),
                'color' => 'blue',
                'eventId' => $event['Id'],
            ];
        }

        return $grouped;
    }

    public function getUpcomingEvents(): ?array
    {
        $eventsArray = $this->eventRepository->findAllCurrent();
        $now = time();
        $oneMonth = strtotime('+1 month', $now);

        if (empty($eventsArray)) {
            return [];
        }
        $filtered = array_filter($eventsArray, function ($event) use ($now, $oneMonth) {
            $startsAt = strtotime($event['EndsAt']);
            return $startsAt >= $now && $startsAt <= $oneMonth;
        });

        return $filtered ?: [];
    }
}