<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../controllers/ProductController.php');

$controller = new ProductController($conn);
echo json_encode($controller->getAllProducts());
