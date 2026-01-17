<?php include 'app/views/shares/header.php'; ?>
<div class="container my-5">
    <h1 class="mb-4 text-primary">🛒 Giỏ hàng của bạn</h1>

    <?php if (!empty($cart)): ?>
        <?php $grandTotal = 0; ?>
        <div class="row">
            <?php foreach ($cart as $id => $item): ?>
                <?php 
                    $itemTotal = $item['price'] * $item['quantity'] * 1000; // ✅ nhân 1000
                    $grandTotal += $itemTotal;
                    $unitPriceDisplay = $item['price'] * 1000; // ✅ nhân 1000
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="row g-0">
                            <?php if (!empty($item['image'])): ?>
                                <div class="col-4">
                                    <img src="/webbanhang/<?php echo $item['image']; ?>" 
                                         class="img-fluid rounded-start" 
                                         alt="Ảnh sản phẩm">
                                </div>
                            <?php endif; ?>

                            <div class="col">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                    
                                    <p class="card-text">
                                        <strong>Giá đơn vị:</strong> 
                                        <span class="text-danger"><?php echo number_format($unitPriceDisplay, 0); ?> VND</span>
                                    </p>

                                    <div class="d-flex align-items-center mb-2">
                                        <strong class="me-2">Số lượng:</strong>
                                        <a href="/webbanhang/Product/decreaseQuantity/<?php echo $id; ?>" 
                                           class="btn btn-sm btn-outline-secondary me-1">➖</a>
                                        <span class="px-2"><?php echo $item['quantity']; ?></span>
                                        <a href="/webbanhang/Product/increaseQuantity/<?php echo $id; ?>" 
                                           class="btn btn-sm btn-outline-secondary ms-1">➕</a>
                                    </div>

                                    <p class="mb-0">
                                        <strong>Thành tiền:</strong> 
                                        <?php echo number_format($itemTotal, 0); ?> VND
                                    </p>

                                    <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" 
                                       class="btn btn-sm btn-outline-danger mt-3"
                                       onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?');">
                                       ❌ Xóa sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tổng tiền -->
        <div class="text-end mt-4">
            <h4 class="text-success">💵 Tổng tiền đơn hàng: <strong><?php echo number_format($grandTotal, 0); ?> VND</strong></h4>
        </div>

        <!-- Nút điều hướng -->
        <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="/webbanhang/Product" class="btn btn-secondary">🛍️ Tiếp tục mua sắm</a>
            <a href="/webbanhang/Product/checkout" class="btn btn-primary">💳 Thanh toán</a>
            <a href="/webbanhang/Product/clearCart" 
               class="btn btn-outline-danger"
               onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
               🗑️ Xóa toàn bộ giỏ
            </a>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <p>🛒 Giỏ hàng của bạn đang trống. Hãy bắt đầu mua sắm ngay!</p>
            <a href="/webbanhang/Product" class="btn btn-primary mt-2">🛍️ Đến trang sản phẩm</a>
        </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>
