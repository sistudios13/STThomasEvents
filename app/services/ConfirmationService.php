<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../models/Bookings.php';
require_once __DIR__ . '/../repositories/ConfirmationRepository.php';
require_once __DIR__ . '/ExportService.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

class ConfirmationService
{
    private ConfirmationRepository $confirmationRepository;
    private EventService $eventService;
    private ExportService $exportService;

    public function __construct()
    {
        $this->confirmationRepository = new ConfirmationRepository();
        $this->eventService = new EventService();
        $this->exportService = new ExportService();
    }

    public function getEmailByToken(string $booking_token): ?string
    {
        return $this->confirmationRepository->getEmailByToken($booking_token);
    }

    public function confirmBooking(int $event_id, string $booking_token, int $enterred_code): string
    {
        $code = $this->confirmationRepository->getCodeByToken($event_id, $booking_token);

        if ($code == null) {
            throw new InvalidArgumentException("No booking session found, something went wrong.");
        }

        if (intval($code) != intval($enterred_code)) {
            throw new InvalidArgumentException("Invalid verification code.");
        }

        //more validation maybe?

        $SID = $this->confirmationRepository->getSIDByToken($event_id, $booking_token);

        if ($SID == null) {
            throw new InvalidArgumentException("No booking session found, something went wrong.");
        }


        $this->confirmationRepository->confirmBooking($event_id, $SID);
        $ticketInfo = $this->confirmationRepository->getTicketInfoByToken($booking_token);
        $this->sendTicketEmail($ticketInfo['Email'], $ticketInfo['Name'], $ticketInfo['Reference'], $ticketInfo['e.Name']);

        return $ticketInfo['Reference'];
    }

    public function sendTicketEmail(string $email, string $name, string $reference, string $event_name): void // DEV LINK
    {

        
        try {

            $pdfOutput = $this->exportService->ticketsToPdf($reference);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USER'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // tls. ENCRYPTION_SMTPS for 465
            $mail->Port = 587; // or 465
            $mail->isHTML(true);

            $mail->setFrom($_ENV['MAIL_USER'], 'St. Thomas Events');
            $mail->addAddress($email, $name);
            $mail->Subject = 'Your Tickets are Confirmed!';
            $mail->Body = "
            <h1>Your Tickets are Confirmed!</h1>
            <p>Hello {$name},</p>
            <p>Your tickets for {$event_name} are confirmed. Your tickets reference code is:</p>
            <h2>{$reference}</h2>
            <p>You can use this code to log into the tickets page and view your tickets.</p>
            <p>Log in here: <a href='localhost/tickets/'>localhost/tickets/?code={$reference}</a></p> 
            <br>
            <p>Thank you for booking with St. Thomas Events!</p>
            <hr>
            <p style='font-size: 0.8em;'>© 2026 St. Thomas Events. All rights reserved.</p>
            ";
            $mail->addStringAttachment(
                $pdfOutput,
                'tickets.pdf',
                'base64',
                'application/pdf'
            );


            $mail->send();
        } catch (Exception $e) {
            throw new InvalidArgumentException('Failed to send confirmation email. Please try again later.');
        }
    }


}
