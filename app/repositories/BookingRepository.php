<?php

declare(strict_types=1);

namespace App\Repositories;

use Propel\Runtime\ActiveQuery\Criteria;
use App\Models\Booking;
use BookingSessionsQuery;
use BookingSessions;
use Bookings;
use ReservationSessionsQuery;
class BookingRepository
{

    public function emailExists(string $email, int $event_id): bool
    {
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
        $reservation_sessions = new ReservationSessionsQuery();
        $reservation_sessions->filterByToken($reservation_token);
        $reservation_sessions->filterByEventId($event_id);
        $reservation_sessions->delete();
    }

    public function getResendInfoByToken(string $token): ?array
    {

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