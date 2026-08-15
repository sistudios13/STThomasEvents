<?php

declare(strict_types=1);

namespace App\Controllers; 

use App\Services\TicketsService;

require __DIR__ . '/../../config/helpers.php';


class TicketsController
{
    private TicketsService $ticketsService;

    public function __construct()
    {
        $this->ticketsService = new TicketsService();
    }

    public function ticketsAuth(): void
    {

        if (isset($_SESSION['access_code'])) {
            redirectToUrl(url('/tickets/' . $_SESSION['access_code']));
            exit;
        }

        render('tickets_auth', 'main', [
            'pageTitle' => 'My Tickets - St. Thomas Events'
        ]);
    }

    public function AuthenticateTickets(): void
    {
        $email = trim($_POST['email']) ?? '';
        $access_code = trim(strtoupper($_POST['access_code'])) ?? '';

        if (empty($email) || empty($access_code)) {
            http_response_code(400);
            echo 'Email and access code are required';
            return;
        }
        try {
            $auth = $this->ticketsService->authenticateTickets($email, $access_code);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        if ($auth == false) {
            http_response_code(400);
            echo 'Invalid email or access code.';
            return;
        }

        $_SESSION['access_code'] = $access_code;

        header('HX-Redirect: ' . url('/tickets/' . $access_code));
    }

    public function ticketsHome(string $access_code): void
    {
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $access_code) {
            header('Location: ' . url('/tickets/'));
            exit;
        }

        try {
            $data = $this->ticketsService->getBookingDataByAccessCode($access_code);
        } catch (\InvalidArgumentException $e) {
            header('Location: ' . url('/tickets/'));
            exit;
        }

        if (empty($data)) {
            header('Location: ' . url('/tickets/logout/'));
            exit;
        }

        if (new \DateTime($data['Events.EndsAt']) < new \DateTime) {
            header('Location: ' . url('/events/passed/'));
            exit;
        }

        render('tickets_home', 'main', [
            'pageTitle' => 'My Tickets - St. Thomas Events',
            'access_code' => $access_code,
            'data' => $data,
        ]);
    }

    public function partialHomeSeats(string $access_code): void
    {
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $_POST['access_code']) {
            redirectToUrl(url('/tickets/'));
            exit;
        }

        try {
            $tickets = $this->ticketsService->getTicketDataByAccessCode($access_code);
            $booking = $this->ticketsService->getBookingDataByAccessCode($access_code);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            
        }

        require __DIR__ . '/../views/partials/tickets.php';
    }

    public function removeSeat(string $access_code, string $seat): void
    {
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $access_code) {
            redirectToUrl(url('/tickets/'));
            exit;
        }
        try {
            $this->ticketsService->removeSeatFromBooking($access_code, $seat);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }
        header('HX-Trigger: refresh-list');
        header('HX-Success-Message: Seat removed successfully');
        exit;
    }

    public function cancelBooking(string $access_code): void
    {
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $access_code) {
            redirectToUrl(url('/tickets/'));
            exit;
        }
        try {
            $this->ticketsService->cancelBooking($access_code);
        } catch (\Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }

        session_destroy();
        header('HX-Success-Message: Booking Cancelled successfully');
        redirectToUrl(url('/tickets/cancelled/'));
    }


    public function logout(): void
    {
        session_destroy();
        redirectToUrl($_SERVER['HTTP_REFERER'] ?? url('/tickets/'));
        exit;
    }

}