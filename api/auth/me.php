<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://db-finalproject.onrender.com'); // 前端網址
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../models/User.php');

$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

if (!$authHeader) {
    echo json_encode([
        "success" => false,
        "message" => "⚠️ 缺少授權資訊"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// 假設 Authorization 裡直接存帳號，例如：Authorization: Bearer boss
$parts = explode(" ", $authHeader);
if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
    echo json_encode([
        "success" => false,
        "message" => "⚠️ 授權格式錯誤"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$account = $parts[1];

try {
    $userModel = new User($conn);

    $sql = "SELECT * FROM users WHERE account = :account";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':account', $account);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode([
            "success" => true,
            "user" => $user
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "❌ 查無此用戶"
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "❌ 查詢過程錯誤",
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
