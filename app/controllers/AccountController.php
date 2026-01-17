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
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            // Kiểm tra dữ liệu
            if (empty($username)) $errors['username'] = "Vui lòng nhập tên đăng nhập!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập họ tên!";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ!";
            if (empty($phone)) $errors['phone'] = "Vui lòng nhập số điện thoại!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu!";
            if ($password !== $confirmPassword) $errors['confirmPass'] = "Mật khẩu xác nhận không khớp!";

            // Kiểm tra trùng username
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tên đăng nhập đã tồn tại!";
            }

            if (!empty($errors)) {
                include_once 'app/views/account/register.php';
            } else {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->accountModel->save($username, $fullName, $email, $phone, $passwordHash);

                if ($result) {
                    $_SESSION['success'] = "Đăng ký thành công. Vui lòng đăng nhập!";
                    header('Location: /webbanhang/account/login');
                    exit;
                } else {
                    $errors['system'] = "Lỗi hệ thống khi lưu dữ liệu.";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }
    public function profile() {
    if (!isset($_SESSION['user'])) {
        header("Location: /webbanhang/account/login");
        exit;
    }
    include_once 'app/views/account/profile.php';
    }

    public function editProfile() {
        if (!isset($_SESSION['user'])) {
            header("Location: /webbanhang/account/login");
            exit;
        }
        include_once 'app/views/account/editProfile.php';
    }







    public function updateProfile() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            header('Location: /webbanhang/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $result = $this->accountModel->updateProfile($userId, $name, $email, $phone, $address);
            if ($result) {
                $_SESSION['user']['fullname'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone'] = $phone;
                $_SESSION['user']['address'] = $address;
                $_SESSION['success'] = 'Cập nhật thành công!';
            }
            header('Location: /webbanhang/profile');
        }
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                $_SESSION['user'] = [
                    'id' => $account->id,
                    'username' => $account->username,
                    'fullname' => $account->fullname,
                    'email' => $account->email,
                    'phone' => $account->phone,
                    'address' => $account->address,
                    'role' => $account->role ?? 'user'
                ];
                header('Location: /webbanhang/product');
                exit;
            } else {
                $errors['login'] = "Tài khoản hoặc mật khẩu không đúng.";
                include_once 'app/views/account/login.php';
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /webbanhang/account/login');
        exit;
    }
}
