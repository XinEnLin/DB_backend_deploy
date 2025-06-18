<?php
require_once(__DIR__ . '/../config/db.php');

class Cart {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function getAllCarts() {
        $sql = "SELECT * FROM cart";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartByID($id) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE cartID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ 新增商品（如已存在則加總數量）
    public function AddCart($userID, $productID, $quantity) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE userID = ? AND productID = ?");
        $stmt->execute([$userID, $productID]);
        if ($stmt->fetch()) {
            $update = $this->conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE userID = ? AND productID = ?");
            return $update->execute([$quantity, $userID, $productID]);
        } else {
            $insert = $this->conn->prepare("INSERT INTO cart (userID, productID, quantity) VALUES (?, ?, ?)");
            return $insert->execute([$userID, $productID, $quantity]);
        }
    }

    // ✅ 刪除單筆購物車商品
    public function RemoveCart($userID, $productID) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE userID = ? AND productID = ?");
        return $stmt->execute([$userID, $productID]);
    }

    // ✅ 取得該使用者的購物車內容
    public function getAll($userID) {
        $stmt = $this->conn->prepare("
            SELECT c.productID, p.name, p.price, c.quantity
            FROM cart c
            JOIN product p ON c.productID = p.productID
            WHERE c.userID = ?
        ");
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ 清空購物車
    public function clear($userID) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE userID = ?");
        return $stmt->execute([$userID]);
    }

    // ✅ 計算總金額
    public function getTotal($userID) {
        $stmt = $this->conn->prepare("
            SELECT SUM(p.price * c.quantity) AS total
            FROM cart c
            JOIN product p ON c.productID = p.productID
            WHERE c.userID = ?
        ");
        $stmt->execute([$userID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // ✅ 更新商品數量
    public function updateQuantity($userID, $productID, $quantity) {
        $stmt = $this->conn->prepare("UPDATE cart SET quantity = ? WHERE userID = ? AND productID = ?");
        return $stmt->execute([$quantity, $userID, $productID]);
    }


    // ✅ 結帳（清空購物車，實際可擴充為建立訂單）
    public function checkout($userID) {
        // 這裡簡單清空購物車
        return $this->clear($userID);
    }
        
}
?>
