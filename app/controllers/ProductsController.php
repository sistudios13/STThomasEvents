<?php

require_once __DIR__ . '/../models/Products.php';
require __DIR__ . '/../../vendor/autoload.php';

use Respect\Validation\Validator as v;

class ProductsController { 

    private function render($view, $data = [])
    {
        extract($data); // makes variables available in view
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        // Include layout
        require __DIR__ . '/../views/layouts/main.php';
    }
    public function index() {
        $this->render('products', [
            'pageTitle' => 'All Products',
            'productsData' => Products::getAll()
        ]);
    }

    public function new() {
        adminOnly();
        $this->render('new_product', [
            'pageTitle' => 'Add New Product'
        ]);
    }

    public function show($id) {
        $this->render('product', [
            'pageTitle' => 'Product Details',
            'product' => Products::getById($id)
        ]);
    }

    public function addProduct() {
        $name = trim($_POST['name']);
        $price = trim($_POST['price']);
        $category = trim($_POST['category']);

        if (!v::length(2, 100)->validate($name)) {
            http_response_code(400);
            echo 'Product Name has to be between 2 and 100 characters long!';
            return;
        }

        if (!v::numericVal()->positive()->validate($price)) {
            http_response_code(400);
            echo 'Price must be a positive number!';
            return;
        }


        if (!v::length(2, 100)->validate($category)) {
            http_response_code(400);
            echo 'Category must be between 2 and 100 characters long!';
            return;
        }

        Products::create($name, $category, $price);
        header('HX-Redirect: ' . url('/products'));
        exit;
    }
}