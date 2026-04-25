<?php

require_once __DIR__ . '/../../core/db.php';
class Events
{

    public static function getAll()
    {
        $stmt = Database::$con->prepare("SELECT * FROM events");
        $stmt->execute();
        $r = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $r;

    }

    public static function getById($id)
    {
        $stmt = Database::$con->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $r;

    }
}