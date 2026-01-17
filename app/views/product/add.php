<?php include 'app/views/shares/header.php'; ?>

<style>
    .add-product-container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .add-product-container h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #007bff;
        font-weight: bold;
    }

    .form-group label {
        font-weight: 600;
    }

    .form-control, .form-control-file {
        border-radius: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
    }

    .btn-secondary {
        margin-top: 15px;
    }
</style>

<div class="add-product-container">
    <h1>➕ Thêm sản phẩm mới</h1>

    <form action="/webbanhang/Product/save" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">📝 Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">📄 Mô tả:</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">💰 Giá (nghìn đồng):</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="category_id">📁 Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <!-- Danh mục sẽ được load bằng JS -->
            </select>
        </div>

        <div class="form-group">
            <label for="image">🖼️ Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control-file" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-3">✅ Thêm sản phẩm</button>
    </form>

    <a href="/webbanhang/Product" class="btn btn-secondary btn-block">⬅ Quay lại danh sách sản phẩm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/webbanhang/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });
});
</script>
