<?php

declare(strict_types=1);

namespace App\Repositories;

use BookingSessionsQuery;
use BookingsQuery;

class ConfirmationRepository
{

    public function getEmailByToken(string $booking_token): ?string
    {

        $email = BookingSessionsQuery::create()
            ->filterByToken($booking_token)
            ->select('Email')
            ->findOne();
        if (!$email) {
            return null;
        }
        return $email;
    }

    public function getCodeByToken(int $event_id, string $booking_token): ?int
    {

        $code = BookingSessionsQuery::create()
            ->filterByToken($booking_token)
            ->filterByEventId($event_id)
            ->select('VerificationCode')
            ->findOne();
        if (!$code) {
            return null;
        }
        return $code;
    }

    public function getSIDByToken(int $event_id, string $booking_token): ?int
    {

        $sid = BookingSessionsQuery::create()
            ->filterByToken($booking_token)
            ->filterByEventId($event_id)
            ->select('Id')
            ->findOne();
        if (!$sid) {
            return null;
        }
        return $sid;
    }

    public function confirmBooking(int $event_id, int $SID): bool
    {

        $booking_session = BookingSessionsQuery::create()
            ->filterById($SID)
            ->filterByEventId($event_id)
            ->findOne();
        $booking_session->setEmailVerified(true);
        $booking_session->save();

        $bookings = BookingsQuery::create()
            ->filterBySessionId($SID)
            ->filterByEventId($event_id)
            ->find();

        foreach ($bookings as $booking) {
            $booking->setEmailVerified(true);
            
            $booking->save();
        }

        return true;
    }

    public function getTicketInfoByToken(string $booking_token): ?array
    {

        $session = BookingSessionsQuery::create()
            ->useEventsQuery('e')
            ->endUse()
            ->filterByToken($booking_token)
            ->select(['Name', 'Email', 'AccessCode', 'e.Name'])
            ->findOne();

            if (!$session) {
                return null;
            }

            return $session;
    }

}
