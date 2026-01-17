<?php
ob_start(); // Tránh lỗi headers already sent

require_once 'app/helpers/SessionHelper.php';
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

if (!SessionHelper::isAdmin()) {
    echo "<div class='alert alert-danger text-center mt-5'>Bạn không có quyền truy cập trang này.</div>";
    exit;
}

$db = (new Database())->getConnection();
$model = new CategoryModel($db);

// Xử lý thêm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $model->create($_POST['name'], '');
    header("Location: /webbanhang/category/list");
    exit;
}

// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $model->update($_POST['id'], $_POST['name'], '');
    header("Location: /webbanhang/category/list");
    exit;
}

// Xử lý xóa
if (isset($_GET['delete'])) {
    $model->delete($_GET['delete']);
    header("Location: /webbanhang/category/list");
    exit;
}

// Dữ liệu
$categories = $model->getCategories();
$editCategory = isset($_GET['edit']) ? $model->getById($_GET['edit']) : null;

ob_end_flush(); // Xong xử lý, cho phép hiển thị HTML
include 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Quản lý danh mục</h2>
        <div>
            <a href="/webbanhang/category/list?add=1" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Thêm danh mục
            </a>
        </div>
    </div>

    <!-- Form Thêm danh mục -->
    <?php if (isset($_GET['add'])): ?>
    <form method="post" class="bg-light p-4 rounded shadow-sm mb-4">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Thêm</button>
        <a href="/webbanhang/category/list" class="btn btn-secondary">Hủy</a>
    </form>
    <?php endif; ?>

    <!-- Form Sửa danh mục -->
    <?php if ($editCategory): ?>
    <form method="post" class="bg-white p-4 rounded shadow-sm border mb-4">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($editCategory['name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Cập nhật</button>
        <a href="/webbanhang/category/list" class="btn btn-secondary">Hủy</a>
    </form>
    <?php endif; ?>

    <!-- Danh sách danh mục -->
    <table class="table table-bordered table-hover text-center bg-white shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat->id ?></td>
                <td><?= htmlspecialchars($cat->name) ?></td>
                <td>
                    <a href="/webbanhang/category/list?edit=<?= $cat->id ?>" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="/webbanhang/category/list?delete=<?= $cat->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa danh mục này?');">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'app/views/shares/footer.php'; ?>
