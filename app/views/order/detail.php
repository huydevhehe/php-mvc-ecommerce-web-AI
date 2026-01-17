<?php include 'app/views/shares/header.php'; ?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="alert alert-success text-center fw-bold mb-4">
        <?= $_SESSION['flash_message']; ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<?php if (!$order || !is_array($order)): ?>
    <div class="container mt-5 text-center text-danger">
        <h4>❌ Không tìm thấy đơn hàng hoặc dữ liệu không hợp lệ.</h4>
        <a href="/webbanhang/Order/myOrders" class="btn btn-secondary mt-3">⬅ Quay lại danh sách đơn hàng</a>
    </div>
    <?php include 'app/views/shares/footer.php'; return; ?>
<?php endif; ?>

<style>
    .order-wrapper {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
        border: 1px solid #eee;
    }
    .order-wrapper h3 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 25px;
        color: #007bff;
    }
    .order-info {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .order-info strong {
        display: inline-block;
        width: 120px;
        font-weight: 600;
    }
    .table th, .table td {
        vertical-align: middle;
        font-size: 15px;
    }
    .table th {
        background-color: #333;
        color: #fff;
    }
    .total-price {
        text-align: right;
        font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
        color: #d63384;
    }
</style>

<div class="order-wrapper">
    <h3>📦 Chi Tiết Đơn Hàng #<?= $order['id']; ?></h3>

    <div class="order-info">
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['name']); ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']); ?></p>
        <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
        <p><strong>Trạng thái:</strong> 
            <?php
                $statusMap = [
                    0 => '⏳ Chờ xử lý', 
                    1 => '🚚 Đang vận chuyển', 
                    2 => '✅ Đã giao hàng', 
                    3 => '❌ Đã hủy'
                ];
                echo isset($statusMap[$order['status']]) ? $statusMap[$order['status']] : '<span class="text-muted">⏳ Chờ xử lý</span>';
            ?>
        </p>
        <p><strong>Ngày đặt:</strong> <?= $order['created_at']; ?></p>
    </div>

    <h5 class="fw-bold mb-3">Sản phẩm:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $originalTotal = 0; ?>
            <?php foreach ($orderDetails as $item): 
                $subtotal = $item['quantity'] * $item['price'];
                $originalTotal += $subtotal;
            ?>
            <tr>
                <td><img src="/webbanhang/<?= $item['image']; ?>" width="60" style="border-radius: 6px;"></td>
                <td><?= $item['name']; ?></td>
                <td><?= $item['quantity']; ?></td>
                <td><?= number_format($item['price'] * 1000) ?> đ</td>
                <td><?= number_format($subtotal * 1000) ?> đ</td>

            </tr>
            <?php if ($order['status'] == 2 && empty($item['reviewed'])): ?>
            <tr>
                <td colspan="5" class="text-end">
                    <a href="/webbanhang/index.php?url=review/add/<?= $item['product_id'] ?>/<?= $order['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-star"></i> Đánh giá sản phẩm
                    </a>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (!empty($order['discount_code'])): ?>
        <p class="total-price text-decoration-line-through text-muted">
            Tổng tiền gốc: <?= number_format($originalTotal)*1000 ?> đ
        </p>
        <p class="total-price">
            Mã giảm giá: <?= htmlspecialchars($order['discount_code']) ?> 
            (−<?= number_format($order['discount_amount'] * 1000) ?> đ)

        </p>
    <?php endif; ?>

    <p class="total-price">Tổng tiền thanh toán: <?= number_format($order['total']*1000) ?> đ</p>

    <a href="/webbanhang/<?= SessionHelper::isAdmin() ? 'Order/adminList' : 'Product/myOrders'; ?>" class="btn btn-secondary mt-3">⬅ Quay lại</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>
