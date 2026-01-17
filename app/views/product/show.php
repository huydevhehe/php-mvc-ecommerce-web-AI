<?php include 'app/views/shares/header.php'; ?>

<!-- CSS tùy chỉnh -->
<style>
.product-detail-container {
    max-width: 1000px;
    margin: 50px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 30px;
    font-family: 'Segoe UI', sans-serif;
}
.product-detail-container .img-fluid {
    width: 100%;
    max-height: 380px;
    object-fit: contain;
    border-radius: 10px;
}
.product-info h2 {
    font-size: 28px;
    color: #ff5722;
    font-weight: bold;
}
.product-info p {
    font-size: 16px;
    line-height: 1.6;
    color: #444;
}
.product-info .price {
    font-size: 22px;
    color: #e91e63;
    font-weight: bold;
    margin-top: 80px;
}
.btn-gradient {
    background: linear-gradient(45deg, #ff6b6b, #fbc531);
    color: #fff;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.btn-gradient:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}
.btn-group-bottom {
    margin-top: 20px;
}
.review-section {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
}
.review-box {
    background: #fff;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
}
.review-box strong {
    font-size: 16px;
    color: #2c3e50;
}
</style>

<!-- Nội dung -->
<div class="product-detail-container">
    <div class="row">
        <div class="col-md-6">
            <img src="/webbanhang/<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>" class="img-fluid">
        </div>
        <div class="col-md-6 product-info">
            <h2><?php echo $product->name; ?></h2>
            <p><strong>Mô tả:</strong> <?php echo $product->description; ?></p>
            <p><strong>Loại :</strong> <?php echo isset($product->category_name) && $product->category_name !== '' ? $product->category_name : 'Không có danh mục'; ?></p>
            <p class="price">Giá: <?php echo number_format($product->price * 1000); ?> VND</p>

            <div class="btn-group-bottom">
                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-gradient btn-sm me-2">🛒 Thêm vào giỏ hàng</a>
                <a href="/webbanhang/Product/buyNow/<?php echo $product->id; ?>" class="btn btn-outline-danger btn-sm">⚡ Mua ngay</a>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Phần đánh giá -->
<div class="review-section">
    <h4>Đánh giá từ người dùng</h4>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review-box">
                <strong><?= htmlspecialchars($review['username']) ?></strong>
                <div>⭐ <?= $review['rating'] ?> sao</div>
                <div><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
