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
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
    min-height: 100vh;
  }

  @keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .card-custom {
    border-radius: 1rem;
    background: #1e1e2f;
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
    color: #fff;
  }

  label {
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

  .input-group .form-control {
    border-right: none;
  }

  .input-group .btn {
    border-left: none;
  }
</style>

<section class="gradient-custom d-flex align-items-center justify-content-center">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card card-custom p-4">
          <div class="text-center mb-4">
            <h2 class="fw-bold text-uppercase" style="color: #00e5ff;">Đăng ký</h2>
            <p class="text-white-50">Tạo tài khoản mới để tham gia hệ thống</p>
          </div>

          <?php
          if (isset($errors)) {
              echo "<ul>";
              foreach ($errors as $err) {
                  echo "<li class='text-danger'>$err</li>";
              }
              echo "</ul>";
          }
          ?>

          <form class="user" action="/webbanhang/account/save" method="post">
            <div class="form-group mb-3">
              <label>Tên đăng nhập</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
            </div>

            <div class="form-group mb-3">
              <label>Họ và tên</label>
              <input type="text" class="form-control" id="fullname" name="fullname" placeholder="fullname" required>
            </div>

            <div class="form-group mb-3">
              <label>Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="yourmail@example.com" required>
            </div>

            <div class="form-group mb-3">
              <label>Số điện thoại</label>
              <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
            </div>

            <div class="form-group mb-3">
              <label>Mật khẩu</label>
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-group mb-4">
              <label>Xác nhận mật khẩu</label>
              <div class="input-group">
                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="confirm password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmpassword', this)">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-group text-center">
              <button class="btn btn-tech px-5 py-2 text-white" type="submit">Đăng ký</button>
            </div>

            <p class="mt-4 mb-0 text-center small">
              Đã có tài khoản? <a href="/webbanhang/account/login" class="fw-bold">Đăng nhập</a>
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
