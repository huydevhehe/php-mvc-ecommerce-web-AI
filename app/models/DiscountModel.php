<?php
class DiscountModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ✅ Lấy tất cả mã giảm giá
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM discount_codes ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Thêm mã mới
    public function add($code, $percent, $limit) {
        try {
            $stmt = $this->db->prepare("INSERT INTO discount_codes (code, discount_percent, usage_limit, used_count, is_active, created_at)
                                        VALUES (:code, :percent, :limit, 0, 1, NOW())");
            return $stmt->execute([
                ':code' => $code,
                ':percent' => $percent,
                ':limit' => $limit
            ]);
        } catch (PDOException $e) {
            error_log('❌ Add discount error: ' . $e->getMessage());
            return false;
        }
    }

    // ✅ Xóa mã theo ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM discount_codes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // ✅ Lấy danh sách mã còn hiệu lực
    public function getAvailableDiscounts() {
        $stmt = $this->db->query("SELECT * FROM discount_codes WHERE is_active = 1 AND (usage_limit = 0 OR used_count < usage_limit)");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Tìm mã giảm giá cụ thể để áp dụng trong checkout
    public function getByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM discount_codes WHERE code = :code AND is_active = 1");
        $stmt->execute([':code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Tăng lượt sử dụng mã sau khi áp dụng
    public function incrementUsedCount($code) {
        $stmt = $this->db->prepare("UPDATE discount_codes SET used_count = used_count + 1 WHERE code = :code");
        return $stmt->execute([':code' => $code]);
    }
}
    