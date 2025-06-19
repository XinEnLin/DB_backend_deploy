<?php
session_start();
header("Access-Control-Allow-Origin: *"); // 允許跨來源（可限制為你的前端網址）
header("Access-Control-Allow-Credentials: true"); // 支援跨域 cookie
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
