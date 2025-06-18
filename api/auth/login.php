<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../controllers/UserController.php');

$data = json_decode(file_get_contents('php://input'), true);
$controller = new UserController($conn);
$controller->apiLogin($data);
