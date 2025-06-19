<?php
session_start();
header('Content-Type: application/json');
require_once('../../db.php');
require_once('../../controllers/UserController.php');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$userController = new UserController($conn);
$user = $userController->login($email, $password);

if ($user) {
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => '帳號或密碼錯誤']);
}
?>
