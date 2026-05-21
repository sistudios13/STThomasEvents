<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseRepository.php';

use Propel\Runtime\ActiveQuery\Criteria;
class BookingRepository extends BaseRepository
{

    public function emailExists(string $email, int $event_id): bool
    {
        // $count = 0;
        // $stmt = $this->con->prepare("SELECT COUNT(*) as count FROM booking_sessions WHERE email = ? AND event_id = ? AND (email_verified = 1 OR (email_verified = 0 AND code_expires_at > NOW()))");
        // $stmt->bind_param('si', $email, $event_id);
        // $stmt->execute();
        // $stmt->bind_result($count);
        // $stmt->fetch();
        // $stmt->close();

        // return $count > 0;

        $sessions = BookingSessionsQuery::create()
            ->filterByEmail($email)
            ->filterByEventId($event_id)
            ->condition('verified', 'BookingSessions.EmailVerified = ?', true)
            ->condition('pending', 'BookingSessions.EmailVerified = ? AND BookingSessions.CodeExpiresAt > NOW()', false)
            ->combine(['verified', 'pending'], Criteria::LOGICAL_OR)
            ->count();

        return $sessions > 0;
    }

    public function createSession(Booking $bookingObject): int
    {

        $event_id = $bookingObject->event_id;
        $name = $bookingObject->name;
        $email = $bookingObject->email;
        $phone = $bookingObject->phone;
        $role = $bookingObject->role;
        $token = $bookingObject->token;
        $verification_code = $bookingObject->otp;
        $code_expires_at = $bookingObject->code_expires_at;
        $reference = $bookingObject->reference;

        // $stmt = $this->con->prepare(
        //     "INSERT INTO booking_sessions (event_id, name, email, phone, role, token, verification_code, code_expires_at, reference) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        // );
        // $stmt->bind_param('isssssiss', $event_id, $name, $email, $phone, $role, $token, $verification_code, $code_expires_at, $reference);
        // $stmt->execute();

        // $session_id = $this->con->insert_id;
        // $stmt->close();

        // return $session_id;

        $booking_session = new BookingSessions();
        $booking_session->setEventId($event_id);
        $booking_session->setName($name);
        $booking_session->setEmail($email);
        $booking_session->setPhone($phone);
        $booking_session->setRole($role);
        $booking_session->setToken($token);
        $booking_session->setVerificationCode($verification_code);
        $booking_session->setCodeExpiresAt($code_expires_at);
        $booking_session->setReference($reference);
        $booking_session->save();

        return $booking_session->getId();
    }

    public function saveSeats(Booking $bookingObject): void
    {

        $event_id = $bookingObject->event_id;
        $seats = $bookingObject->seats;
        $session_id = $bookingObject->session_id;
        $code_expires_at = $bookingObject->code_expires_at;

        // $stmt = $this->con->prepare(
        //     "INSERT INTO bookings (event_id, seat, session_id, code_expires_at) VALUES (?, ?, ?, ?)"
        // );

        // foreach ($seats as $seat) {
        //     $stmt->bind_param('isis', $event_id, $seat, $session_id, $code_expires_at);
        //     $stmt->execute();
        // }

        // $stmt->close();

        
        foreach ($seats as $seat) {
            $booking = new Bookings();
            $booking->setEventId($event_id);
            $booking->setSeat($seat);
            $booking->setSessionId($session_id);
            $booking->setCodeExpiresAt($code_expires_at);
            $booking->setToken(bin2hex(random_bytes(7)));
            $booking->save();
        }
    }

    public function removeFromReservations(int $event_id, string $reservation_token): void
    {
        // $stmt = $this->con->prepare(
        //     "DELETE FROM reservation_sessions WHERE token = ? AND event_id = ?"
        // );
        // $stmt->bind_param('si', $reservation_token, $event_id);
        // $stmt->execute();
        // $stmt->close();

        $reservation_sessions = new ReservationSessionsQuery();
        $reservation_sessions->filterByToken($reservation_token);
        $reservation_sessions->filterByEventId($event_id);
        $reservation_sessions->delete();
    }

    public function getResendInfoByToken(string $token): ?array
    {
        // $stmt = $this->con->prepare("SELECT email, name, verification_code FROM booking_sessions WHERE token = ?");
        // $stmt->bind_param('s', $token);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $info = null;

        // if ($result->num_rows > 0) {
        //     $info = $result->fetch_assoc();
        // }

        // $stmt->close();
        // return $info;

        $booking_session = BookingSessionsQuery::create()
            ->filterByToken($token)
            ->select(['Email', 'Name', 'VerificationCode'])
            ->findOne();

        if (!$booking_session) {
            return null;
        }

        return $booking_session;

}


}