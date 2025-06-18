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

$sql = "
SELECT c.cartID, c.productID, c.quantity, 
       p.name, p.price, p.imagePath
FROM cart c
JOIN product p ON c.productID = p.productID
WHERE c.userID = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$userID]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cartItems);
