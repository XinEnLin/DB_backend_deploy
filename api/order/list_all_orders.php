<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'boss') {
    echo json_encode([]);
    exit;
}

require_once(__DIR__ . '/../../config/db.php');

$stmt = $conn->prepare("
    SELECT o.orderID, o.orderDate, o.totalAmount, o.status, u.username
    FROM [order] o
    JOIN [user] u ON o.userID = u.userID
    ORDER BY o.orderDate DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 加上每筆訂單明細
foreach ($orders as &$order) {
    $stmtItem = $conn->prepare("
        SELECT oi.productID, oi.quantity, oi.price, p.name, p.imagePath
        FROM order_item oi
        JOIN product p ON oi.productID = p.productID
        WHERE oi.orderID = ?
    ");
    $stmtItem->execute([$order['orderID']]);
    $order['items'] = $stmtItem->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($orders);
