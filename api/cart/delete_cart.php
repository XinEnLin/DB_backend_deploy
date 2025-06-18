<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => '尚未登入']);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);
$cartID = $data['cartID'] ?? null;

if (!$cartID) {
    echo json_encode(['success' => false, 'message' => '缺少 cartID']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM [cart] WHERE cartID = ?");
    $success = $stmt->execute([$cartID]);

    echo json_encode(['success' => $success]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '資料庫錯誤',
        'error' => $e->getMessage()
    ]);
}
