<?php

declare(strict_types=1);

namespace App\Staff\Controllers;

use App\Services\EventService;
use App\Staff\Services\CheckInService;

class CheckInController
{
    private EventService $eventService;
    private CheckInService $checkInService;
    public function __construct()
    {
        $this->eventService = new EventService();
        $this->checkInService = new CheckInService();
    }
    public function index(): void
    {
        $events = $this->eventService->getAllCurrentEvents();
        $seated = array_filter($events, function ($event) {
            return $event['Seating'] === true;
        });

        render('staff/check_in', 'staff', [
            'pageTitle' => 'Check In - St. Thomas Events',
            'events' => $seated,
        ]);


    }

    public function scan(string $id): void
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        render('staff/scan', 'staff', [
            'pageTitle' => 'Scan Tickets - St. Thomas Events',
            'eventData' => $eventData,
            'id' => $id,
            'stats' => $this->checkInService->getCheckInStats(\intval($id)),

        ]);


    }
    public function processScan(string $id): void
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $qr_data = $_POST['data'] ?? null;

        if (empty($qr_data)) {
            http_response_code(400);
            echo 'No QR data provided.';
            return;
        }

        try {
            $checkin = $this->checkInService->processCheckIn(\intval($id), $qr_data);

        } catch (\Exception $e) {
            switch ($e->getMessage()) {
                case 'Booking not found':
                    require __DIR__ . '/../../views/fragments/scan_not_found.php';
                    return;
                case 'Already checked in':

                    require __DIR__ . '/../../views/fragments/scan_checked.php';
                    return;
                case 'Wrong Event':

                    require __DIR__ . '/../../views/fragments/scan_wrong_event.php';
                    return;
                default:
                    http_response_code(500);
                    echo 'An unexpected error occurred.';
                    return;
            }
        }

        if (!$checkin) {
            http_response_code(400);
            echo 'Invalid check-in data.';
            return;

        }

        require __DIR__ . '/../../views/fragments/scan_success.php';
    }

    public function undoScan(string $id): void
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $bookingId = $_POST['id'] ?? null;
        if (empty($bookingId)) {
            http_response_code(400);
            echo 'No booking ID provided.';
            return;
        }

        $seat = $this->checkInService->undoCheckIn(\intval($id), \intval($bookingId));
        if (!$seat) {
            http_response_code(400);
            echo 'Failed to undo check-in.';
            return;
        }

        http_response_code(200);
        header('HX-Success-Message: Check-in for seat ' . $seat . ' has been undone.');
    }
    public function manual(string $id): void
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        render('staff/manual', 'staff', [
            'pageTitle' => 'Manual Check-In - St. Thomas Events',
            'eventData' => $eventData,
            'id' => $id,
            'stats' => $this->checkInService->getCheckInStats(\intval($id)),
        ]);
    }

    public function manualSearch(string $id): void
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $access_code = $_POST['access_code'] ?? null;
        if (empty($access_code)) {
            http_response_code(400);
            echo 'No access code provided.';
            return;
        }

        $booking = $this->checkInService->getBookingByAccessCode($access_code, \intval($id));
        if (!$booking) {
            http_response_code(404);
            echo 'Booking not found for the provided access code.';
            return;
        }

        require __DIR__ . '/../../views/fragments/manual_results.php';
    }

    public function checkInOne(string $id): void //finish
    {
        $eventData = $this->checkInService->getCurrentSeatedEventById(\intval($id));
        if (!$eventData) {
            http_response_code(404);
            header('Location: ' . url('/404/'));
            return;
        }

        $session_id = $_POST['session_id'] ?? null;
        $booking_id = $_POST['booking_id'] ?? null;
        if (empty($session_id) || empty($booking_id)) {
            http_response_code(400);
            echo 'Missing session or booking ID.';
            return;
        }

        try {
            $checkin = $this->checkInService->checkInOne(\intval($id), \intval($session_id), \intval($booking_id));
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
            return;
        }

        if (!$checkin) {
            http_response_code(400);
            echo 'Invalid check-in data.';
            return;
        }

        require __DIR__ . '/../../views/fragments/manual_one.php';
    } 

}