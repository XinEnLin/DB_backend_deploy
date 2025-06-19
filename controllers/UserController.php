<?php
require_once(__DIR__ . '/../models/User.php');

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function apiLogin($data) {
        $account = $data['account'] ?? null;
        $password = $data['password'] ?? null;

        if (!$account || !$password) {
            echo json_encode(["success" => false, "message" => "請提供帳號與密碼"]);
            return;
        }

        $user = $this->user->login($account, $password);

        if ($user) {
            echo json_encode(["success" => true, "message" => "✅ 登入成功", "user" => $user]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ 帳號或密碼錯誤"]);
        }
    }
}
