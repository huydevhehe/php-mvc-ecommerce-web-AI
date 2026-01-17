<?php include 'app/views/shares/header.php'; ?>
<h1>Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
    <?php $grandTotal = 0; ?>
    <ul class="list-group">
        <?php foreach ($cart as $id => $item): ?>
            <?php 
                $itemTotal = $item['price'] * $item['quantity'];
                $grandTotal += $itemTotal;
            ?>
            <li class="list-group-item mb-3">
                <h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>

                <?php if ($item['image']): ?>
                    <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 100px;">
                <?php endif; ?>

                <p>Giá đơn vị: 
                    <span class="unit-price"><?php echo number_format($item['price'], 2); ?></span> VND
                </p>

                <!-- Tăng giảm số lượng -->
                <p>
                    Số lượng:
                    <a href="/webbanhang/Product/decreaseQuantity/<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary">➖</a>
                    <span class="mx-2"><?php echo $item['quantity']; ?></span>
                    <a href="/webbanhang/Product/increaseQuantity/<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary">➕</a>
                </p>

                <!-- Nút xóa từng sản phẩm -->
                <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" 
                   class="btn btn-sm btn-outline-danger mt-2"
                   onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?');">
                   ❌ Xóa sản phẩm
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- ✅ Tổng tiền toàn bộ giỏ -->
    <div class="mt-4">
        <h4 class="text-right text-success">💵 Tổng tiền đơn hàng: <strong><?php echo number_format($grandTotal, 2); ?> VND</strong></h4>
    </div>

    <!-- Các nút điều hướng -->
    <div class="mt-3">
        <a href="/webbanhang/Product" class="btn btn-secondary">Tiếp tục mua sắm</a>
        <a href="/webbanhang/Product/checkout" class="btn btn-primary">Thanh Toán</a>
        <a href="/webbanhang/Product/clearCart" 
           class="btn btn-outline-danger ms-2"
           onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
           🗑️ Xóa toàn bộ giỏ
        </a>
    </div>

<?php else: ?>
    <p>Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
