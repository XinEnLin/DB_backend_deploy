<?php
require_once(__DIR__ . '/../models/User.php');

class UserController {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function apiLogin($data) {
        $userModel = new User($this->conn);
        $user = $userModel->login($data['username'], $data['password']);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'] ?? $user['userID'] ?? null;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = ($user['username'] === 'boss') ? 'boss' : 'user';
            echo json_encode([
                'success' => true,
                'message' => '登入成功',
                'role' => $_SESSION['role'],
                'username' => $_SESSION['username']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => '帳號或密碼錯誤']);
        }
    }


    public function apiRegister($data) {
        $user = new User($this->conn);
        $msg = $user->register($data['username'], $data['email'], $data['password'], $data['address'], $data['phone']);
        $success = (strpos($msg, '成功') !== false);
        echo json_encode(['success' => $success, 'message' => $msg]);
    }

    public function apiLogout() {
        session_unset();
        session_destroy();
        echo json_encode(['success' => true, 'message' => '已登出']);
    }
}
