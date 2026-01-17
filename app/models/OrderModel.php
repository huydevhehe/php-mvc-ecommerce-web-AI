<?php
class OrderModel
{
    private $db;

    public function __construct($db = null)
    {
        if ($db !== null) {
            $this->db = $db;
        } else {
            require_once(__DIR__ . '/../config/database.php');
            $this->db = (new Database())->getConnection();
        }
    }

    // Lấy tất cả đơn hàng (dành cho admin)
    public function getAllOrders()
    {
        $stmt = $this->db->prepare("SELECT * FROM orders ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo ID
    public function getOrderById($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        return $stmt->execute();
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT od.*, p.name, p.image 
            FROM order_details od
            JOIN product p ON od.product_id = p.id
            WHERE od.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo số điện thoại (dành cho khách xem lịch sử)
    public function getOrdersByPhone($phone)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE phone = :phone ORDER BY created_at DESC");
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔢 Đếm lượt mua 1 sản phẩm (dành cho hiển thị sản phẩm)
    public function countProductPurchased($product_id)
    {
        $stmt = $this->db->prepare("
            SELECT SUM(od.quantity)
            FROM order_details od
            JOIN orders o ON o.id = od.order_id
            WHERE od.product_id = ? AND o.status = 2
        ");
        $stmt->execute([$product_id]);
        return (int)$stmt->fetchColumn();
    }
}
