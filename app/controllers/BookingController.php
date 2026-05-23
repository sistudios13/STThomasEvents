<?php

declare(strict_types=1);
use Safe\Exceptions\XmlException;


require_once __DIR__ . '/../models/Reservations.php';
require_once __DIR__ . '/../services/BookingService.php';
require_once __DIR__ . '/../services/EventService.php';
require_once __DIR__ . '/../middleware/Throttler.php';
require __DIR__ . '/../../config/helpers.php';

class BookingController
{
    private BookingService $bookingService;
    private EventService $eventService;

    public function __construct()
    {
        $this->bookingService = new BookingService();
        $this->eventService = new EventService();
    }

    public function eventBooking(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        if (!hasValidReservation()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }



        $event = $this->eventService->getEventById(intval($id));
        if (!$event) {
            http_response_code(404);
            header('Location: ' . url('/404'));
            return;
        }

        render('event_booking', 'seats', [
            'pageTitle' => 'Enter Details - St. Thomas Events',
            'eventData' => $event,
            'step' => 2,
            'seats' => $this->eventService->getSeatsByToken(intval($id), $_SESSION['reservation_token'])
        ]);
    }

    public function bookSeats(int|string $id): void
    {

        if (!isset($_SESSION['step'])) {
            redirectToUrl(url('/events/' . $id . '/seats/'));
            exit;
        }

        if (isset($_SESSION['step']) && $_SESSION['step'] == 3) {
            redirectToUrl(url('/events/' . $id . '/confirm'));
            exit;
        }

        if (!hasValidReservation()) {
            redirectToUrl(url('/events/' . $id . '/expired'));
            exit;
        }

        $event = $this->eventService->getEventById(intval($id));

        if (!$event) {
            http_response_code(404);
            header('HX-Redirect: ' . url('/404'));
            return;
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $role = trim($_POST['role']);

        try {
            $booking = $this->bookingService->bookSeats(intval($id), $name, $email, $phone, $role);
        } catch (Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }

        if (!$booking) {
            http_response_code(400);
            echo 'Failed to create booking.';
            return;
        }

        session_unset();
        $_SESSION['step'] = 3;
        $_SESSION['booking_token'] = $booking->token;
        $_SESSION['code_expires_at'] = $booking->code_expires_at;

        header('HX-Redirect: ' . url('/events/' . $id . '/confirm'));
    }

    public function resendVerification(int|string $id): void // confirmation section but wtv
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


        // limit resend attempts to 3 per booking
        $limiter = new AttemptLimiter($_SESSION['booking_token'], 3);
        $attempts_left = $limiter->verify();

        if ($attempts_left === false) {
            http_response_code(400);
            echo 'Too many resend attempts. Start the booking process again, or contact support.';
            return;
        }



        try {
            $info = $this->bookingService->getResendInfoByToken($_SESSION['booking_token']);
        } catch (Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }

        try {
            $this->bookingService->sendConfirmationEmail($info['Email'], $info['Name'], $info['VerificationCode']);
        } catch (Exception $exception) {
            http_response_code(400);
            echo $exception->getMessage() ?? 'An Error Occurred';
            return;
        }

        header('HX-Success-Message: Verification code resent successfully. ' . $attempts_left . ' attempts remaining.');
        exit;
    }




}
