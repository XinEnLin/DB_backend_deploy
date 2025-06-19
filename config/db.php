<?php
<<<<<<< HEAD
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
=======
// $serverName = "157.230.191.17";
$serverName = "157.230.191.17,1433";
$database = "DB_finalProject";
$username = "sa";
$password = "77888787xxx";

try {
    // 建立 PDO 連線
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    
    // 設定錯誤模式為拋出例外
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 如果需要設定編碼（sqlsrv 不需要設定 utf8）
    // $conn->exec("SET NAMES 'utf8'");

    // 可以寫 log 或測試
    // echo "✅ 成功連線到 SQL Server";
} catch (PDOException $e) {
     // 連線錯誤直接回傳 JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => '資料庫連線失敗']);
    exit;
>>>>>>> parent of f1547fe (update db.php)
}
?>
