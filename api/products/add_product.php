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

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'] ?? '';
$price = $data['price'] ?? 0;
$description = $data['description'] ?? '';
$stock = $data['stock'] ?? 0;
$category = $data['category'] ?? '';
$imagePath = $data['imagePath'] ?? '';

if (!$name || !$price) {
    echo json_encode(['success' => false, 'message' => '請填寫商品名稱與價格']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO [product] (name, description, price, stock, category, imagePath) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock, $category, $imagePath]);
    echo json_encode(['success' => true, 'message' => '新增成功']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '新增失敗', 'error' => $e->getMessage()]);
}
