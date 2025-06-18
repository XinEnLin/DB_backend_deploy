<h2><?php echo $editingProduct ? '✏️ 編輯商品' : '➕ 新增商品'; ?></h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo $editingProduct ? 'update' : 'create'; ?>">
    <?php if ($editingProduct): ?>
        <input type="hidden" name="productID" value="<?php echo $editingProduct['productID']; ?>">
        <input type="hidden" name="originalImage" value="<?php echo $editingProduct['imagePath']; ?>">
    <?php endif; ?>
    <label>商品名稱：<input type="text" name="name" value="<?php echo $editingProduct['name'] ?? ''; ?>" required></label><br>
    <label>描述：<textarea name="description" required><?php echo $editingProduct['description'] ?? ''; ?></textarea></label><br>
    <label>價格：<input type="number" name="price" step="0.01" value="<?php echo $editingProduct['price'] ?? ''; ?>" required></label><br>
    <label>庫存：<input type="number" name="stock" value="<?php echo $editingProduct['stock'] ?? ''; ?>" required></label><br>
    <label>分類：<input type="text" name="category" value="<?php echo $editingProduct['category'] ?? ''; ?>" required></label><br>
    <label>圖片：<input type="file" name="image" accept="image/*"></label><br>
    <?php if ($editingProduct): ?>
        <img src="../asset/images/<?php echo $editingProduct['imagePath']; ?>" height="60"><br>
    <?php endif; ?>
    <button type="submit"><?php echo $editingProduct ? '✅ 確認修改' : '新增商品'; ?></button>
</form>
