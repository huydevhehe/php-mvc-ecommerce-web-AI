<?php
require_once 'app/config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect(); // không còn báo lỗi

    }

    // ✅ Hàm lấy thông tin người dùng theo ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Hàm cập nhật địa chỉ người dùng
    public function updateAddress($id, $address) {
        $stmt = $this->db->prepare("UPDATE users SET address = :address WHERE id = :id");
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ✅ Hàm cập nhật toàn bộ thông tin (ví dụ cho form sửa thông tin cá nhân)
    public function updateProfile($id, $fullname, $phone, $address) {
        $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, phone = :phone, address = :address WHERE id = :id");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
