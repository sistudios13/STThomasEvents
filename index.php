<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload
require __DIR__ . '/config/helpers.php';
session_start();
verify_csrf();

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;


$subfolder = '/php-shop';
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
    $r->addRoute('GET', '/', ['HomeController', 'index']);
    $r->addRoute('GET', '/dashboard', ['DashboardController', 'index']);
    $r->addRoute('GET', '/dashboard/users', ['DashboardController', 'users']);
    $r->addRoute('GET', '/products', ['ProductsController', 'index']);
    $r->addRoute('GET', '/products/new', ['ProductsController', 'new']);
    $r->addRoute('GET', '/products/{id:\d+}', ['ProductsController', 'show']);
    $r->addRoute('GET', '/login', ['AuthController', 'login_form']);
    $r->addRoute('GET', '/register', ['AuthController', 'register_form']);
    $r->addRoute('GET', '/logout', ['AuthController', 'logout']);


    // post routes
    $r->addRoute('POST', '/dashboard/add-user', ['DashboardController', 'addUser']);
    $r->addRoute('POST', '/products/new', ['ProductsController', 'addProduct']);
    $r->addRoute('POST', '/login', ['AuthController', 'login']);
    $r->addRoute('POST', '/register', ['AuthController', 'register']);

});

// Dispatch the request
$routeInfo = $dispatcher->dispatch($method, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        header('Location: /php-shop/404.html');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "Method not allowed";
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
            echo "Controller $controllerName not found";
        }
        break;
}