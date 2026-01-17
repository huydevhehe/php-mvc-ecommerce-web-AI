<?php include 'app/views/shares/header.php'; ?>

<style>
    .profile-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .profile-container h3 {
        text-align: center;
        color: #007bff;
        font-weight: bold;
    }

    .profile-container p {
        font-size: 16px;
        margin-bottom: 12px;
    }

    .profile-label {
        font-weight: 600;
        color: #444;
    }

    .btn-edit {
        margin-top: 20px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        background-color: #007bff;
        color: white;
        transition: background-position 0.5s;
        background-size: 300% 300%;
        background-image: linear-gradient(
            270deg,
            #ff0000,
            #ff8c00,
            #ffff00,
            #008000,
            #0000ff,
            #4b0082,
            #ee82ee,
            #ff0000
        );
        background-position: left;
    }

    .btn-edit:hover {
        background-position: right;
        color: white;
    }

    .text-end {
        text-align: right;
    }
</style>

<div class="profile-container">
    <h3>👤 Thông tin tài khoản</h3>

    <?php $user = $_SESSION['user'] ?? []; ?>

    <p><span class="profile-label">Tên đăng nhập:</span> <?= htmlspecialchars($user['username'] ?? '') ?></p>
    <p><span class="profile-label">Họ và tên:</span> <?= htmlspecialchars($user['fullname'] ?? '') ?></p>
    <p><span class="profile-label">Email:</span> <?= htmlspecialchars($user['email'] ?? '') ?></p>
    <p><span class="profile-label">Số điện thoại:</span> <?= htmlspecialchars($user['phone'] ?? '') ?></p>
    <p><span class="profile-label">Địa chỉ giao hàng:</span> <?= htmlspecialchars($user['address'] ?? 'Chưa có') ?></p>

    <div class="text-end">
        <a href="/webbanhang/account/editProfile" class="btn btn-edit">📝 Sửa thông tin</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
