<?php

declare(strict_types=1);

namespace App\Repositories;

use EventsQuery;
use Propel\Runtime\ActiveQuery\Criteria;
class ReminderRepository
{
    public function getUpcomingReminders(): array
    {
        $now = new \DateTimeImmutable();
        $next48Hours = $now->modify('+48 hours');

        $results = EventsQuery::create()
            ->filterByStartsAt(
                $now,
                Criteria::GREATER_EQUAL
            )
            ->filterByStartsAt(
                $next48Hours,
                Criteria::LESS_EQUAL
            )
            ->useBookingSessionsQuery()
            ->filterByEmailVerified(true)
            ->filterByReminderSentAt(null, Criteria::ISNULL)
            ->endUse()
            ->withColumn('Events.Name', 'eventName')
            ->withColumn('Events.StartsAt', 'eventStartsAt')
            ->withColumn('BookingSessions.Name', 'name')
            ->withColumn('BookingSessions.Email', 'email')
            ->withColumn('BookingSessions.Id', 'id')
            ->withColumn('BookingSessions.AccessCode', 'accessCode')
            ->select([
                'eventName',
                'eventStartsAt',
                'name',
                'email',
                'id',
                'accessCode',
            ])
            ->find()
            ->toArray();

        return $results;
    }

    public function markReminderSent(int $booking_session_id): void
    {
        $bookingSession = \BookingSessionsQuery::create()
            ->filterById($booking_session_id)
            ->findOne();

        if ($bookingSession) {
            $bookingSession->setReminderSentAt(new \DateTimeImmutable());
            $bookingSession->save();
        }
    }
}