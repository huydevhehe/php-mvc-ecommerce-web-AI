<?php include 'app/views/shares/header.php'; ?>

<!-- CSS -->
<style>
.edit-product-container {
    max-width: 800px;
    margin: 50px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', sans-serif;
}
.edit-product-container h2 {
    color: #e91e63;
    font-weight: bold;
    margin-bottom: 20px;
}
.form-label {
    font-weight: 600;
    color: #333;
}
.btn-save {
    background: linear-gradient(45deg, #ff6b6b, #fbc531);
    color: white;
    border: none;
    font-weight: 600;
}
.btn-save:hover {
    filter: brightness(1.1);
}
</style>

<!-- HTML -->
<div class="edit-product-container">
    <h2 class="text-center">📝 Chỉnh sửa sản phẩm</h2>

    <form method="POST" action="/webbanhang/Product/update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product->id; ?>">
        <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">

        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="<?php echo $product->name; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3" required><?php echo $product->description; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" class="form-control" value="<?php echo $product->price; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>" <?php if ($category->id == $product->category_id) echo 'selected'; ?>>
                        <?php echo $category->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label><br>
            <img src="/webbanhang/<?php echo $product->image; ?>" alt="Hình ảnh sản phẩm" width="150" class="rounded shadow">
        </div>

        <div class="mb-3">
            <label class="form-label">Tải ảnh mới (nếu muốn thay)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-save px-4 py-2">💾 Lưu thay đổi</button>
            <a href="/webbanhang/Product" class="btn btn-secondary ms-2">↩️ Quay lại</a>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
