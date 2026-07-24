<?php

declare(strict_types=1);

namespace App\Repositories;

use Propel\Runtime\ActiveQuery\Criteria;
use EventsQuery;
use ReservationsQuery;
USE BookingsQuery;



class EventRepository
{
    public function findAll(): ?array
    {

        $events = EventsQuery::create()
            ->orderByStartsAt(Criteria::DESC)
            ->find();

        return $events->toArray() ?: null;
    }
    public function findAllCurrent(): ?array
    {

        $events = EventsQuery::create()
            ->filterByEndsAt(['min' => new \DateTime])
            ->orderByStartsAt(Criteria::DESC)
            ->find();

        return $events->toArray() ?: null;
    }

    public function findSeatedById(int $id): ?array // seatmap
    {
        $event = EventsQuery::create()
            ->filterById($id)
            ->filterByStartsAt(['min' => new \DateTime])
            ->filterBySeating(true)
            ->findOne();

        return $event ? $event->toArray() : null;
    }

    public function findById(int $id): ?array //with or no seatmap
    {
        $event = EventsQuery::create()
            ->filterById($id)
            ->filterByEndsAt(['min' => new \DateTime])
            ->findOne();

        return $event ? $event->toArray() : null;
    }

    public function getSeatsByToken(int $event_id, string $token): ?array
    {

        $seats = ReservationsQuery::create()
            ->useReservationSessionsQuery()
            ->filterByToken($token)
            ->filterByEventId($event_id)
            ->where('ReservationSessions.ExpiresAt > ?', date('Y-m-d H:i:s'))
            ->endUse()
            ->select(['Seat'])
            ->find();

        return $seats->toArray() ?: null;


    }

    public function getUnavailableSeats(int $event_id): ?array //reserved and booked seats
    {

        $reserved = ReservationsQuery::create()
            ->select(['Seat'])
            ->filterByEventId($event_id)
            ->where('Reservations.ExpiresAt > NOW()')
            ->find()
            ->getData();

        $booked = BookingsQuery::create()
            ->select(['Seat'])
            ->filterByEventId($event_id)
            ->condition('verified', 'Bookings.EmailVerified = ?', 1)
            ->condition('pending', 'Bookings.EmailVerified = ? AND Bookings.CodeExpiresAt > NOW()', 0)
            ->combine(['verified', 'pending'], 'or')
            ->find()
            ->getData();

        return array_unique([
            ...$reserved,
            ...$booked
        ]);

    }

    public function isSeatAvailable(int $event_id, string $seat): bool //reserved and booked seats
    {

        $reserved = ReservationsQuery::create()
            ->select(['Seat'])
            ->filterByEventId($event_id)
            ->where('Reservations.ExpiresAt > NOW()')
            ->findBySeat($seat);

        $booked = BookingsQuery::create()
            ->select(['Seat'])
            ->filterByEventId($event_id)
            ->condition('verified', 'Bookings.EmailVerified = ?', 1)
            ->condition('pending', 'Bookings.EmailVerified = ? AND Bookings.CodeExpiresAt > NOW()', 0)
            ->combine(['verified', 'pending'], 'or')
            ->findBySeat($seat);

        return \count($reserved) + \count($booked) == 0;


    }
}
