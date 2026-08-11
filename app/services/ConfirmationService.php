<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv;
use App\Repositories\ConfirmationRepository;
use App\Services\EventService;
use App\Services\ExportService;
use App\Services\EmailService;



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

class ConfirmationService
{
    private ConfirmationRepository $confirmationRepository;
    private EventService $eventService;
    private ExportService $exportService;
    private EmailService $emailService;

    public function __construct()
    {
        $this->confirmationRepository = new ConfirmationRepository();
        $this->eventService = new EventService();
        $this->exportService = new ExportService();
        $this->emailService = new EmailService();
    }

    public function getEmailByToken(string $booking_token): ?string
    {
        return $this->confirmationRepository->getEmailByToken($booking_token);
    }

    public function confirmBooking(int $event_id, string $booking_token, int $enterred_code): array
    {
        $code = $this->confirmationRepository->getCodeByToken($event_id, $booking_token);

        if ($code == null) {
            throw new \InvalidArgumentException("No booking session found, something went wrong.");
        }

        if (intval($code) != intval($enterred_code)) {
            throw new \InvalidArgumentException("Invalid verification code.");
        }

        //more validation maybe?

        $SID = $this->confirmationRepository->getSIDByToken($event_id, $booking_token);

        if ($SID == null) {
            throw new \InvalidArgumentException("No booking session found, something went wrong.");
        }


        $this->confirmationRepository->confirmBooking($event_id, $SID);
        $ticketInfo = $this->confirmationRepository->getTicketInfoByToken($booking_token);
        $this->sendTicketEmail($ticketInfo['Email'], $ticketInfo['Name'], $ticketInfo['AccessCode'], $ticketInfo['e.Name']);

        return [$ticketInfo['AccessCode'], $ticketInfo['Email']];
    }

    public function sendTicketEmail(string $email, string $name, string $access_code, string $event_name): void // DEV LINK
    {


        $pdfOutput = $this->exportService->ticketsToPdf($access_code);

        $url = \App\Config\Settings::APP_URL . "tickets/?code=" . $access_code . "&email=" . urlencode($email);

        $sent = $this->emailService->sendEmail(
            $email,
            $name,
            'Your Tickets are Confirmed!',
            "
            <h1>Your Tickets are Confirmed!</h1>
            <p>Hello {$name},</p>
            <p>Your tickets for {$event_name} are confirmed. Your tickets access code is:</p>
            <h2>{$access_code}</h2>
            <p>You can use this code to access the tickets page and view your tickets.</p>
            <p>Log in here: <a href='{$url}'>{$url}</a></p> 
            <br>
            <p>Thank you for booking with St. Thomas Events!</p>
            <hr>
            <p style='font-size: 0.8em;'>© " . date('Y') . " St. Thomas Events. All rights reserved.</p>
            ",
            $pdfOutput,
            'tickets.pdf'
        );

        if (!$sent) {
            throw new \InvalidArgumentException('Failed to send confirmation email. Please try again later.');
        }
    }


}
