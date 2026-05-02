<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../repositories/ReservationRepository.php';


class ReservationService
{
    private ReservationRepository $reservationRepository;
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->reservationRepository = new ReservationRepository();
        $this->eventRepository = new EventRepository();
    }

    public function reserveSeats(int $event_id, array $seats): Reservation
    {
        $this->validateSeatSelection($seats);
        $this->ensureSeatsExist($seats);
        $this->ensureSeatsAvailable($event_id, $seats);

        $reservation = new Reservation($event_id, $seats);
        $reservation->generateToken();
        $reservation->setExpiry(300);

        $reservation->session_id = $this->reservationRepository->createSession(
            $reservation->token,
            $event_id,
            $reservation->expires_at
        );

        $this->reservationRepository->saveSeats(
            $reservation->session_id,
            $event_id,
            $seats,
            $reservation->expires_at
        );

        return $reservation;
    }

    private function validateSeatSelection(array $seats): void
    {
        if (empty($seats)) {
            throw new InvalidArgumentException('No seats selected!');
        }

        if (count($seats) > 6) {
            throw new InvalidArgumentException('You cannot book more than 6 seats at once!');
        }
    }

    public function seatExists(string $label): bool
    {
        $json = file_get_contents(__DIR__ . '/../../config/seats.json');
        $data = json_decode($json, true);
        $seatLabels = array_column($data, 'seat_label');
        return in_array($label, $seatLabels);
    }

    public function isSeatAvailable(int $event_id, string $seat): bool
    {
        return $this->eventRepository->isSeatAvailable($event_id, $seat);
    }
    // ADD CHECK FOR BOOKED SEATS WHEN IMPLEMENTED (in repository obv)

    private function ensureSeatsExist(array $seats): void
    {
        foreach ($seats as $seat) {
            if (!$this->seatExists($seat)) {
                http_response_code(400);
                throw new InvalidArgumentException("Seat {$seat} does not exist!");
            }
        }
    }

    private function ensureSeatsAvailable(int $event_id, array $seats): void
    {
        foreach ($seats as $seat) {
            if (!$this->isSeatAvailable($event_id, $seat)) {
                http_response_code(400);
                throw new InvalidArgumentException("Seat {$seat} is not available! Try refreshing the page.");
            }
        }
    }
}
