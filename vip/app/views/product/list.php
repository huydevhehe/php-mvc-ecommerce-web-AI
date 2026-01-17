<?php include 'app/views/shares/header.php'; ?>

<!-- Hiệu ứng tùy chỉnh -->
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    .hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }
    .product-image {
        object-fit: contain;
        height: 200px;
        width: auto;
        max-width: 100%;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<h1 class="mb-4 text-primary">📦 Danh sách sản phẩm</h1>

<div class="d-flex justify-content-end mb-3">
    <a href="/webbanhang/Product/add" class="btn btn-outline-primary">
        ➕ Thêm sản phẩm mới
    </a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($products as $product): ?>
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <?php if ($product->image): ?>
                    <img src="/webbanhang/<?php echo $product->image; ?>" 
                         alt="Product Image"
                         class="product-image p-3" 
                         loading="lazy">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title text-truncate">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" 
                           class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>

                    <p class="card-text small text-muted">
                        <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <p class="mb-1">
                        <span class="fw-bold text-warning">💰 Giá:</span> 
                        <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND
                    </p>
                    <p class="mb-2">
                        <span class="fw-bold text-secondary">📁 Danh mục:</span> 
                        <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <div class="d-flex justify-content-between">
                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-outline-warning hover-scale">
                            ✏️ Sửa
                        </a>
                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-outline-danger hover-scale"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            🗑️ Xóa
                        </a>
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-outline-primary hover-scale">
                            🛒 Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- CSS định dạng cho rồng -->
<style>
#dragon-cursor {
    position: fixed;
    pointer-events: none;
    width: 100px;
    height: auto;
    z-index: 9999;
    transition: transform 0.1s ease;
}
</style>

<!-- HTML gọi ảnh rồng -->
<img id="dragon-cursor" src="/webbanhang/images/bravo-bravo-supermarket.gif" alt="Dragon">

<!-- JavaScript di chuyển rồng theo chuột -->
<script>
document.addEventListener('mousemove', function(e) {
    const dragon = document.getElementById('dragon-cursor');
    dragon.style.left = e.pageX + 10 + 'px';
    dragon.style.top = e.pageY + 10 + 'px';
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
