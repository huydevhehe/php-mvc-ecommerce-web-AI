<?php
require_once 'app/models/OrderModel.php';
require_once 'app/helpers/SessionHelper.php';

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    // Admin: xem toàn bộ đơn hàng
    public function index()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /webbanhang');
            exit;
        }

        $orders = $this->orderModel->getAllOrders();
        include 'app/views/order/adminList.php';
    }

    // Admin: cập nhật trạng thái đơn hàng
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && SessionHelper::isAdmin()) {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            $this->orderModel->updateOrderStatus($orderId, $status);
            header('Location: /webbanhang/Order');
            exit;
        }
    }

    public function adminList()
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập trang này.";
            return;
        }

        $orders = $this->orderModel->getAllOrders();
        include 'app/views/order/adminList.php';
    }

    // Người dùng: xem các đơn hàng của mình
    public function myOrders()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/Account/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getOrdersByUserId($userId);
        include 'app/views/product/myOrders.php';
    }

    // Cả admin và người dùng: xem chi tiết đơn hàng
    public function detail($orderId)
    {
        // Lấy đơn hàng
        $order = $this->orderModel->getOrderById($orderId);

        if (!$order || !is_array($order)) {
            echo "Không tìm thấy đơn hàng hoặc dữ liệu không hợp lệ.";
            return;
        }

        // Không phải admin thì chỉ xem đơn của chính mình
        if (!SessionHelper::isAdmin()) {
            if (!SessionHelper::isLoggedIn() || $_SESSION['user']['id'] != $order['user_id']) {
                echo "Bạn không có quyền xem đơn hàng này.";
                return;
            }
        }

        // ✅ Lấy chi tiết sản phẩm
        $orderDetails = $this->orderModel->getOrderDetails($orderId);

        // ✅ Kiểm tra đã đánh giá chưa
        require_once 'app/models/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $userId = $_SESSION['user']['id'];

        foreach ($orderDetails as &$item) {
            $item['reviewed'] = $reviewModel->exists($userId, $item['product_id'], $orderId);
        }

        // ✅ Truyền biến đúng tên xuống view
        include 'app/views/order/detail.php';
    }
}
