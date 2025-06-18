<?php
require_once(__DIR__ . '/../config/db.php');


class OrderItem {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function addItem($orderID, $productID, $quantity, $price) {
        $stmt = $this->conn->prepare(
            "INSERT INTO order_item (orderID, productID, quantity, price)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$orderID, $productID, $quantity, $price]);
    }

    public function getItemsByOrder($orderID) {
        $stmt = $this->conn->prepare(
            "SELECT oi.*, p.name 
             FROM order_item oi 
             JOIN product p ON oi.productID = p.productID 
             WHERE oi.orderID = ?"
        );
        $stmt->execute([$orderID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
