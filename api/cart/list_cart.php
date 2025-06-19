<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../controllers/CartController.php');

$controller = new CartController($conn);
$userID = $_SESSION['user_id'] ?? null;
if (!$userID) {
    exit("請先登入");
}

// ✅ 執行對應方法
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'remove':
            $productID = $_POST['productID'] ?? null;
            $controller->remove($userID, $productID);
            break;
        case 'update':
            $quantities = $_POST['quantities'] ?? [];
            $controller->updateQuantities($userID, $quantities);
            break;
        case 'clear':
            $controller->clear($userID);
            break;
        case 'checkout':
            $controller->checkout($userID);
            break;
        default:
            header("Location: ../layouts/cart_layout.php");
            exit;
    }
}
