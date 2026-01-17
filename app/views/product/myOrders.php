<?php include 'app/views/shares/header.php'; ?>

<style>
    .rainbow-button {
        background: white;
        color: black;
        border: 1px solid #ccc;
        position: relative;
        z-index: 1;
        overflow: hidden;
        transition: color 0.3s ease;
    }

    .rainbow-button::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(60deg, red, orange, yellow, green, blue, indigo, violet, red);
        background-size: 400% 400%;
        animation: rainbowShift 6s linear infinite;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
        filter: blur(10px);
    }

    .rainbow-button:hover::before {
        opacity: 1;
    }

    @keyframes rainbowShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4"><i class="fas fa-clipboard-list"></i> Đơn hàng của tôi</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center">Bạn chưa có đơn hàng nào.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td>
                                <?php
                                    $statusMap = [
                                        0 => '<span class="badge badge-warning">⏳ Chờ xử lý</span>',
                                        1 => '<span class="badge badge-info">🚚 Đang vận chuyển</span>',
                                        2 => '<span class="badge badge-success">✅ Đã giao hàng</span>',
                                        3 => '<span class="badge badge-danger">❌ Đã hủy</span>',
                                    ];
                                    echo $statusMap[$order['status']] ?? '<span class="text-muted">Không rõ</span>';
                                ?>
                            </td>
                            <td class="text-right"><?php echo number_format($order['total'] * 1000); ?> đ</td>
                            <td>
                                <a href="/webbanhang/Order/detail/<?php echo $order['id']; ?>" class="btn btn-sm btn-primary mb-1">Chi tiết</a>
                               
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
