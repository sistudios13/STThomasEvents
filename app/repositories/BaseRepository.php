<?php

declare(strict_types= 1);

require_once __DIR__ . '/../../core/db.php';

abstract class BaseRepository
{
    protected $con;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->con = $this->db::$con;
    }
}