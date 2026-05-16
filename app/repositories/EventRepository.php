<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseRepository.php';

class EventRepository extends BaseRepository
{
    public function findAll(): ?array
    {
        $stmt = $this->con->prepare("SELECT * FROM events WHERE date >= NOW() + INTERVAL 30 MINUTE ORDER BY date ASC");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->con->prepare("SELECT * FROM events WHERE id = ? AND date >= NOW() + INTERVAL 30 MINUTE ORDER BY date ASC"); //added 30 min buffer to prevent last minute bookings
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $event = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $event ?: null;
    }

    public function getSeatsByToken(int $event_id, string $token): ?array
    {
        $stmt = $this->con->prepare("SELECT r.seat FROM reservations r JOIN reservation_sessions s ON r.session_id = s.id WHERE s.token = ? AND s.event_id = ? AND s.expires_at > NOW()");
        $stmt->bind_param("si", $token, $event_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return array_column($result, 'seat') ?: null;

    }

    public function getUnavailableSeats(int $event_id): ?array //reserved and booked seats
    {
        $stmt = $this->con->prepare("SELECT seat FROM reservations WHERE event_id = ? AND expires_at > NOW()
        UNION
        SELECT seat FROM bookings WHERE event_id = ? AND (email_verified = 1 OR (email_verified = 0 AND code_expires_at > NOW()));");
        $stmt->bind_param("ii", $event_id, $event_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return array_column($result, 'seat');

    }

    public function isSeatAvailable(int $event_id, string $seat): bool //reserved and booked seats
    {
        $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM ( SELECT seat FROM reservations WHERE event_id = ? AND seat = ? AND expires_at > NOW()
        UNION
        SELECT seat FROM bookings WHERE event_id = ? AND seat = ? AND ( email_verified = 1 OR (email_verified = 0 AND code_expires_at > NOW()) ) ) AS unavailable_seat;");
        $stmt->bind_param("isis", $event_id, $seat, $event_id, $seat);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $stmt->close();
        return $result['count'] == 0;

    }
}
