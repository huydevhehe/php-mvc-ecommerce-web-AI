<?php
require_once 'app/models/DiscountModel.php';

class DiscountController
{
    private $model;

    public function __construct()
    {
        $db = (new Database())->getConnection();
        $this->model = new DiscountModel($db);
    }

    // Danh sách mã giảm giá
    public function index()
    {
        $discounts = $this->model->getAll();
        include 'app/views/discount/index.php';
    }

    // Xử lý thêm mã mới
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $percent = $_POST['percent'] ?? 0;
            $limit = $_POST['limit'] ?? 0;

            if ($this->model->add($code, $percent, $limit)) {
                $_SESSION['success'] = "✅ Thêm mã giảm giá thành công!";
            } else {
                $_SESSION['error'] = "❌ Mã đã tồn tại hoặc có lỗi khi thêm.";
            }

            header("Location: /webbanhang/discount/index");
            exit;
        }
    }

    // Xử lý xóa mã
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id && $this->model->delete($id)) {
            $_SESSION['success'] = "🗑️ Đã xóa mã giảm giá.";
        } else {
            $_SESSION['error'] = "❌ Không thể xóa mã.";
        }
        header("Location: /webbanhang/discount/index");
        exit;
    }
}
