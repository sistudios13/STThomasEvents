<?php

declare(strict_types=1);

require __DIR__ . '/../../config/helpers.php';


class ErrorController
{
    public function notFound(): void
    {
        http_response_code(404);
        render('error/404', null, [
            'pageTitle' => 'Page Not Found - St. Thomas Tickets'
        ]);
    }

    public function forbidden(): void
    {
        http_response_code(403);
        render('error/403', null, [
            'pageTitle' => 'Access Denied - St. Thomas Tickets'
        ]);
    }

    public function internalError(): void
    {
        http_response_code(500);
        render('error/500', null, [
            'pageTitle' => 'Internal Server Error - St. Thomas Tickets'
        ]);
    }
}
    




