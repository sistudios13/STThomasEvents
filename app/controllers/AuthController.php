<?php

require_once __DIR__ . '/../models/Users.php';
require __DIR__ . '/../../vendor/autoload.php';

use Respect\Validation\Validator as v;


class AuthController
{
    private function render($view, $data = [])
    {
        extract($data); // makes variables available in view
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        // Include layout
        require __DIR__ . '/../views/layouts/main.php';
    }
    public function login_form()
    {
        NotLoggedInOnly();
        $this->render('login_form', [
            'pageTitle' => 'Login'
        ]);
    }

    public function register_form()
    {
        NotLoggedInOnly();
        $this->render('register_form', [
            'pageTitle' => 'Register'
        ]);
    }

    public function register()
    {

        NotLoggedInOnly();

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!v::alnum()->noWhitespace()->length(3, 20)->validate($username)) {
            http_response_code(400);
            echo 'Username must be alphanumeric, without spaces, and between 3 and 20 characters long!';
            return;
        }

        if (!v::email()->validate($email)) {
            http_response_code(400);
            echo 'Invalid email address!';
            return;
        }

        if (!v::length(6, null)->validate($password)) {
            http_response_code(400);
            echo 'Password must be at least 6 characters long!';
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        Users::create($username, $email, $hashedPassword);

        header('HX-Redirect: ' . url('/login'));
        exit;
    }

    public function login()
    {

        NotLoggedInOnly();

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!v::notEmpty()->validate($email)) {
            http_response_code(400);
            echo 'Email and password are required.';
            return;
        }

        if (!v::notEmpty()->validate($password)) {
            http_response_code(400);
            echo 'Email and password are required.';
            return;
        }

        $user = Users::authenticate($email, $password);

        if (!$user) {
            http_response_code(400);
            echo 'Invalid email or password.';
            return;
        }

        
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        header('HX-Redirect: ' . url('/products'));
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . url('/login'));
        exit;
    }
}