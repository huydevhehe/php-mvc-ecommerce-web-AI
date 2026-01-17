<?php include 'app/views/shares/header.php'; ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
  }

  .gradient-custom {
    background: linear-gradient(-45deg, #00bcd4, #6a11cb, #ff4e50, #f9d423);
    background-size: 600% 600%;
    animation: gradientBG 8s ease infinite;
    min-height: 100vh;
  }

  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    25% { background-position: 50% 50%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 50%; }
    100% { background-position: 0% 50%; }
  }

  .card-custom {
    border-radius: 1rem;
    background: #1f1f2f;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.6);
    color: #fff;
  }

  .form-label {
    color: #ccc;
  }

  .btn-tech {
    background-color: #00bcd4;
    border: none;
    transition: 0.3s;
  }

  .btn-tech:hover {
    background-color: #0097a7;
    color: #fff;
  }

  a {
    color: #00bcd4;
  }

  a:hover {
    color: #fff;
    text-decoration: underline;
  }
</style>

<section class="gradient-custom d-flex align-items-center justify-content-center">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card card-custom p-4">
          <div class="text-center mb-4">
            <h2 class="fw-bold text-uppercase" style="color: #00e5ff;">Đăng nhập</h2>
            <p class="text-white-50">Chào mừng bạn quay lại hệ thống</p>
          </div>

          <form action="/webbanhang/account/checklogin" method="post">

            <?php if (!empty($_SESSION['success'])): ?>
              <div class="alert alert-success fw-bold fs-6">
                ✅ <?= $_SESSION['success'] ?>
              </div>
              <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (!empty($errors['login'])): ?>
              <div class="alert alert-danger fw-bold"><?= $errors['login'] ?></div>
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Tên người dùng</label>
              <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Mật khẩu</label>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
              <a href="#" class="small">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn btn-tech w-100 text-white">Đăng nhập</button>

            <p class="mt-4 mb-0 text-center small">
              Chưa có tài khoản? <a href="/webbanhang/account/register" class="fw-bold">Đăng ký</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector("i");
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  }
</script>

<?php include 'app/views/shares/footer.php'; ?>
