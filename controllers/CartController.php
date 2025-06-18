<?php
require_once(__DIR__ . '/../src/Cart.php');

class CartController {
    private $cart;

    public function __construct($conn) {
        $this->cart = new Cart($conn);
    }

    public function add($userID, $data) {
        $productID = $data['productID'];
        $quantity = (int) $data['quantity'];

        $this->cart->AddCart($userID, $productID, $quantity);
    }

    public function remove($userID, $productID) {
        $this->cart->RemoveCart($userID, $productID);
        header("Location: ../layouts/cart_layout.php");
        exit;
    }

    public function updateQuantities($userID, $quantities) {
    foreach ($quantities as $pid => $qty) {
        $this->cart->updateQuantity($userID, $pid, $qty);
    }
    header("Location: ../layouts/cart_layout.php");
    exit;
}

    public function clear($userID) {
        $this->cart->clear($userID);
        header("Location: ../layouts/cart_layout.php");
        exit;
    }

    public function checkout($userID) {
        $this->cart->checkout($userID);
        $_SESSION['checkout_message'] = "✅ 結帳成功，感謝您的購買！";
        header("Location: ../layouts/cart_layout.php");
        exit;
    }

    public function getItems($userID) {
        return $this->cart->getAll($userID);
    }

    public function getTotal($userID) {
        return $this->cart->getTotal($userID);
    }
}
