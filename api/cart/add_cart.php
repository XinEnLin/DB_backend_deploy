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
$userID = $_SESSION['user_id'];
$productID = $data['productID'] ?? null;
$quantity = $data['quantity'] ?? 1;

if (!$productID) {
    echo json_encode(['success' => false, 'message' => '缺少商品資訊']);
    exit;
}

try {
    // 若已加入則更新數量，否則新增
    $checkStmt = $conn->prepare("SELECT * FROM [cart] WHERE userID = ? AND productID = ?");
    $checkStmt->execute([$userID, $productID]);

    if ($checkStmt->fetch()) {
        // 已存在 → 更新數量
        $updateStmt = $conn->prepare("UPDATE [cart] SET quantity = quantity + ? WHERE userID = ? AND productID = ?");
        $updateStmt->execute([$quantity, $userID, $productID]);
    } else {
        // 不存在 → 新增
        $insertStmt = $conn->prepare("INSERT INTO [cart] (userID, productID, quantity) VALUES (?, ?, ?)");
        $insertStmt->execute([$userID, $productID, $quantity]);
    }

    echo json_encode(['success' => true, 'message' => '已加入購物車']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '寫入失敗', 'error' => $e->getMessage()]);
}
