<?php
require_once(__DIR__ . '/../controllers/CartController.php');
$cart = new CartController($conn);

$userID = $_SESSION['user_id'] ?? null;
if (!$userID) {
    echo "<p class='center' style='color:red;'>請先登入才能操作購物車</p>";
    return;
}

$items = $cart->getItems($userID);
$total = $cart->getTotal($userID);
?>

<?php if (!empty($items)): ?>
    <table class="cart-table">
        <tr>
            <th>商品名稱</th>
            <th>單價</th>
            <th>數量</th>
            <th>小計</th>
            <th>操作</th>
        </tr>
        <?php foreach ($items as $productID => $item): ?>
            <tr>
                <form method="post" action="../public/list_cart.php">
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" name="quantities[<?php echo $productID; ?>]" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                    </td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <input type="hidden" name="productID" value="<?php echo $productID; ?>">
                        <button type="submit" name="action" value="remove" class="btn-cart">❌ 移除</button>
                        <button type="submit" name="action" value="update" class="btn-cart">✅ 更新</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">總金額</td>
            <td colspan="2" class="total">$<?php echo number_format($total, 2); ?></td>
        </tr>
    </table>
<?php else: ?>
    <p class="center" style="color:gray;">🛒 目前購物車是空的</p>
<?php endif; ?>
