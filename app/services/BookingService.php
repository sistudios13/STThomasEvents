<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

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
        $booking->setExpiry(600); // OTP valid for 10 minutes
        $booking->generateToken();
        $booking->seats = $seats;


        $this->sendConfirmationEmail($booking->email, $booking->name, $booking->otp);

        $booking->session_id = $this->bookingRepository->createSession($booking);

        $this->bookingRepository->saveSeats($booking);

        $this->bookingRepository->removeFromReservations($event_id, $_SESSION['reservation_token']);

        return $booking;
    }

    public function sendConfirmationEmail(string $email, string $name, int $otp): void
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USER'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // tls. ENCRYPTION_SMTPS for 465
            $mail->Port = 587; // or 465
            $mail->isHTML(true);

            $mail->setFrom($_ENV['MAIL_USER'], 'St. Thomas Tickets');
            $mail->addAddress($email, $name);
            $mail->Subject = 'Your Booking Confirmation Code';
            $mail->Body = "
            <h1>Your Booking Confirmation Code</h1>
            <p>Hello {$name},</p>
            <p>Thank you for booking with St. Thomas Tickets! Your confirmation code is:</p>
            <h2>{$otp}</h2>
            <p>This code will expire in 10 minutes. Please enter it on the confirmation page to complete your booking.</p>
            <p>If you did not make this booking, please ignore this email.</p>
            <br>
            <p>Best regards,<br>St. Thomas Tickets Team</p>
            <hr>
            <p style='font-size: 0.8em;'>© 2026 St. Thomas Tickets. All rights reserved.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            throw new InvalidArgumentException('Failed to send confirmation email. Please try again later.');
        }
    }

}
