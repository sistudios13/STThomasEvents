<?php
declare(strict_types=1);

namespace App\Repositories;

use BookingSessionsQuery;
use BookingsQuery;

class TicketsRepository
{

    public function authenticateEmailAndCode(string $email, string $code): bool
    {
        $user = BookingSessionsQuery::Create()
            ->filterByEmail($email)
            ->filterByReference($code)
            ->findOne();

        if (!$user) {
            return false;
        }

        return true;
    }

    public function getBookingDataByCode(string $code): ?array
    {
        $session = BookingSessionsQuery::create()
            ->filterByReference($code)
            ->joinWith('Events')
            ->select(['Name', 'EventId', 'Email', 'Reference', 'Events.Name', 'Events.Price', 'Events.Description', 'Events.StartsAt', 'Events.EndsAt', 'Events.Location'])
            ->find();

        if ($session->getFirst() === null) {
            return null;
        }

        return [
            'Name' => $session->getFirst()['Name'],
            'EventId' => $session->getFirst()['EventId'],
            'Email' => $session->getFirst()['Email'],
            'Reference' => $session->getFirst()['Reference'],

            'Events.Name' => $session->getFirst()['Events.Name'],
            'Events.Description' => $session->getFirst()['Events.Description'],
            'Events.StartsAt' => $session->getFirst()['Events.StartsAt'],
            'Events.EndsAt' => $session->getFirst()['Events.EndsAt'],
            'Events.Location' => $session->getFirst()['Events.Location'],
            'Events.Price' => $session->getFirst()['Events.Price']
        ];
    }

    public function getTicketDataByCode(string $code): ?array
    {
        $session = BookingSessionsQuery::create()
            ->filterByReference($code)
            ->joinWith('Bookings')
            ->select(['Bookings.Seat', 'Bookings.Token'])
            ->find();

        if ($session == null) {
            return null;
        }

        $tickets = $session->toArray();
        if (count($tickets) == 1) {
            $ticketArray = [$tickets[0]];
            return $ticketArray;
        }
        return $tickets;
    }

    public function seatBelongsToCode(string $code, string $seat): bool
    {

        $booking = BookingsQuery::create()
            ->useBookingSessionsQuery()
            ->filterByReference($code)
            ->endUse()
            ->filterBySeat($seat)
            ->findOne();

        if (!$booking) {
            return false;
        }

        return true;
    }

    public function removeSeatFromBooking(string $code, string $seat): void
    {


        $booking = BookingsQuery::create()
            ->useBookingSessionsQuery()
            ->filterByReference($code)
            ->endUse()
            ->filterBySeat($seat)
            ->findOne();

        if ($booking) {
            $booking->delete();

        }

        $session = BookingSessionsQuery::create()
            ->filterByReference($code)
            ->findOne();
        if ($session) {
            $remainingSeats = BookingsQuery::create()
                ->filterBySessionId($session->getId())
                ->count();

            if ($remainingSeats == 0) {
                $session->delete();
            }
        }

    }

}