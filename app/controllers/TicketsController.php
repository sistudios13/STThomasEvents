<?php

declare(strict_types=1);


use chillerlan\QRCode\QRCode;
require_once __DIR__ . '/../services/TicketsService.php';
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

        if (isset($_SESSION['reference'])) {
            redirectToUrl(url('/tickets/' . $_SESSION['reference']));
            exit;
        }

        render('tickets_auth', 'main', [
            'pageTitle' => 'My Tickets - St. Thomas Events'
        ]);
    }

    public function AuthenticateTickets(): void
    {
        $email = trim($_POST['email']) ?? '';
        $code = trim(strtoupper($_POST['code'])) ?? '';

        if (empty($email) || empty($code)) {
            http_response_code(400);
            echo 'Email and code are required';
            return;
        }
        try {
            $auth = $this->ticketsService->authenticateTickets($email, $code);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        if ($auth == false) {
            http_response_code(400);
            echo 'Invalid email or code.';
            return;
        }

        $_SESSION['reference'] = $code;

        header('HX-Redirect: ' . url('/tickets/' . $code));
    }

    public function ticketsHome(string $code): void
    {
        if (!isset($_SESSION['reference']) || $_SESSION['reference'] != $code) {
            header('Location: ' . url('/tickets/'));
            exit;
        }
        try {
            $data = $this->ticketsService->getTicketDataByCode($code);
        } catch (InvalidArgumentException $e) {
            header('Location: ' . url('/tickets/'));
            exit;
        }

        if (empty($data)) {
            header('Location: ' . url('/tickets/'));
            session_destroy();
            exit;
        }


        render('tickets_home', 'main', [
            'pageTitle' => 'My Tickets - St. Thomas Events',
            'code' => $code,
            'data' => $data,
            'QRSource' => (new QRCode)->render($data['Reference'] . ',' . $data['EventId'] . ',' . $data['Email'])
        ]);
    }

    public function partialHomeSeats(string $code): void
    {
        if (!isset($_SESSION['reference']) || $_SESSION['reference'] != $_POST['code']) {
            redirectToUrl(url('/tickets/'));
            exit;
        }

        try {
            $data = $this->ticketsService->getTicketDataByCode($code);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            
        }

        require __DIR__ . '/../views/partials/seats.php';
    }

    public function removeSeat(string $code, string $seat): void
    {
        if (!isset($_SESSION['reference']) || $_SESSION['reference'] != $code) {
            redirectToUrl(url('/tickets/'));
            exit;
        }
        try {
            $this->ticketsService->removeSeatFromBooking($code, $seat);
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }
        header('HX-Trigger: refresh-list');
        header('HX-Success-Message: Seat removed successfully');
        exit;
    }


    public function logout(): void
    {
        session_destroy();
        redirectToUrl($referer = $_SERVER['HTTP_REFERER'] ?? url('/tickets/'));
        exit;
    }

}