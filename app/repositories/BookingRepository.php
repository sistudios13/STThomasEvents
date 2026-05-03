<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseRepository.php';
class BookingRepository extends BaseRepository
{

    public function emailExists(string $email, int $event_id): bool
    {
        $count = 0;
        $stmt = $this->con->prepare("SELECT COUNT(*) as count FROM booking_sessions WHERE email = ? AND event_id = ?");
        $stmt->bind_param('si', $email, $event_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public function createSession(Booking $bookingObject): int
    {

        $event_id = $bookingObject->event_id;
        $name = $bookingObject->name;
        $email = $bookingObject->email;
        $phone = $bookingObject->phone;
        $token = $bookingObject->token;
        $verification_code = $bookingObject->otp;
        $code_expires_at = $bookingObject->code_expires_at;

        $stmt = $this->con->prepare(
            "INSERT INTO booking_sessions (event_id, name, email, phone, token, verification_code, code_expires_at) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('issssis', $event_id, $name, $email, $phone, $token, $verification_code, $code_expires_at);
        $stmt->execute();

        $session_id = $this->con->insert_id;
        $stmt->close();

        return $session_id;
    }

    public function saveSeats(Booking $bookingObject): void
    {

        $event_id = $bookingObject->event_id;
        $seats = $bookingObject->seats;
        $session_id = $bookingObject->session_id;
        $code_expires_at = $bookingObject->code_expires_at;

        $stmt = $this->con->prepare(
            "INSERT INTO bookings (event_id, seat, session_id, code_expires_at) VALUES (?, ?, ?, ?)"
        );

        foreach ($seats as $seat) {
            $stmt->bind_param('isis', $event_id, $seat, $session_id, $code_expires_at);
            $stmt->execute();
        }

        $stmt->close();
    }

    public function removeFromReservations(int $event_id, string $reservation_token): void
    {
        $stmt = $this->con->prepare(
            "DELETE FROM reservation_sessions WHERE token = ? AND event_id = ?"
        );
        $stmt->bind_param('si', $reservation_token, $event_id);
        $stmt->execute();
        $stmt->close();
    }

}


