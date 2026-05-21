<?php

declare(strict_types= 1);

$isHx = isset($_SERVER['HTTP_HX_REQUEST']);



if ($isHx) {

    if (empty($tickets)) {
        session_destroy();
        header('HX-Redirect: ' . url('/tickets/'));
        
        exit;
    }

    require __DIR__ . '/../fragments/tickets_home_tickets.php';
    exit;
} else {
    redirectToUrl(url('/404'));
}