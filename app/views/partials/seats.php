<?php

declare(strict_types= 1);

$isHx = isset($_SERVER['HTTP_HX_REQUEST']);

require_once __DIR__ . '/../../services/TicketsService.php';


if ($isHx) {

    if (empty($data)) {
        header('HX-Redirect: ' . url('/404'));
        session_destroy();
        exit;
    }

    $seats = explode(',', $data['Seats']);

    

    require __DIR__ . '/../fragments/tickets_home_seats.php';
    exit;
} else {
    redirectToUrl(url('/404'));
}