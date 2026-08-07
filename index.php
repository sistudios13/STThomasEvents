<?php

declare(strict_types=1);

namespace App;

ini_set('display_errors', 1);

use FastRoute;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use App\Config\Settings;

require __DIR__ . '/vendor/autoload.php'; // Composer autoload
require __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/generated-conf/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

verify_csrf();


$subfolder = '/stthomas-events';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove subfolder from URI
if (strpos($uri, $subfolder) === 0) {
    $uri = substr($uri, \strlen($subfolder));
}
$uri = '/' . trim($uri, '/'); // normalize

$method = $_SERVER['REQUEST_METHOD'];

// Setup FastRoute
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // get routes
    $r->addRoute('GET', '/', ['InitialController', 'index']);
    $r->addRoute('GET', '/events', ['InitialController', 'events']);
    $r->addRoute('GET', '/events/{id:\d+}', ['InitialController', 'eventDetails']);
    $r->addRoute('GET', '/support', ['SupportController', 'support']);
    $r->addRoute('GET', '/privacy', ['InitialController', 'privacy']);
    $r->addRoute('GET', '/terms', ['InitialController', 'terms']);

    // booking flow
    $r->addRoute('GET', '/events/{id:\d+}/seats', ['ReservationController', 'eventSeats']);
    $r->addRoute('GET', '/events/{id:\d+}/book', ['BookingController', 'eventBooking']);
    $r->addRoute('GET', '/events/{id:\d+}/expired', ['ReservationController', 'eventExpired']);
    $r->addRoute('GET', '/events/{id:\d+}/cancel', ['ReservationController', 'cancelReservation']);
    $r->addRoute('GET', '/events/{id:\d+}/confirm', ['ConfirmationController', 'eventConfirmation']);
    $r->addRoute('GET', '/events/confirmed', ['ConfirmationController', 'eventConfirmed']);

    // tickets view
    $r->addRoute('GET', '/tickets', ['TicketsController', 'ticketsAuth']);
    $r->addRoute('GET', '/tickets/{code:[A-Z0-9]+}', ['TicketsController', 'ticketsHome']);
    $r->addRoute('GET', '/tickets/logout', ['TicketsController', 'logout']);
    $r->addRoute('GET', '/tickets/{reference:[A-Z0-9]+}/export-pdf', ['ExportController', 'exportPDF']);
    $r->addRoute('GET', '/tickets/{reference:[A-Z0-9]+}/calendar', ['ExportController', 'exportICS']);
    $r->addRoute('GET', '/events/passed', ['InitialController', 'eventPassed']);

    // partial routes
    $r->addRoute('POST', '/partials/tickets/{code:[A-Z0-9]+}/home-seats', ['TicketsController', 'partialHomeSeats']);


    // post routes todo:RATELIMIT
    $r->addRoute('POST', '/support/chatbot-request', ['SupportController', 'chatbotRequest']);
    // booking flow
    $r->addRoute('POST', '/events/{id:\d+}/reserve', ['ReservationController', 'reserveSeats']);
    $r->addRoute('POST', '/events/{id:\d+}/book', ['BookingController', 'bookSeats']);
    $r->addRoute('POST', '/events/{id:\d+}/confirm', ['ConfirmationController', 'confirmBooking']);
    $r->addRoute('POST', '/events/{id:\d+}/resend-verification', ['BookingController', 'resendVerification']);

    
    // ticekts view
    $r->addRoute('POST', '/tickets/authenticate', ['TicketsController', 'AuthenticateTickets']);
    $r->addRoute('POST', '/tickets/{code:[A-Z0-9]+}/remove/{seat:[A-Z0-9]+}', ['TicketsController', 'removeSeat']);

    // error routes
    $r->addRoute(['GET', 'DELETE', 'POST', 'PUT'], '/404', ['ErrorController', 'notFound']);
    $r->addRoute('GET', '/403', ['ErrorController', 'forbidden']);
    $r->addRoute(['GET', 'DELETE', 'POST', 'PUT'], '/405', ['ErrorController', 'MethodNotAllowed']);
    $r->addRoute('GET', '/500', ['ErrorController', 'internalError']);


    // auth routes
    $r->addRoute('GET', '/login', ['AuthController', 'login']);
    $r->addRoute('POST', '/auth/login', ['AuthController', 'authenticate']);
    $r->addRoute('GET', '/auth/logout', ['AuthController', 'logout']);
    $r->addRoute('GET', '/auth/deleted', ['AuthController', 'accountDeleted']);

    //staff routes: add 'staff' to array
    

    $r->addRoute('GET', '/staff', ['StaffController', 'index', 'staff']);
    $r->addRoute('GET', '/staff/dashboard', ['StaffController', 'dashboard', 'staff']);
    $r->addRoute('GET', '/staff/settings', ['UserController', 'settings', 'staff']);
    $r->addRoute('GET', '/staff/events', ['StaffController', 'events', 'staff']);
    $r->addRoute('GET', '/staff/events/{id:\d+}', ['StaffController', 'manageEvent', 'staff']);
    $r->addRoute('GET', '/staff/events/{id:\d+}/bookings', ['StaffController', 'bookingsPartial', 'staff']);
    $r->addRoute('DELETE', '/staff/events/{id:\d+}/bookings/{bookingId:\d+}', ['StaffController', 'deleteBooking', 'staff']);

    $r->addRoute('POST', '/staff/settings/change-password', ['UserController', 'changePassword', 'staff']);
    $r->addRoute('POST', '/staff/settings/delete-account', ['UserController', 'deleteAccount', 'staff']);


});

// Dispatch the request
$routeInfo = $dispatcher->dispatch($method, $uri);


switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        redirectToUrl(url('/404/'));
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        header('Allow: ' . implode(', ', $routeInfo[1]));
        redirectToUrl(url('/405/'));
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controllerName, $action] = $handler;
        $controllerSubdir = isset($handler[2]) && $handler[2] === 'staff' ? '/staff' : '';
        $controllerNamespace = isset($handler[2]) && $handler[2] === 'staff'
            ? 'App\\Staff\\Controllers'
            : 'App\\Controllers';
        $controllerClass = $controllerNamespace . '\\' . $controllerName;

        if (isset($handler[2]) && $handler[2] == 'staff') {
            if (!staffAuthenticated()) {
                redirectToUrl(url('/login/'));
                exit;
            }
        }

        $controllerFile = __DIR__ . "/app/controllers{$controllerSubdir}/{$controllerName}.php";
        if (file_exists($controllerFile)) {
            require $controllerFile;
            $controller = new $controllerClass();
            \call_user_func_array([$controller, $action], $vars);
            if (Settings::STAGE === 0) {
                echo '<!-- DEBUG: SESSION DATA -->';
                echo '<pre class="break-all whitespace-pre-wrap bg-gray-100 p-4 rounded-lg text-sm text-gray-800">';
                var_dump($_SESSION);
                echo '</pre>';
            }
        } else {
            http_response_code(500);
            redirectToUrl(url('/500/'));
        }
        break;
}