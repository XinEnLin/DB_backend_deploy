<?php
require_once(__DIR__ . '/../models/Product.php');

class ProductController {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllProducts() {
        $product = new Product($this->conn);
        return $product->getAll();
    }
}
