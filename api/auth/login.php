<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://db-finalproject.onrender.com'); // 前端網址
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../controllers/UserController.php');

$controller = new UserController($conn);
$data = json_decode(file_get_contents("php://input"), true);
$controller->apiLogin($data);
