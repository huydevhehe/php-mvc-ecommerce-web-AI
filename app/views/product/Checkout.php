<?php include 'app/views/shares/header.php'; ?>

<!-- CSS tùy chỉnh -->
<style>
.checkout-container {
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', sans-serif;
}
.checkout-container h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 25px;
    text-align: center;
}
.checkout-container .form-group label {
    font-weight: 600;
    margin-bottom: 6px;
}
.checkout-container .summary-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.checkout-container .summary-table th,
.checkout-container .summary-table td {
    border: 1px solid #eee;
    padding: 10px;
    text-align: left;
    font-size: 14px;
}
.checkout-container .total-line {
    font-weight: bold;
    color: #e91e63;
    text-align: right;
}
.payment-methods {
    margin: 15px 0;
    background: #f4f4f4;
    padding: 15px;
    border-radius: 8px;
}
.payment-methods h5 {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}
.payment-methods p {
    font-size: 14px;
    margin: 4px 0;
}
.qr-section img {
    width: 400px;
    height: auto;
    margin: 20px auto;
    display: block;
    border: 3px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 0 18px rgba(0,0,0,0.25);
    transition: transform 0.3s ease;
}
</style>

<div class="checkout-container">
    <h2>🧾 Hóa Đơn thanh toán</h2>

    <!-- Bảng sản phẩm -->
    <table class="summary-table">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; foreach ($_SESSION['cart'] as $item): $subtotal = $item['quantity'] * $item['price']; $total += $subtotal; ?>
                <tr>
                    <td><img src="/webbanhang/<?php echo $item['image']; ?>" width="50"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'] * 1000); ?> VND</td>
                    <td><?php echo number_format($subtotal * 1000); ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Thông tin người dùng -->
    <form method="POST" action="/webbanhang/Product/processCheckout">
    <div class="form-group mb-3">
        <label for="name">Họ và tên</label>
        <input type="text" name="name" id="name" class="form-control" 
               value="<?php echo $_SESSION['user']['fullname'] ?? ''; ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="address">Địa chỉ giao hàng</label>
        <input type="text" name="address" id="address" class="form-control" 
               value="<?php echo $_SESSION['user']['address'] ?? ''; ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="phone">Số điện thoại</label>
        <input type="text" name="phone" id="phone" class="form-control" 
               value="<?php echo $_SESSION['user']['phone'] ?? ''; ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" 
               value="<?php echo $_SESSION['user']['email'] ?? ''; ?>">
    </div>

    <div class="form-group mb-3">
    <label class="form-label">🎁 Chọn mã giảm giá:</label>
    <?php if (!empty($availableDiscounts)): ?>
        <?php foreach ($availableDiscounts as $discount): ?>
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="discount_code" 
                    value="<?= $discount['code'] ?>" 
                    id="discount_<?= $discount['id'] ?>" 
                    data-percent="<?= $discount['discount_percent'] ?>">
                <label class="form-check-label" for="discount_<?= $discount['id'] ?>">
                    <?= $discount['code'] ?> - Giảm <?= $discount['discount_percent'] ?>%
                </label>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">Không có mã giảm giá khả dụng.</p>
    <?php endif; ?>
</div>




<?php if (!empty($suggestedProducts)): ?>
    <style>
        .suggested-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #fafafa;
            transition: background 0.3s;
        }
        .suggested-item:hover {
            background: #f0f0f0;
        }
        .suggested-item img {
            height: 50px;
            width: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }
        .suggested-item label {
            flex: 1;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .suggested-item input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
        }
    </style>

    <div class="form-group mt-4">
        <label><strong>🧠 Có thể bạn cũng sẽ thích:</strong></label>
        <?php foreach ($suggestedProducts as $sp): ?>
            <div class="suggested-item">
                <input type="checkbox" class="suggested-checkbox" 
                       name="suggested_products[]" 
                       value="<?= $sp['product_id'] ?>" 
                       data-price="<?= $sp['price'] * 1000 ?>"
                       id="suggested<?= $sp['product_id'] ?>">

                <label for="suggested<?= $sp['product_id'] ?>">
                    <div>
                        <img src="/webbanhang/<?= $sp['image'] ?>" alt="<?= htmlspecialchars($sp['name']) ?>">
                        <?= htmlspecialchars($sp['name']) ?>
                    </div>
                    <span class="text-danger fw-bold"><?= number_format($sp['price'] * 1000, 0, ',', '.') ?>đ</span>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



        <p class="total-line">
            Tổng tiền: 
            <span id="total-amount" data-base="<?= $total * 1000 ?>">
                <input type="hidden" name="final_amount" id="final_amount_input" value="<?= $total * 1000 ?>">

                <?= number_format($total * 1000) ?> VND
            </span>
        </p>

        
        <!-- Phương thức thanh toán -->
        <!-- Chọn hình thức thanh toán -->
<div class="form-group mb-3">
    <label class="form-label fw-bold d-block">Phương thức thanh toán:</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method" id="qr" value="qr" checked>
        <label class="form-check-label" for="qr">📲 Chuyển khoản qua QR</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
        <label class="form-check-label" for="cod">💵 Thanh toán khi nhận hàng (COD)</label>
    </div>
</div>

<!-- Cảnh báo khi chọn COD -->
<div id="cod-warning" style="display:none; padding: 12px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 6px; margin-bottom: 20px;">
    <strong>Lưu ý:</strong> Bạn sẽ thanh toán tiền mặt khi nhận hàng hãy chuẩn bị sẵn trước tiền mặt và để điện thoại chế độ reo chuông chờ trông khi shipper đến.
</div>

<!-- Phần QR -->
<div id="qr-wrapper" style="display:block;">
    <div class="payment-methods">
        <h5>📌 Phương thức thanh toán</h5>
        <p>✅ Thanh toán qua QR:</p>
        <div class="qr-section">
            <?php $order_code = uniqid("DH"); ?>
            <img id="qr-image"
                data-code="<?= $order_code ?>"
                src="https://img.vietqr.io/image/MB-9999910082004-compact2.png?amount=<?= $total * 1000 ?>&addInfo=<?= urlencode('Thanh toán đơn hàng cho huydzhehe #' . $order_code) ?>"
                alt="QR Code">
>

            <p class="text-center">Quét mã QR để chuyển khoản qua MB Bank hoặc Momo</p>
        </div>
        <hr>
        <p>Hoặc chuyển khoản theo STK Momo:</p>
        <p><strong>STK:</strong> 0397180247 - NGUYEN QUOC HUY</p>
        <p><strong>Nội dung:</strong> [Số điện thoại] + [Tên đơn hàng]</p>
    </div>
</div>

<button type="submit" class="btn btn-primary w-100">✅ Xác nhận đặt hàng</button>

    </form>
    <script>
    const qrRadio = document.getElementById('qr');
    const codRadio = document.getElementById('cod');
    const qrWrapper = document.getElementById('qr-wrapper');
    const codWarning = document.getElementById('cod-warning');

    function togglePaymentUI() {
        if (qrRadio.checked) {
            qrWrapper.style.display = 'block';
            codWarning.style.display = 'none';
        } else {
            qrWrapper.style.display = 'none';
            codWarning.style.display = 'block';
        }
    }

    qrRadio.addEventListener('change', togglePaymentUI);
    codRadio.addEventListener('change', togglePaymentUI);
    window.onload = togglePaymentUI;
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="discount_code"]');
    const totalElement = document.getElementById('total-amount');
    const baseAmount = parseFloat(totalElement.dataset.base);
    let lastChecked = null;

    radios.forEach(radio => {
        radio.addEventListener('click', function (e) {
            // Nếu click lại radio đã chọn thì bỏ chọn
            if (this === lastChecked) {
                this.checked = false;
                lastChecked = null;
                totalElement.innerText = baseAmount.toLocaleString('vi-VN') + ' VND';
            } else {
                lastChecked = this;
                const percent = parseFloat(this.dataset.percent);
                const discount = baseAmount * percent / 100;
                const final = baseAmount - discount;
                totalElement.innerText = final.toLocaleString('vi-VN') + ' VND';
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const discountRadios = document.querySelectorAll('input[name="discount_code"]');
    const suggestedCheckboxes = document.querySelectorAll('.suggested-checkbox');
    const totalElement = document.getElementById('total-amount');
    const baseAmount = parseFloat(totalElement.dataset.base);
    const finalInput = document.getElementById('final_amount_input');
    const qrImg = document.getElementById('qr-image');
    let lastChecked = null;

    function getSelectedDiscountPercent() {
        let percent = 0;
        discountRadios.forEach(radio => {
            if (radio.checked) {
                percent = parseFloat(radio.dataset.percent) || 0;
            }
        });
        return percent;
    }

    function updateTotal() {
        let extra = 0;
        suggestedCheckboxes.forEach(cb => {
            if (cb.checked) {
                extra += parseFloat(cb.dataset.price);
            }
        });

        const discount = getSelectedDiscountPercent();
        const subtotal = baseAmount + extra;
        const final = subtotal - (subtotal * discount / 100);

        // ✅ Cập nhật giao diện
        totalElement.innerText = final.toLocaleString('vi-VN') + ' VND';

        // ✅ Gán vào input ẩn để gửi về server nếu cần
        if (finalInput) finalInput.value = Math.round(final);

        // ✅ Cập nhật mã QR với số tiền mới
        if (qrImg) {
            const orderCode = qrImg.dataset.code; // lấy từ thuộc tính data-code
            qrImg.src = `https://img.vietqr.io/image/MB-9999910082004-compact2.png?amount=${Math.round(final)}&addInfo=${encodeURIComponent('Thanh toán đơn hàng #' + orderCode)}`;
        }
    }

    discountRadios.forEach(radio => {
        radio.addEventListener('click', function () {
            if (this === lastChecked) {
                this.checked = false;
                lastChecked = null;
            } else {
                lastChecked = this;
            }
            updateTotal();
        });
    });

    suggestedCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    updateTotal();
});
</script>





</div>

<?php include 'app/views/shares/footer.php'; ?>
