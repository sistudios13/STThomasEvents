<?php

declare(strict_types=1);

namespace App\Staff\Repositories;

use Propel\Runtime\ActiveQuery\Criteria;
use BookingSessionsQuery;
use BookingsQuery;
use Map\BookingSessionsTableMap;
use EventsQuery;
use Events;
use App\Config\Settings;

class ManagementRepository
{
    public function getTotalRows(int $event_id, ?string $search = null): ?int
    {
        $bookings = BookingSessionsQuery::create()
            ->filterByEventId($event_id)
            ->condition('verified', 'BookingSessions.EmailVerified = ?', true)
            ->condition('pending', 'BookingSessions.EmailVerified = ? AND BookingSessions.CodeExpiresAt > NOW()', false)
            ->combine(['verified', 'pending'], Criteria::LOGICAL_OR);

        if (!empty($search)) {
            $term = "%{$search}%";

            $bookings
                ->condition('name', BookingSessionsTableMap::COL_NAME . ' LIKE ?', $term)
                ->condition('email', BookingSessionsTableMap::COL_EMAIL . ' LIKE ?', $term)
                ->combine(['name', 'email'], Criteria::LOGICAL_OR);
        }




        return $bookings->count();
    }

    public function findEventById(int $id): ?array // no time restrictions
    {
        $event = EventsQuery::create()
            ->filterById($id)
            ->findOne();

        return $event ? $event->toArray() : null;
    }

    public function getBookings(
        int $event_id,
        int $page = 1,
        ?string $search = null,
        ?string $sort_key = null,
        ?string $sort_order = null
    ): array {
        // Whitelist sortable columns
        $sortableColumns = [
            'id' => BookingSessionsTableMap::COL_ID,
            'name' => BookingSessionsTableMap::COL_NAME,
            'email' => BookingSessionsTableMap::COL_EMAIL,
            'timestamp' => BookingSessionsTableMap::COL_TIMESTAMP,
            'status' => BookingSessionsTableMap::COL_EMAIL_VERIFIED,
        ];

        $query = BookingSessionsQuery::create()
            ->filterByEventId($event_id)
            ->condition(
                'confirmed',
                BookingSessionsTableMap::COL_EMAIL_VERIFIED . ' = ?',
                true
            )
            ->condition(
                'pending',
                BookingSessionsTableMap::COL_EMAIL_VERIFIED . ' = ? AND booking_sessions.code_expires_at > NOW()',
                false
            )
            ->combine(['confirmed', 'pending'], Criteria::LOGICAL_OR); // check if valid

        if (!empty($sort_key) && isset($sortableColumns[$sort_key])) {
            $sortDirection = strtoupper($sort_order ?? 'ASC');
            $sortDirection = $sortDirection === Criteria::DESC
                ? Criteria::DESC
                : Criteria::ASC;

            $query->orderBy(
                $sortableColumns[strtolower($sort_key)],
                $sortDirection
            ); //sorting
        }



        if (!empty($search)) { //searching
            $term = "%{$search}%";

            $query
                ->condition('name', BookingSessionsTableMap::COL_NAME . ' LIKE ?', $term)
                ->condition('email', BookingSessionsTableMap::COL_EMAIL . ' LIKE ?', $term)
                ->combine(['name', 'email'], Criteria::LOGICAL_OR);
        }

        $sessions = $query
            ->limit(Settings::STAFF_TABLE_MAX_ROWS)
            ->offset(($page - 1) * Settings::STAFF_TABLE_MAX_ROWS)
            ->find();

        //Get seats for each session and return as array
        $result = [];

        $sessionIds = [];

        foreach ($sessions as $session) {
            $sessionIds[] = $session->getId();
        }

        $bookings = BookingsQuery::create()
            ->filterBySessionId($sessionIds, Criteria::IN)
            ->find();

        $seatsBySession = [];

        foreach ($bookings as $booking) {
            $seatsBySession[$booking->getSessionId()][] = $booking->getSeat();
        }

        foreach ($sessions as $session) {
            $data = $session->toArray();
            $data['seats'] = $seatsBySession[$session->getId()] ?? [];
            $result[] = $data;
        }

        return $result;
    }

    public function deleteBooking(int $bookingId): bool
    {
        $bookingSession = BookingSessionsQuery::create()
            ->filterById($bookingId)
            ->findOne();

        if (!$bookingSession) {
            return false; //  not found
        }
        $bookingSession->delete();

        return true;
    }

    public function bookingExists(int $eventId, int $bookingId): bool
    {
        $bookingSession = BookingSessionsQuery::create()
            ->filterById($bookingId)
            ->filterByEventId($eventId)
            ->findOne();

        return $bookingSession != null;
    }

    public function getBookingById(int $bookingId): ?array
    {
        $bookingSession = BookingSessionsQuery::create()
            ->filterById($bookingId)
            ->findOne();

        return $bookingSession->toArray() ?? null;
    }

    public function createEvent(string $name, string $description, string $pricing, string $starts_at, string $ends_at, string $location, string $seating_enabled): int
    {
        $event = new Events();
        $event->setName($name);
        $event->setDescription($description);
        $event->setPrice($pricing);
        $event->setStartsAt(new \DateTime($starts_at));
        $event->setEndsAt(new \DateTime($ends_at));
        $event->setLocation($location);
        $event->setSeating($seating_enabled);
        $event->save();

        return $event->getId();
    }

    public function updateEvent(string $id, string $name, string $description, string $pricing, string $starts_at, string $ends_at, string $location, string $seating_enabled): void
    {
        $event = EventsQuery::create()
            ->filterById($id)
            ->findOne();

        if (!$event) {
            throw new \Exception("Event not found.");
        }

        $event->setName($name);
        $event->setDescription($description);
        $event->setPrice($pricing);
        $event->setStartsAt(new \DateTime($starts_at));
        $event->setEndsAt(new \DateTime($ends_at));
        $event->setLocation($location);
        $event->setSeating($seating_enabled);
        $event->save();

        return;
    }

    public function deleteEvent(int $eventId): bool
    {
        $event = EventsQuery::create()
            ->filterById($eventId)
            ->findOne();

        if (!$event) {
            return false; // Event not found
        }

        $event->delete();

        return true;
    }
}
