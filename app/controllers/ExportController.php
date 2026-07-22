<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ExportService;

require __DIR__ . '/../../config/helpers.php';


class ExportController
{
    private ExportService $exportService;

    public function __construct()
    {
        $this->exportService = new ExportService();
    }

    public function exportPDF($reference): void
    {
        if (!isset($_SESSION['reference']) || $_SESSION['reference'] != $reference) {
            redirectToUrl(url('/tickets/'));
            exit;
        }
        try {
            $pdf = $this->exportService->ticketsToPdf($reference);
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


}
