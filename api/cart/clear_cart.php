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

$userID = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("DELETE FROM [cart] WHERE userID = ?");
    $success = $stmt->execute([$userID]);

    echo json_encode(['success' => $success]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => '清空失敗',
        'error' => $e->getMessage()
    ]);
}
