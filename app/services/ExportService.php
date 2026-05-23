<?php

declare(strict_types=1);

use Dompdf\Dompdf;

require_once __DIR__ .'/../repositories/TicketsRepository.php';


class ExportService
{

    private $ticketsRepository;

    public function __construct()
    {
        $this->ticketsRepository = new TicketsRepository();
    }
    public function ticketsToPdf($reference): string
    {

        // $tickets = [
        //     ['seat' => 'A12', 'token' => 'TK-83HD92', 'name' => 'John Doe'],
        //     ['seat' => 'A13', 'token' => 'TK-18SK21', 'name' => 'John Doe'],
        //     ['seat' => 'A14', 'token' => 'TK-72PQ11', 'name' => 'John Doe'],
        //     ['seat' => 'A14', 'token' => 'TK-72PQ11', 'name' => 'John Doe'],
        //     ['seat' => 'A14', 'token' => 'TK-72PQ11', 'name' => 'John Doe'],
        // ];
        
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