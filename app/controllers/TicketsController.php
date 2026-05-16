<?php

declare(strict_types=1);



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
        render('tickets_auth', 'main', [
            'pageTitle' => 'My Tickets - St. Thomas Events'
        ]);
    }
}