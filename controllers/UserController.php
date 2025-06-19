<?php
require_once(__DIR__ . '/../models/User.php');

class UserController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new User($conn);
    }

    public function apiLogin($data) {
        $account = $data['account'];
        $password = $data['password'];

        $result = $this->userModel->login($account, $password);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => '✅ 登入成功',
                'user' => $result
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'message' => '帳號或密碼錯誤'
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
