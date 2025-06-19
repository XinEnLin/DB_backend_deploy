<?php
require_once(__DIR__ . '/../models/User.php');

class UserController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        $userModel = new User($this->conn);
        return $userModel->authenticate($email, $password);
    }
}
?>
