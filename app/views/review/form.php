<?php include 'app/views/shares/header.php'; ?>
<style>
.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-start;
}
.rating-stars input[type="radio"] {
    display: none;
}
.rating-stars label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}
.rating-stars input[type="radio"]:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffc107;
}
</style>

<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h3 class="mb-4 text-center text-primary">Đánh giá sản phẩm</h3>
        <form method="POST" action="/webbanhang/index.php?url=review/store">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">

            <div class="mb-3 text-center">
                <label class="form-label d-block">Chọn số sao:</label>
                <div class="rating-stars justify-content-center">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
                        <label for="star<?= $i ?>">★</label>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Bình luận:</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Nhập bình luận của bạn..." required></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
