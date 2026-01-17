<?php include 'app/views/shares/header.php'; ?>

<style>
    .profile-edit-container {
        max-width: 600px;
        margin: 40px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-edit-container h3 {
        text-align: center;
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 500;
    }

    .btn-save {
        display: block;
        width: 100%;
        background-color: #28a745;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-save:hover {
        background-color: #218838;
    }
</style>

<div class="profile-edit-container">
    <h3>✏️ Chỉnh sửa thông tin</h3>

    <?php $user = $_SESSION['user'] ?? []; ?>

    <form method="POST" action="/webbanhang/account/updateProfile">
        <div class="form-group mb-3">
            <label>Tên đăng nhập (không thể thay đổi)</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
        </div>

        <div class="form-group mb-3">
            <label>Họ và tên</label>
            <input type="text" name="fullname" class="form-control" required value="<?= htmlspecialchars($user['fullname']) ?>">
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="form-group mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($user['phone']) ?>">
        </div>

        <div class="form-group mb-3">
            <label>Địa chỉ giao hàng</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
        </div>

        <button type="submit" class="btn-save">✅ Lưu thông tin</button>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
