<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config');
$dotenv->load();

class Database
{

    public static $con;

    public static function init()
    {
        if (self::$con === null) {
            self::$con = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
            if (!self::$con) {
                die('Database connection error: ' . mysqli_connect_error());
            }
        }
    }
}

Database::init();