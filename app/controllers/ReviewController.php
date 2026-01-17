<?php
require_once 'app/models/OrderModel.php';
require_once 'app/models/ReviewModel.php';
require_once 'app/helpers/SessionHelper.php';

class ReviewController
{
      private $db;
    private $orderModel;
    private $reviewModel;
    private $product_id;
    private $order_id;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->reviewModel = new ReviewModel($this->db);
    }


    public function add($product_id = null, $order_id = null)
    {
       

        $order = $this->orderModel->getOrderById($order_id);

        if (!$order || !is_array($order)) {
            echo "Không tìm thấy đơn hàng hoặc dữ liệu không hợp lệ.";
            return;
        }

        if (!SessionHelper::isAdmin()) {
            if (!SessionHelper::isLoggedIn() || $_SESSION['user']['id'] != $order['user_id']) {
                echo "Bạn không có quyền đánh giá đơn hàng này.";
                return;
            }
        }

        // ✅ Kiểm tra xem đã đánh giá chưa
        $user_id = $_SESSION['user']['id'];
        if ($this->reviewModel->exists($user_id, $product_id, $order_id)) {
            echo "<p style='color:red; text-align:center;'>⚠️ Bạn đã đánh giá đơn hàng này rồi.</p>";
            return;
        }

        $this->product_id = $product_id;
        $this->order_id = $order_id;

        include 'app/views/review/form.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            $product_id = $_POST['product_id'];
            $order_id = $_POST['order_id'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];

            $this->reviewModel->create($user_id, $product_id, $order_id, $rating, $comment);

            header("Location: index.php?url=product/show/$product_id");
            exit;
        }
    }
}
