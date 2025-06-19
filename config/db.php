<?php
header('Content-Type: application/json');

$serverName = getenv('DB_HOST');
$port = getenv('DB_PORT');
$database = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');

$dsn = "sqlsrv:Server=$serverName,$port;Database=$database;Encrypt=yes;TrustServerCertificate=yes"; // 加上 TrustServerCertificate=yes

try {
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "❌ 資料庫連線失敗",
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>
