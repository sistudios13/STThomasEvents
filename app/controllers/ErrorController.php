<?php

declare(strict_types=1);


require __DIR__ . '/../../config/helpers.php';


class ErrorController
{
    public function notFound(): void
    {
        http_response_code(404);
        render('error/404', null, [
            'pageTitle' => 'Page Not Found - St. Thomas Events'
        ]);
    }

    public function forbidden(): void
    {
        render('error/403', null, [
            'pageTitle' => 'Access Denied - St. Thomas Events'
        ]);
    }

    public function internalError(): void
    {
        http_response_code(500);
        render('error/500', null, [
            'pageTitle' => 'Internal Server Error - St. Thomas Events'
        ]);
    }

    public function methodNotAllowed(): void
    {
        http_response_code(405);
        render('error/405', null, [
            'pageTitle' => 'Method Not Allowed - St. Thomas Events'
        ]);
    }
}
    




