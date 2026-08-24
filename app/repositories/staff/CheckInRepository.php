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

class CheckInRepository
{
    public function findCurrentSeatedById(int $id): ?array // EndsAt in futurre + seatmap
    {
        $event = EventsQuery::create()
            ->filterById($id)
            ->filterByEndsAt(['min' => new \DateTime])
            ->filterBySeating(true)
            ->findOne();

        return $event ? $event->toArray() : null;
    }
    public function bookingExists(string $qr_data): bool
    {
        $booking = BookingsQuery::create()
            ->filterByToken($qr_data)
            ->findOne();

        return $booking !== null;
    }
    public function checkInBooking(int $event_id, string $qr_data): array|bool
    {
        $booking = BookingsQuery::create()
            ->filterByEventId($event_id)
            ->filterByToken($qr_data)
            ->joinWithBookingSessions()

            ->findOne();

        if (!$booking) {
            return false; // Booking not found
        }

        // Check if the booking is already checked in
        if ($booking->getCheckedIn()) {
            return true; // Already checked in
        }

        // Mark the booking as checked in
        $booking->setCheckedIn(true);
        $booking->save();

        $data = $booking->toArray();
        $session = $booking->getBookingSessions();

        if ($session !== null) {
            $data['Name'] = $session->getName();
        }

        return $data;
    }

    public function getCheckInStats(int $event_id): array
    {
        $totalBookings = BookingsQuery::create()
            ->filterByEventId($event_id)
            ->count();

        $checkedInBookings = BookingsQuery::create()
            ->filterByEventId($event_id)
            ->filterByCheckedIn(true)
            ->count();

        return [
            'total' => $totalBookings,
            'checked' => $checkedInBookings,
        ];
    }

    public function undoCheckIn(int $event_id, int $booking_id): ?string
    {
        $booking = BookingsQuery::create()
            ->filterByEventId($event_id)
            ->filterById($booking_id)
            ->findOne();

        if (!$booking) {
            return null; // Booking not found
        }

        if (!$booking->getCheckedIn()) {
            return null; // Not checked in, cannot undo
        }

        // Mark the booking as not checked in
        $booking->setCheckedIn(false);
        $booking->save();

        return $booking->getSeat(); // Return the seat
    }

    
}