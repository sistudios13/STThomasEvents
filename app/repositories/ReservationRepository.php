<?php

declare(strict_types=1);

namespace App\Repositories;

use ReservationSessions;
use ReservationsQuery;
use Reservations;

class ReservationRepository
{
    public function createSession(string $token, int $event_id, string $expires_at): int
    {
        $session = new ReservationSessions();
        $session->setToken($token);
        $session->setEventId($event_id);
        $session->setExpiresAt($expires_at);
        $session->save();

        return $session->getId();

    }

    public function saveSeats(int $session_id, int $event_id, array $seats, string $expires_at): void
    {
        foreach ($seats as $seat) {
            $reservations = new Reservations();
            $reservations->setEventId($event_id);
            $reservations->setSeat($seat);
            $reservations->setSessionId($session_id);
            $reservations->setExpiresAt($expires_at);
            $reservations->save();
        }
    }

    public function deleteExpired(): void
    {
        $reservations = new ReservationsQuery();
        $reservations->filterByExpiresAt(['min' => date('Y-m-d H:i:s')]);
        $reservations->delete();
    }
}
