<?php

require_once __DIR__ . '/../../core/db.php';
class Products
{

    public static function getAll()
    {
        $stmt = Database::$con->prepare("SELECT * FROM products");
        $stmt->execute();
        $r = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $r;

    }

    public static function create($name, $category, $price)
    {
        $stmt = Database::$con->prepare("INSERT INTO products (name, category, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $category, $price);
        $stmt->execute();
        $stmt->close();
    }

    public static function getById($id)
    {
        $stmt = Database::$con->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        return $product;
    }
}