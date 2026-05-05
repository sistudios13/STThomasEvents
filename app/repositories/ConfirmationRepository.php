<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseRepository.php';
class ConfirmationRepository extends BaseRepository
{

    public function getEmailByToken(string $booking_token): ?string
    {
        $stmt = $this->con->prepare("SELECT email FROM booking_sessions WHERE token = ?");
        $stmt->bind_param('s', $booking_token);
        $stmt->execute();
        $result = $stmt->get_result();
        $email = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        }

        $stmt->close();
        return $email;
    }

    public function getCodeByToken(int $event_id, string $booking_token): ?int
    {
        $stmt = $this->con->prepare("SELECT verification_code FROM booking_sessions WHERE token = ? AND event_id = ?");
        $stmt->bind_param('si', $booking_token, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $code = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $code = $row['verification_code'];
        }

        $stmt->close();
        return $code;
    }

    public function getSIDByToken(int $event_id, string $booking_token): ?int
    {
        $stmt = $this->con->prepare("SELECT id FROM booking_sessions WHERE token = ? AND event_id = ?");
        $stmt->bind_param('si', $booking_token, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $SID = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $SID = $row['id'];
        }

        $stmt->close();
        return intval($SID) ?? null;
    }

    public function confirmBooking(int $event_id, int $SID): bool
    {
        // Mark the booking as confirmed in the database
        $stmt = $this->con->prepare("UPDATE booking_sessions SET email_verified = 1 WHERE id = ? AND event_id = ?");
        $stmt->bind_param('ii', $SID, $event_id);
        $stmt->execute();
        $stmt->close();

        
        $stmt = $this->con->prepare("UPDATE bookings SET email_verified = 1 WHERE session_id = ? AND event_id = ?");
        $stmt->bind_param('ii', $SID, $event_id);
        $stmt->execute();
        $stmt->close();

        return true;
    }
}


