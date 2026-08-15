<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ExportService;
use App\Services\TicketsService;

require __DIR__ . '/../../config/helpers.php';


class ExportController
{
    private ExportService $exportService;

    private TicketsService $ticketsService;

    public function __construct()
    {
        $this->exportService = new ExportService();
        $this->ticketsService = new TicketsService();
    }

    public function exportPDF($access_code): void
    {
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $access_code) {
            redirectToUrl(url('/tickets/'));
            exit;
        }
        try {
            $pdf = $this->exportService->ticketsToPdf($access_code);
        } catch (\Exception $exception) {
            http_response_code(500);
            echo $exception->getMessage();
            return;
        }

        header('Content-Type: application/pdf');

        header('Content-Disposition: attachment; filename="tickets.pdf"');

        header('Content-Length: ' . \strlen($pdf));

        echo $pdf;
        exit;

    }

    private function ics_escape(string $text): string
    {
        $text = str_replace(['\\', ';', ',', "\r\n", "\n"], ['\\\\', '\\;', '\\,', '\\n', '\\n'], $text);
        return $text;
    }

    private function build_ics_event(array $event): string
    {
        /** @var \DateTime $start */
        $start = $event['start'];
        /** @var \DateTime $end */
        $end = $event['end'];

        return "BEGIN:VCALENDAR\r\n"
            . "VERSION:2.0\r\n"
            . "PRODID:-//Tickets//EN\r\n"
            . "CALSCALE:GREGORIAN\r\n"
            . "METHOD:PUBLISH\r\n"
            . "BEGIN:VEVENT\r\n"
            . "UID:" . $event['uid'] . "\r\n"
            . "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n"
            . "DTSTART:" . $start->format('Ymd\THis\Z') . "\r\n"
            . "DTEND:" . $end->format('Ymd\THis\Z') . "\r\n"
            . "SUMMARY:" . $this->ics_escape($event['title']) . "\r\n"
            . "LOCATION:" . $this->ics_escape($event['location']) . "\r\n"
            . "DESCRIPTION:" . $this->ics_escape($event['description']) . "\r\n"
            . "END:VEVENT\r\n"
            . "END:VCALENDAR\r\n";
    }

    /**
     * Sends the .ics file with the headers iOS needs to trigger
     * the native "Add to Calendar" prompt, then exits. 
     */
    private function send_ics_response(string $icsContent, string $filename): void
    {
        // Trim any  whitespace/output before headers.
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . \strlen($icsContent));
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');

        echo $icsContent;
        exit;
    }

    public function exportICS($access_code): void
    {
        // Uses access_code number rn, but could be changed to require nothing. Could add a calendar button on the event details page
        if (!isset($_SESSION['access_code']) || $_SESSION['access_code'] != $access_code) {
            redirectToUrl(url('/tickets/'));
            exit;
        }

        try {
            $data = $this->ticketsService->getBookingDataByAccessCode($access_code);
        } catch (\InvalidArgumentException $e) {
            header('Location: ' . url('/tickets/'));
            exit;
        }

        if (!$data) {
            http_response_code(404);
            exit('Event not found');
        }

        $tzEvent = new \DateTimeZone('America/New_York');
        $tzUtc = new \DateTimeZone('UTC');

        $dtStartLocal = new \DateTime($data['Events.StartsAt'], $tzEvent);
        $dtEndLocal = new \DateTime($data['Events.EndsAt'], $tzEvent);
        $dtStartUtc = (clone $dtStartLocal)->setTimezone($tzUtc);
        $dtEndUtc = (clone $dtEndLocal)->setTimezone($tzUtc);

        $icsUid = md5($access_code . $data['Events.Name'] . $dtStartUtc->format('U')) . '@tickets';

        $icsContent = $this->build_ics_event([
            'uid' => $icsUid,
            'title' => $data['Events.Name'],
            'location' => $data['Events.Location'],
            'description' => $data['Events.Description'],
            'start' => $dtStartUtc,
            'end' => $dtEndUtc,
        ]);

        $filename = preg_replace('/[^A-Za-z0-9_\-]+/', '_', $data['Events.Name']) . '.ics';

        $this->send_ics_response($icsContent, $filename);
        exit;

    }



}
