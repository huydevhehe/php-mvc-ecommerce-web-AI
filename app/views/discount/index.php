<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🎁 Quản lý Mã Giảm Giá</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="/webbanhang/discount/add" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="code" class="form-label">Mã giảm giá</label>
                    <input type="text" name="code" id="code" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="percent" class="form-label">Phần trăm giảm</label>
                    <input type="number" name="percent" id="percent" class="form-control" min="1" max="100" required>
                </div>
                <div class="col-md-3">
                    <label for="limit" class="form-label">Lượt dùng tối đa (0 = không giới hạn)</label>
                    <input type="number" name="limit" id="limit" class="form-control" value="0" min="0">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success w-100">➕ Thêm mã</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">📋 Danh sách mã giảm giá</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Mã</th>
                        <th>Giảm (%)</th>
                        <th>Giới hạn</th>
                        <th>Đã dùng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($discounts as $d): ?>
                        <tr>
                            <td><?= $d['id'] ?></td>
                            <td><strong><?= htmlspecialchars($d['code']) ?></strong></td>
                            <td><?= $d['discount_percent'] ?>%</td>
                            <td><?= $d['usage_limit'] ?></td>
                            <td><?= $d['used_count'] ?? 0 ?></td>
                            <td>
                                <a href="/webbanhang/discount/delete?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">🗑️ Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
