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
$orderID = $data['orderID'] ?? null;
$status = $data['status'] ?? null;

if (!$orderID || !$status) {
    echo json_encode(['success' => false, 'message' => '資料不完整']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE [order] SET status = ? WHERE orderID = ?");
    $success = $stmt->execute([$status, $orderID]);

    echo json_encode(['success' => $success]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '資料庫錯誤',
        'error' => $e->getMessage()
    ]);
}
