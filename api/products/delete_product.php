<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'boss') {
    echo json_encode(['success' => false, 'message' => '權限不足']);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);
$productID = $data['productID'] ?? null;

if (!$productID) {
    echo json_encode(['success' => false, 'message' => '缺少商品 ID']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM [product] WHERE productID = ?");
    $success = $stmt->execute([$productID]);

    echo json_encode([
        'success' => $success,
        'message' => $success ? '商品刪除成功' : '商品刪除失敗'
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '資料庫錯誤',
        'error' => $e->getMessage()
    ]);
    exit;
}
