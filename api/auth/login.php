<?php
require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../controllers/UserController.php');

header("Access-Control-Allow-Origin: https://db-finalproject.onrender.com");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// ✅ 修正：接收 JSON 格式的請求內容
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['account']) || !isset($input['password'])) {
    echo json_encode([
        'success' => false,
        'message' => '請提供帳號與密碼'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$controller = new UserController($conn);
$controller->apiLogin($input);
