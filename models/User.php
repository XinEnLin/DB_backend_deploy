<?php
class User {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function login($account, $password) {
        $sql = "SELECT * FROM users WHERE account = :account AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':account', $account);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
