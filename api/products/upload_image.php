<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'boss') {
    echo json_encode(['success' => false, 'message' => '權限不足']);
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => '上傳失敗或未選擇圖片']);
    exit;
}

// ✅ 檢查圖片 MIME 類型
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($_FILES['image']['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => '只允許上傳 PNG / JPG / GIF 圖片']);
    exit;
}

// ✅ 檢查資料夾是否存在
$uploadDir = __DIR__ . '/../../../../frontend/public/images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// ✅ 產生乾淨檔名
$filename = str_replace(' ', '_', basename($_FILES['image']['name']));
$targetPath = $uploadDir . $filename;

if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'path' => '/images/' . $filename
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'move_uploaded_file 失敗']);
}
