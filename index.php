<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload
require __DIR__ . '/config/helpers.php';
session_start();
verify_csrf();

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;


$subfolder = '/stthomas-tickets';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove subfolder from URI
if (strpos($uri, $subfolder) === 0) {
    $uri = substr($uri, strlen($subfolder));
}
$uri = '/' . trim($uri, '/'); // normalize

$method = $_SERVER['REQUEST_METHOD'];

// Setup FastRoute
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // get routes
    $r->addRoute('GET', '/', ['InitialController', 'index']);
    $r->addRoute('GET', '/events', ['InitialController', 'events']);
    $r->addRoute('GET', '/events/{id:\d+}', ['InitialController', 'eventDetails']);
    $r->addRoute('GET', '/events/{id:\d+}/seats', ['BookingController', 'eventSeats']);
    $r->addRoute('GET', '/events/{id:\d+}/book', ['BookingController', 'eventBooking']);



    // post routes
    $r->addRoute('POST', '/dashboard/add-user', ['DashboardController', 'addUser']);
    $r->addRoute('POST', '/events/{id:\d+}/reserve', ['BookingController', 'reserveSeats']);

});

// Dispatch the request
$routeInfo = $dispatcher->dispatch($method, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        header('Location: ' . $subfolder . '/404.html');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(403);
        header('Location: ' . $subfolder . '/403.html');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controllerName, $action] = $handler;

        $controllerFile = __DIR__ . "/app/controllers/$controllerName.php";
        if (file_exists($controllerFile)) {
            require $controllerFile;
            $controller = new $controllerName();
            call_user_func_array([$controller, $action], $vars);
        } else {
            http_response_code(500);
            header('Location: ' . $subfolder . '/500.html');
        }
        break;
}