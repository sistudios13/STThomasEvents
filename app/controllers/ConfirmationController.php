<?php

declare(strict_types=1);


require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/ConfirmationService.php';
require_once __DIR__ . '/../services/EventService.php';
require __DIR__ . '/../../config/helpers.php';

class ConfirmationController
{
    private ConfirmationService $confirmationService;
    private EventService $eventService;

    public function __construct()
    {
        $this->confirmationService = new ConfirmationService();
        $this->eventService = new EventService();
    }

    public function eventConfirmation(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book/'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired/'));
            exit;
        }

        $event = $this->eventService->getSeatedEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $email = $this->confirmationService->getEmailByToken($_SESSION['booking_token']);

        render('event_confirmation', 'seats', [
            'pageTitle' => 'Booking Confirmation - St. Thomas Events',
            'eventData' => $event,
            'step' => 3,
            'email' => $email
        ]);
    }

    public function confirmBooking(int|string $id): void
    {
        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book/'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired/'));
            exit;
        }

        $event = $this->eventService->getSeatedEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('HX-Redirect: ' . url('/404/'));
            return;
        }

        $code = $_POST['num1'] . $_POST['num2'] . $_POST['num3'] . $_POST['num4'] . $_POST['num5'] . $_POST['num6'];
        $code = trim($code);
        if ($code == '') {
            http_response_code(400);
            echo "Please enter the confirmation code.";
            return;
        }

        if (strlen($code) != 6 || !ctype_digit($code)) {
            http_response_code(400);
            echo "Invalid code format. Please enter a 6-digit code.";
            return;
        }

        $code = intval($code);

        //ratelimit

        try {
            $redirectInfo = $this->confirmationService->confirmBooking(intval($id), $_SESSION['booking_token'], $code);
        } catch (Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }

        session_unset();
        header('HX-Redirect: ' . url('/events/confirmed/?code=' . htmlspecialchars(strval($redirectInfo[0])) . '&email=' . htmlspecialchars(strval($redirectInfo[1])))); 

    }


    public function eventConfirmed(): void
    {
        render('event_confirmed', null, [
            'pageTitle' => 'Booking Confirmed - St. Thomas Events'
        ]);
    }
}