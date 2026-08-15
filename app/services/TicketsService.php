<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TicketsRepository;
use Respect\Validation\Validator as v;
use App\Config\Settings;
use App\Services\EmailService;

class TicketsService
{
    private TicketsRepository $ticketsRepository;
    private EmailService $emailService;

    public function __construct() {
        $this->ticketsRepository = new TicketsRepository();
        $this->emailService = new EmailService();
    }
    

    public function authenticateTickets(string $email, string $access_code): bool
    {
        if (!v::email()->validate($email)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }

        if (!v::between(5, 200)->validate(\strlen($email))) {
            throw new \InvalidArgumentException("Email must be between 5 and 200 characters long.");
        }

        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($access_code)) {
            throw new \InvalidArgumentException("Invalid access code format. Access code must be alphanumeric, without spaces, and 6 characters long.");
        }

        return $this->ticketsRepository->authenticateEmailAndAccessCode($email, $access_code);
    }

    public function getBookingDataByAccessCode(string $access_code): ?array
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($access_code)) {
            throw new \InvalidArgumentException("Invalid access code format. Access code must be alphanumeric, without spaces, and 6 characters long.");
        }

        $data = $this->ticketsRepository->getBookingDataByAccessCode($access_code);

        return $data;
    }

    public function getTicketDataByAccessCode(string $access_code): ?array
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($access_code)) {
            throw new \InvalidArgumentException("Invalid access code format. Access code must be alphanumeric, without spaces, and 6 characters long.");
        }

        $data = $this->ticketsRepository->getTicketDataByAccessCode($access_code);
        return $data;
    }

    public function removeSeatFromBooking(string $access_code, string $seat): bool
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($access_code)) {
            throw new \InvalidArgumentException("Invalid access code format. Access code must be alphanumeric, without spaces, and 6 characters long.");
        }

        if (!v::regex('/^[A-Z]\d+$/')->validate($seat)) {
            throw new \InvalidArgumentException("Invalid seat format. Seat must start with a letter followed by numbers (e.g., A1).");
        }

        if ($this->ticketsRepository->seatBelongsToAccessCode($access_code, $seat) == false) {
            throw new \InvalidArgumentException("The seat does not belong to the booking associated with the provided access code.");
        }

        $this->ticketsRepository->removeSeatFromBooking($access_code, $seat);

        return true;
    }

    public function cancelBooking(string $access_code): void
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($access_code)) {
            throw new \InvalidArgumentException("Invalid access code format. Access code must be alphanumeric, without spaces, and 6 characters long.");
        }

        $info = $this->ticketsRepository->cancelBooking($access_code);
        $name = $info['Name'];

        $url = Settings::APP_URL . "support/";

        $sent = $this->emailService->sendEmail(
            $info['Email'],
            $name,
            'Your Booking Has Been Cancelled',
            "
            <h1>Your Booking Has Been Cancelled</h1>
            <p>Hello {$name},</p>
            <p>Your booking has been successfully cancelled.</p>
            <p>If you have any questions, please visit our support page: <a href='{$url}'>{$url}</a></p>
            <br>
            <p>Thank you!</p>
            <hr>
            <p style='font-size: 0.8em;'>© " . date('Y') . " St. Thomas Events. All rights reserved.</p>
            "
        );

        if (!$sent) {
            throw new \InvalidArgumentException('Failed to send cancellation email. Please try again later.');
        }

        return;
    }

}