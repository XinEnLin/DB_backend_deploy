<?php
require_once(__DIR__ . '/../controllers/ProductController.php');
require_once(__DIR__ . '/../controllers/CartController.php');

$productController = new ProductController($conn);
$cartController = new CartController($conn);


$products = $productController->getAll();
?>

<h2>📦 商品列表</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>圖片</th><th>名稱</th><th>描述</th><th>價格</th><th>庫存</th><th>分類</th><th>操作</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><img src="../asset/images/<?php echo htmlspecialchars($product['imagePath']); ?>" height="80"></td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['description']); ?></td>
            <td>$<?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo $product['stock']; ?></td>
            <td><?php echo htmlspecialchars($product['category']); ?></td>
            <td>
                <form method="post" action="../layouts/index_layout.php" style="display:inline;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    數量：
                    <input type="number" name="quantity" value="1" min="1" style="width: 50px;">
                    <button type="submit">加入購物車</button>
                </form>

            </td>
        </tr>
    <?php endforeach; ?>
</table>
