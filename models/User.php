<?php
class User {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM [user] WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($username, $email, $password, $address, $phone) {
        // 檢查是否重複
        $stmt = $this->conn->prepare("SELECT * FROM [user] WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) return "帳號已存在";
        // 註冊
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO [user] (username, email, password, address, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hash, $address, $phone]);
        return "註冊成功";
    }
}
