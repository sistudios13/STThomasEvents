<?php

declare(strict_types=1);

namespace App\Services;

use Dompdf\Dompdf;
use App\Repositories\TicketsRepository;


class ExportService
{

    private $ticketsRepository;

    public function __construct()
    {
        $this->ticketsRepository = new TicketsRepository();
    }
    public function ticketsToPdf($reference): string
    {

        
        $booking = $this->ticketsRepository->getBookingDataByCode($reference);
        $tickets = $this->ticketsRepository->getTicketDataByCode($reference);

        require __DIR__ .'/../views/templates/tickets_pdf.php';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfOutput = $dompdf->output();

        return $pdfOutput;
    }
}