<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');

$userID = $_SESSION['user_id'];

// 取得所有訂單
$stmt = $conn->prepare("
    SELECT orderID, orderDate, totalAmount, status
    FROM [order]
    WHERE userID = ?
    ORDER BY orderDate DESC
");
$stmt->execute([$userID]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 加入每筆訂單的 order_item 明細
foreach ($orders as &$order) {
    $orderID = $order['orderID'];
    $itemStmt = $conn->prepare("
        SELECT oi.productID, oi.quantity, oi.price, p.name, p.imagePath
        FROM order_item oi
        JOIN product p ON oi.productID = p.productID
        WHERE oi.orderID = ?
    ");
    $itemStmt->execute([$orderID]);
    $order['items'] = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($orders);
