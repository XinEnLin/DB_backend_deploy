<?php
$host = 'localhost';                 // 通常是 localhost
$dbname = 'DB_finalProject';         // 改成你的資料庫名稱
$username = 'sa';                    // SQL Server 帳號
$password = '77888787xxx';         // SQL Server 密碼

try {
    $conn = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 若要 UTF-8 請確認資料表是 nvarchar 或 ntext 格式
} catch (PDOException $e) {
    die("連線失敗: " . $e->getMessage());
}
?>
