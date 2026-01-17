<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center text-primary">🧾 Thanh toán đơn hàng</h2>

                    <form method="POST" action="/webbanhang/Product/processCheckout">
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/webbanhang/Product/cart" class="btn btn-outline-secondary">⬅️ Quay lại giỏ hàng</a>
                            <button type="submit" class="btn btn-primary">💳 Xác nhận thanh toán</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
