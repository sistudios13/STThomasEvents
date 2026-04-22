<?php

require_once __DIR__ . '/../../core/db.php';

class Users
{
    public static function getByEmail($email)
    {
        $stmt = Database::$con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public static function getByUsername($username)
    {
        $stmt = Database::$con->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public static function create($username, $email, $hashedpassword)
    {

        if (self::getByEmail($email)) {
            http_response_code(400);
            echo 'Email already exists!';
            return;
        }
        if (self::getByUsername($username)) {
            http_response_code(400);
            echo 'Username already exists!';
            return;
        }
        $stmt = Database::$con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedpassword);
        $stmt->execute();
        $stmt->close();
    }

    public static function authenticate($email, $password)
    {
        $user = self::getByEmail($email);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}