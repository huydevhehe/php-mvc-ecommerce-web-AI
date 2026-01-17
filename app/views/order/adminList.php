<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">📦 Quản Lý Đơn Hàng</h2>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>Mã Đơn</th>
                <th>Người Đặt</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Ngày</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['name']); ?></td>
                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <?php
                        $statusMap = [
                            0 => '<span class="badge bg-warning text-dark">⏳ Chờ xử lý</span>',
                            1 => '<span class="badge bg-info text-white">🚚 Đang vận chuyển</span>',
                            2 => '<span class="badge bg-success">✅ Đã giao hàng</span>',
                            3 => '<span class="badge bg-danger">❌ Đã hủy</span>',
                        ];
                        echo $statusMap[$order['status']] ?? '<span class="badge bg-secondary">Không rõ</span>';
                    ?>
                </td>
                <td>
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        <a href="/webbanhang/Order/detail/<?php echo $order['id']; ?>" class="btn rainbow-button btn-sm" title="Xem chi tiết">👁️Xem</a>
                        <form method="POST" action="/webbanhang/Order/updateStatus" class="d-inline d-flex gap-2">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" name="status" value="1" class="btn rainbow-button btn-sm" title="Đang vận chuyển">🚚</button>
                            <button type="submit" name="status" value="2" class="btn rainbow-button btn-sm" title="Đã giao hàng">✅</button>
                            <button type="submit" name="status" value="3" class="btn rainbow-button btn-sm" title="Hủy đơn">❌</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- CSS -->
<style>
.rainbow-button {
    border: 2px solid #ddd;
    padding: 6px 10px;
    color: black;
    background-color: white;
    border-radius: 6px;
    font-size: 14px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, color 0.3s, background 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    z-index: 0;
}

.rainbow-button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 200%;
    height: 100%;
    background: linear-gradient(270deg, red, orange, yellow, green, cyan, blue, violet);
    background-size: 1400% 1400%;
    animation: rainbow 6s linear infinite;
    transition: all 0.3s ease;
    z-index: -1;
    opacity: 0;
}

.rainbow-button:hover::before {
    left: 0;
    opacity: 1;
}

.rainbow-button:hover {
    color: white;
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
    border-color: transparent;
}

@keyframes rainbow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>


<?php include 'app/views/shares/footer.php'; ?>
