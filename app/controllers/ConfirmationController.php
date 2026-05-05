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
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }

        $email = $this->confirmationService->getEmailByToken($_SESSION['booking_token']);

        render('event_confirmation', 'seats', [
            'pageTitle' => 'Booking Confirmation - St. Thomas Tickets',
            'eventData' => $event,
            'step' => 3,
            'email' => $email
        ]);
    }

    public function confirmBooking(int|string $id): void
    {
        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('HX-Redirect: ' . url('/404'));
            return;
        }

        $code = $_POST['num1'] . $_POST['num2'] . $_POST['num3'] . $_POST['num4'] . $_POST['num5'] . $_POST['num6'];
        $code = trim($code);
        if ($code == '') {
            http_response_code(400);
            echo "Please enter the confirmation code.";
            return;
        }

        $code = intval($code);

        try {
            $this->confirmationService->confirmBooking(intval($id), $_SESSION['booking_token'], $code);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400);
            echo $exception->getMessage();
            return;
        }

        session_unset();

        header('HX-Redirect: ' . url('/events/' . $id . '/confirmed'));

    }

    public function resendVerification(int|string $id): void
    {
        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 2) {
            redirectToUrl(url('/events/' . $id . '/book'));
            exit;
        }

        if (!hasValidBooking()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $email = $this->confirmationService->getEmailByToken($_SESSION['booking_token']); //FIX:: connect back to boooking serivice for the email, but the validation or maybe new otp can be in confirmation section.
        if (!$email) {
            http_response_code(400);
            echo "No email associated with this booking session.";
            return;
        }

        $name = "Customer"; 
        $otp = rand(100000, 999999); 

        try {
            $this->confirmationService->sendConfirmationEmail($email, $name, $otp);
            echo "Verification code resent successfully.";
        } catch (Exception $e) {
            http_response_code(500);
            echo "Failed to resend verification code. Please try again later.";
        }
    }
}