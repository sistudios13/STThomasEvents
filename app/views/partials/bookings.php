<?php

declare(strict_types=1);

$isHx = isset($_SERVER['HTTP_HX_REQUEST']);

if ($isHx || isset($bookings)) {

    require __DIR__ . '/../fragments/event_bookings_table.php';
    if ($isHx) {
        exit;
    }
} else {
    redirectToUrl(url('/404'));
}