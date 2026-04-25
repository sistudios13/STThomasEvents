
<?php

if (!function_exists('basePath')) {

function basePath() {
    $scriptName = $_SERVER['SCRIPT_NAME']; 
    return rtrim(str_replace('\\', '/', dirname($scriptName)), '/'); 
}


define('BASE_PATH', basePath());

function url($path = '') {
    return BASE_PATH . '/' . ltrim($path, '/');
}

function loggedInOnly() {
    if (!isset($_SESSION['user_id'])) {
        header('HX-Redirect: ' . url('/login'));
        header('Location: ' . url('/login'));
        exit;
    }
}

function notLoggedInOnly() {
    if (isset($_SESSION['user_id'])) {
        header('HX-Redirect: ' . url('/products'));
        header('Location: ' . url('/products'));
        exit;
    }
}

function adminOnly() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('HX-Redirect: ' . url('/login'));
        header('Location: ' . url('/login'));
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
}

function csrf_token() {
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_input() {
    return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
}

function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

        if (!$token || !hash_equals($_SESSION['_csrf'], $token)) {
            http_response_code(403);
            echo "Invalid CSRF token";
            exit;
        }
    }
}

function render($view, $layout, $data = [])
    {
        extract($data); // makes variables available in view
        ob_start();
        require __DIR__ . '/../app/views/' . $view . '.php';
        $content = ob_get_clean();
        // Include layout
        require __DIR__ . '/../app/views/layouts/' . $layout . '.php';
    }

}