<?php

declare(strict_types=1);

if (!function_exists('basePath')) {

    function basePath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        return rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    }


    define('BASE_PATH', basePath());

    function url($path = ''): string
    {
        return BASE_PATH . '/' . ltrim($path, '/');
    }

    function loggedInOnly(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('HX-Redirect: ' . url('/login'));
            header('Location: ' . url('/login'));
            exit;
        }
    }

    function notLoggedInOnly(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('HX-Redirect: ' . url('/products'));
            header('Location: ' . url('/products'));
            exit;
        }
    }

    function adminOnly(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('HX-Redirect: ' . url('/login'));
            header('Location: ' . url('/login'));
            exit;
        }
    }



    function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    function isAdmin(): bool
    {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
    }

    function csrf_token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    function csrf_input(): string
    {
        return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
    }

    function verify_csrf(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

            if (!$token || !hash_equals($_SESSION['_csrf'], $token)) {
                http_response_code(403);
                echo "Invalid CSRF token";
                exit;
            }
        }
    }

    function render(string $view, string|null $layout, array $data = []): void
    {
        extract($data); // makes variables available in view
        ob_start();
        require __DIR__ . '/../app/views/' . $view . '.php';
        $content = ob_get_clean();
        // Include layout
        if (isset($layout)) {
            require __DIR__ . '/../app/views/layouts/' . $layout . '.php';
        } else {
            echo $content;
        }

    }

    function hasValidReservation(): bool
    {
        if (empty($_SESSION['reservation_token']) || empty($_SESSION['reservation_expires']) || empty($_SESSION['step'])) {
            return false;
        }


        if (date('Y-m-d H:i:s') > $_SESSION['reservation_expires']) {
            clearReservation();
            return false;
        }

        return true;
    }

    function clearReservation(): void
    {
        unset($_SESSION['reservation_token']);
        unset($_SESSION['reservation_expires']);
        unset($_SESSION['step']);
        deleteExpiredReservations();
    }

    function cancelReservation(): void
    {
        $stmt = Database::$con->prepare("DELETE FROM reservation_sessions WHERE token = ?");
        $stmt->bind_param("s", $_SESSION['reservation_token']);
        $stmt->execute();
        $stmt->close();


        unset($_SESSION['reservation_token']);
        unset($_SESSION['reservation_expires']);
        unset($_SESSION['step']);

    }

    function redirectToRightStep(int $event_id): void
    {
        if (!hasValidReservation()) {
            clearReservation();
            header('HX-Redirect: ' . url('/events/' . $event_id . '/seats'));
            header('Location: ' . url('/events/' . $event_id . '/seats'));
            exit;
        }

        if ($_SESSION['step'] == 2) {
            header('HX-Redirect: ' . url('/events/' . $event_id . '/book/'));
            header('Location: ' . url('/events/' . $event_id . '/book/'));
            exit;
        }

        if ($_SESSION['step'] == 3) {
            header('HX-Redirect: ' . url('/events/' . $event_id . '/confirm'));
            header('Location: ' . url('/events/' . $event_id . '/confirm'));
            exit;
        }
    }

    function deleteExpiredReservations(): void
    {
        $stmt = Database::$con->prepare("DELETE FROM reservation_sessions WHERE expires_at < NOW()");
        $stmt->execute();
        $stmt->close();
    }


}