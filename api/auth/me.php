<?php
session_start();
header("Access-Control-Allow-Origin: https://db-finalproject.onrender.com");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// ✅ 檢查是否登入
if (!isset($_SESSION['user'])) {
    echo json_encode([
        "success" => false,
        "message" => "尚未登入"
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ✅ 已登入，回傳使用者資訊
echo json_encode([
    "success" => true,
    "user" => $_SESSION['user']
], JSON_UNESCAPED_UNICODE);
