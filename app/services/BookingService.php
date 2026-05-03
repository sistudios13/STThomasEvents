<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Bookings.php';
require_once __DIR__ . '/../repositories/BookingRepository.php';


class BookingService
{
    private BookingRepository $bookingRepository;
    private EventService $eventService;

    public function __construct()
    {
        $this->bookingRepository = new BookingRepository();
        $this->eventService = new EventService();
    }

    public function bookSeats(int $event_id, string $name, string $email, string $phone): Booking
    {   
        // Check if email already exists for the event
        if ($this->bookingRepository->emailExists($email, $event_id)) {
            throw new InvalidArgumentException('Email already used for this event.');
        }

        // more validation maybe?

        $seats = $this->eventService->getSeatsByToken($event_id, $_SESSION['reservation_token']);

        if (count($seats) == 0) {
            throw new InvalidArgumentException('No seats reserved for booking.');
        }

        $booking = new Booking($event_id, $seats, $name, $email, $phone);
        $booking->generateOTP();
        $booking->setExpiry(20); // OTP valid for 10 minutes
        $booking->generateToken();
        $booking->seats = $seats;


        $booking->session_id = $this->bookingRepository->createSession($booking);

        $this->bookingRepository->saveSeats($booking);

        $this->bookingRepository->removeFromReservations($event_id, $_SESSION['reservation_token']);

        return $booking;
    }

}
