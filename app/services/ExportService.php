<?php

declare(strict_types=1);

namespace App\Services;

use Dompdf\Dompdf;
use App\Repositories\TicketsRepository;
use App\Staff\Repositories\ManagementRepository;


class ExportService
{

    private $ticketsRepository;
    private $managementRepository;

    public function __construct()
    {
        $this->ticketsRepository = new TicketsRepository();
        $this->managementRepository = new ManagementRepository();
    }
    public function ticketsToPdf($access_code): string
    {


        $booking = $this->ticketsRepository->getBookingDataByAccessCode($access_code);
        $tickets = $this->ticketsRepository->getTicketDataByAccessCode($access_code);

        require __DIR__ . '/../views/templates/tickets_pdf.php';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfOutput = $dompdf->output();

        return $pdfOutput;
    }

    public function bookingsToCsv(int $event_id): string
    {
        $bookings = $this->managementRepository->getBookings($event_id, 1, null, 'timestamp', 'desc', 999);

        $csvOutput = "Booking ID,Name,Email,Phone,Role,Access Code,Status,Seats,Timestamp\n";

        foreach ($bookings as $booking) {
            $status = $booking['EmailVerified'] ? 'Verified' : 'Pending';
            $seats = !empty($booking['seats']) ? implode('; ', $booking['seats']) : '';
            $ts = date('Y-m-d g:iA', strtotime($booking['Timestamp']));
            $csvOutput .= "{$booking['Id']},\"{$booking['Name']}\",\"{$booking['Email']}\",\"{$booking['Phone']}\",\"{$booking['Role']}\",\"{$booking['AccessCode']}\",\"{$status}\",\"{$seats}\",\"{$ts}\"\n";
        }

        return $csvOutput;
    }
}