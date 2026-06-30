<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Respect\Validation\Validator as v;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

require_once __DIR__ . '/../models/Bookings.php';
require_once __DIR__ . '/../repositories/BookingRepository.php';
require_once __DIR__ . '/EmailService.php';


class BookingService
{
    private BookingRepository $bookingRepository;
    private EventService $eventService;
    private EmailService $emailService;

    public function __construct()
    {
        $this->bookingRepository = new BookingRepository();
        $this->eventService = new EventService();
        $this->emailService = new EmailService();
    }

    public function bookSeats(int $event_id, string $name, string $email, string $phone, string $role): Booking
    {
        // Check if email already exists for the event
        if ($this->bookingRepository->emailExists($email, $event_id)) {
            throw new InvalidArgumentException('Email already used for this event.');
        }

        if (!in_array($role, ['student', 'parent', 'teacher', 'other'])) {
            throw new InvalidArgumentException('Invalid role selected.');
        }

        if ($role == '') {
            throw new InvalidArgumentException('Role is required.');
        }

        if (!v::email()->validate($email)) {
            throw new InvalidArgumentException('Invalid email format.');
        }

        if (!v::regex('/^\(\d{3}\) \d{3}-\d{4}$/')->validate($phone)) {
            throw new InvalidArgumentException('Invalid phone number format. Expected format: (999) 999-9999.');
        }

        if (!v::between(2, 100)->validate(strlen($name))) {
            throw new InvalidArgumentException('Name must be between 2 and 100 characters long.');
        }

        if (!v::between(5, 200)->validate(strlen($email))) {
            throw new InvalidArgumentException('Email must be between 5 and 200 characters long.');
        }

        $seats = $this->eventService->getSeatsByToken($event_id, $_SESSION['reservation_token']);

        if (count($seats) == 0) {
            throw new InvalidArgumentException('No seats reserved for booking.');
        }

        $booking = new Booking($event_id, $seats, $name, $email, $phone, $role);
        $booking->generateOTP();
        $booking->setExpiry(300); // OTP valid for 5 minutes
        $booking->generateToken();
        $booking->generateReference();
        $booking->seats = $seats;


        $this->sendConfirmationEmail($booking->email, $booking->name, $booking->otp);

        $booking->session_id = $this->bookingRepository->createSession($booking);

        $this->bookingRepository->saveSeats($booking);

        $this->bookingRepository->removeFromReservations($event_id, $_SESSION['reservation_token']);

        return $booking;
    }

    public function sendConfirmationEmail(string $email, string $name, int $otp): void
    {

        $sent = $this->emailService->sendEmail(
            $email,
            $name, 
            'Your Booking Confirmation Code',
            "
            <h1>Your Booking Confirmation Code</h1>
            <p>Hello {$name},</p>
            <p>Thank you for booking with St. Thomas Events! Your confirmation code is:</p>
            <h2>{$otp}</h2>
            <p>This code will expire in 5 minutes. Please enter it on the confirmation page to complete your booking.</p>
            <p>If you did not make this booking, please ignore this email.</p>
            <br>
            <p>Best regards,<br>St. Thomas Events Team</p>
            <hr>
            <p style='font-size: 0.8em;'>© 2026 St. Thomas Events. All rights reserved.</p>
            "
        );

        if (!$sent) {
            throw new InvalidArgumentException('Failed to send confirmation email. Please try again later.');
        }


    }

    public function getResendInfoByToken(string $token): ?array
    {
        $info = $this->bookingRepository->getResendInfoByToken($token);

        if (empty($info)) {
            throw new InvalidArgumentException('Could not find booking. Something went wrong.');

        }
        return $info;

    }
}