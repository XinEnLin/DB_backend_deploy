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

// 嘗試連線 SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// 檢查連線狀態
if (!$conn) {
    $errors = sqlsrv_errors();
    echo json_encode([
        "success" => false,
        "message" => "❌ 資料庫連線失敗",
        "errors" => $errors  // 印出完整錯誤細節
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// 成功連線
echo json_encode([
    "success" => true,
    "message" => "✅ 成功連線到 SQL Server"
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
