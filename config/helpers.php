<?php

declare(strict_types=1);

use Propel\Runtime\ActiveQuery\Criteria;

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
    
    function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    function isAdmin(): bool
    {
        return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
    }

    function ticketAuthenticated(): bool
    {
        return !empty($_SESSION['reference']);
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
        if (empty($_SESSION['reservation_token']) || empty($_SESSION['reservation_expires'])) {
            return false;
        }


        if (date('Y-m-d H:i:s') >= $_SESSION['reservation_expires']) {
            session_unset();
            // $stmt = Database::$con->prepare("DELETE FROM reservation_sessions WHERE expires_at <= NOW()");
            // $stmt->execute();
            // $stmt->close();

            $session = new ReservationSessionsQuery();
            $session->filterByExpiresAt(date('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
            $session->delete();
            return false;
        }

        return true;
    }

    function hasValidBooking(): bool
    {
        if (empty($_SESSION['booking_token']) || empty($_SESSION['code_expires_at'])) {
            return false;
        }

        if (date('Y-m-d H:i:s') >= $_SESSION['code_expires_at']) {
            session_unset();
            // $stmt = Database::$con->prepare("DELETE FROM booking_sessions WHERE code_expires_at <= NOW() AND email_verified = 0");
            // $stmt->execute();
            // $stmt->close();

            $session = new BookingSessionsQuery();
            $session->filterByCodeExpiresAt(date('Y-m-d H:i:s'), Criteria::LESS_EQUAL);
            $session->filterByEmailVerified(false);
            $session->delete();
            return false;
        }

        return true;
    }

    function cancelReservation(): void
    {
        // $stmt = Database::$con->prepare("DELETE FROM reservation_sessions WHERE token = ?");
        // $stmt->bind_param("s", $_SESSION['reservation_token']);
        // $stmt->execute();
        // $stmt->close();

        $session = new ReservationSessionsQuery();
        $session->filterByToken($_SESSION['reservation_token']);
        $session->delete();
        session_destroy();
    }

    function redirectToUrl(string $url): void
    {
        header('HX-Redirect: ' . $url);
        header('Location: ' . $url);
        exit;
    }
}