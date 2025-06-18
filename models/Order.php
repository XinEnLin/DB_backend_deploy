<?php
require_once(__DIR__ . '/../config/db.php');


class Order {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function createOrder($userID, $totalAmount, $status = 'pending') {
        $stmt = $this->conn->prepare(
            "INSERT INTO [order] (userID, orderDate, totalAmount, status)
             VALUES (?, GETDATE(), ?, ?)"
        );
        $stmt->execute([$userID, $totalAmount, $status]);
        return $this->conn->lastInsertId();
    }

    public function getOrdersByUser($userID) {
        $stmt = $this->conn->prepare("SELECT * FROM [order] WHERE userID = ?");
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
