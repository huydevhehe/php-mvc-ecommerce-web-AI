<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/config/database.php';

class ProfileController {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function index() {
    if (!isset($_SESSION['user'])) {
        header('Location: /webbanhang/account/login');
        exit;
    }

    require_once 'app/models/UserModel.php';
    $userModel = new UserModel();
    $user = $userModel->getUserById($_SESSION['user']['id']); // lấy dữ liệu mới nhất từ DB

    include 'app/views/account/profile.php';
}


    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $id = $_SESSION['user']['id'];
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Cập nhật DB
            $query = "UPDATE users 
                      SET fullname = :fullname, email = :email, address = :address, phone = :phone 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Cập nhật session
            $_SESSION['user']['fullname'] = $fullname;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['phone'] = $phone;

            header('Location: /webbanhang/profile');
            exit;
        }
    }
}
