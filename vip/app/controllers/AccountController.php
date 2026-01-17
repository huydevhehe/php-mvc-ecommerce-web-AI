<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập tên đăng nhập!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập họ tên!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu!";
            }
            if ($password !== $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu xác nhận không khớp!";
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản đã tồn tại!";
            }

            if (!empty($errors)) {
                include_once 'app/views/account/register.php';
            } else {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $passwordHash);

                if ($result) {
                    $_SESSION['success'] = "Bạn đã đăng ký thành công vui lòng đăng nhập lại!";
                    header('Location: /webbanhang/account/login');
                    exit;
                } else {
                    $errors['account'] = "Lỗi hệ thống khi lưu tài khoản.";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $hashedPassword = $account->password;
                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role ?? 'user';
                    header('Location: /webbanhang/product');
                    exit;
                } else {
                    $errors['login'] = "Sai mật khẩu hoặc tài khoản, vui lòng nhập lại.";
                }
            } else {
                $errors['login'] = "Tài khoản không tồn tại.";
            }

            include_once 'app/views/account/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /webbanhang/account/login');
        exit;
    }
}
