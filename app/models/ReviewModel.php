<?php
class ReviewModel
{
    private $db;

    public function __construct()
    {
        require_once(__DIR__ . '/../config/database.php');
        $this->db = (new Database())->getConnection();
    }

    public function getAverageRating($product_id)
    {
        $stmt = $this->db->prepare("SELECT AVG(rating) FROM review WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return round($stmt->fetchColumn(), 1) ?: 0;
    }

    public function create($user_id, $product_id, $order_id, $rating, $comment)
    {
        $stmt = $this->db->prepare("
            INSERT INTO review (user_id, product_id, order_id, rating, comment, created_at)
            VALUES (:user_id, :product_id, :order_id, :rating, :comment, NOW())
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        return $stmt->execute();
    }

    public function getReviewsByProductId($product_id)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, u.username 
            FROM review r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = :product_id
            ORDER BY r.created_at DESC
        ");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exists($user_id, $product_id, $order_id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM review WHERE user_id = ? AND product_id = ? AND order_id = ?");
        $stmt->execute([$user_id, $product_id, $order_id]);
        return $stmt->fetchColumn() > 0;
    }
}
