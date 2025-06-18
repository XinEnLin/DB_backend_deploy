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
$quantity = $data['quantity'] ?? null;

if (!$cartID || $quantity < 1) {
    echo json_encode(['success' => false, 'message' => '資料不完整']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE [cart] SET quantity = ? WHERE cartID = ?");
    $success = $stmt->execute([$quantity, $cartID]);

    echo json_encode(['success' => $success]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '資料庫錯誤',
        'error' => $e->getMessage()
    ]);
}
