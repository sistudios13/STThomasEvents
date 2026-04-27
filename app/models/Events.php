<?php

require_once __DIR__ . '/../../core/db.php';
class Events
{

    public static function getAll()
    {
        $stmt = Database::$con->prepare("SELECT * FROM events WHERE date >= NOW() ORDER BY date ASC");
        $stmt->execute();
        $r = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $r;

    }

    public static function getById($id)
    {
        $stmt = Database::$con->prepare("SELECT * FROM events WHERE id = ? AND date >= NOW() ORDER BY date ASC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $r;

    }

    public static function seatExists($label)
    {
        $json = file_get_contents(__DIR__ . '/../../config/seats.json');

        $data = json_decode($json, true);

        $seatLabels = array_column($data, 'seat_label');

        if (in_array($label, $seatLabels)) {
            return true;
        }
        return false;
    }

    public static function isSeatAvailable($eventId, $seat)
    {
        $stmt = Database::$con->prepare("SELECT COUNT(*) as count FROM reservations WHERE event_id = ? AND seat = ? AND expires_at > NOW()");
        $stmt->bind_param("is", $eventId, $seat);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $stmt->close();
        return $result['count'] == 0;
        // ADD CHECK FOR BOOKED SEATS WHEN IMPLEMENTED

    }

    public static function getUnavailableSeats($eventId)
    {
        $stmt = Database::$con->prepare("SELECT seat FROM reservations WHERE event_id = ? AND expires_at > NOW()");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return array_column($result, 'seat');
        // ADD FOR BOOKED SEATS WHEN IMPLEMENTED
    }

    public static function getSeatsByToken($event_id, $token)
    {
        $stmt = Database::$con->prepare("SELECT r.seat FROM reservations r JOIN reservation_sessions s ON r.session_id = s.id WHERE s.token = ? AND s.event_id = ? AND s.expires_at > NOW()");
        $stmt->bind_param("si", $token, $event_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return array_column($result, 'seat');

}
}
