<?php

declare(strict_types=1);

require_once __DIR__ . '/../../core/db.php';

class ReservationRepository
{
    public function createSession(string $token, int $event_id, string $expires_at): int
    {
        $stmt = Database::$con->prepare(
            "INSERT INTO reservation_sessions (token, event_id, expires_at) VALUES (?, ?, ?)"
        );
        $stmt->bind_param('sis', $token, $event_id, $expires_at);
        $stmt->execute();

        $session_id = Database::$con->insert_id;
        $stmt->close();

        return $session_id;
    }

    public function saveSeats(int $session_id, int $event_id, array $seats, string $expires_at): void
    {
        $stmt = Database::$con->prepare(
            "INSERT INTO reservations (event_id, seat, session_id, expires_at) VALUES (?, ?, ?, ?)"
        );

        foreach ($seats as $seat) {
            $stmt->bind_param('isis', $event_id, $seat, $session_id, $expires_at);
            $stmt->execute();
        }

        $stmt->close();
    }

    public function deleteExpired(): void
    {
        $stmt = Database::$con->prepare("DELETE FROM reservation_sessions WHERE expires_at < NOW()");
        $stmt->execute();
        $stmt->close();
    }
}
