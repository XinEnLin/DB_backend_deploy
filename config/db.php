<?php
header('Content-Type: application/json');

$serverName = getenv('DB_HOST') . "," . getenv('DB_PORT');
$connectionOptions = [
    "Database" => getenv('DB_NAME'),
    "Uid" => getenv('DB_USER'),
    "PWD" => getenv('DB_PASS'),
    "Encrypt" => true,
    "TrustServerCertificate" => true
];

$conn = @sqlsrv_connect($serverName, $connectionOptions); // ← 加上 @ 防止 PHP 直接中斷

if (!$conn) {
    $errors = sqlsrv_errors();
    echo json_encode([
        "success" => false,
        "message" => "❌ 資料庫連線失敗",
        "errors" => $errors ? $errors : "無法取得錯誤細節"
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "✅ 成功連線到 SQL Server"
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
