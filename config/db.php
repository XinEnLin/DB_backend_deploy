<?php
header('Content-Type: application/json');

// 取得環境變數
$server = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');

try {
    // 使用 PDO_SQLSRV 建立連線
    $dsn = "sqlsrv:Server=$server,$port;Database=$dbName;Encrypt=true;TrustServerCertificate=true";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // 啟用錯誤拋出
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $conn = new PDO($dsn, $dbUser, $dbPass, $options);

    echo json_encode([
        "success" => true,
        "message" => "✅ 成功連線到 SQL Server"
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "❌ 資料庫連線失敗",
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
