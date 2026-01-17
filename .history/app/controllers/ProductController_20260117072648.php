<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

   public function index()
{
     $products = $this->productModel->getProducts(); // ✅ PHẢI gọi đúng hàm getProducts()
    $keyword = isset($_GET['search']) ? $_GET['search'] : null;
    $sort = $_GET['sort'] ?? '';

    if ($keyword) {
        $products = $this->productModel->searchProductsByNameSorted($keyword, $sort);
    } else {
        $products = $this->productModel->getProductsSorted($sort);
    }

    include 'app/views/product/list.php';
}


    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        require_once 'app/models/ReviewModel.php';
        $reviewModel = new ReviewModel($this->db);

        $reviews = $reviewModel->getReviewsByProductId($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/product");
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/product");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $price = $_POST['price'] ?? '';
                $category_id = $_POST['category_id'] ?? null;

                $image = "";
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image = $this->uploadImage($_FILES['image']);
                }

                $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

                if (is_array($result)) {
                    $errors = $result;
                    $categories = (new CategoryModel($this->db))->getCategories();
                    include 'app/views/product/add.php';
                } else {
                    header('Location: /webbanhang/Product');
                    exit;
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => 'Lỗi server: ' . $e->getMessage()]);
            }
        }
    }

    public function edit($id)
    {
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/product");
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/product");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/product");
            exit;
        }

        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
    public function buyNow($id)
    {
        // Kiểm tra đăng nhập
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login?error=login_required');
            exit;
        }

        // Lấy sản phẩm
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        // Gán vào giỏ hàng (chỉ 1 sản phẩm)
        $_SESSION['cart'] = [
            $id => [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ]
        ];

        // Chuyển tới trang thanh toán
        header('Location: /webbanhang/Product/checkout');
        exit;
    }


    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uniqueName = uniqid() . '_' . basename($file["name"]);
        $target_file = $target_dir . $uniqueName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh quá lớn (tối đa 10MB).");
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "jfif"])) {
            throw new Exception("Chỉ chấp nhận các định dạng JPG, JPEG, PNG, GIF, JFIF.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Lỗi khi lưu ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
{
    $product = $this->productModel->getProductById($id);

    if (!$product) {
        echo "Không tìm thấy sản phẩm.";
        return;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
        ];
    }

    // Kiểm tra nếu gọi từ AJAX thì không chuyển trang
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode(['success' => true]);
        return;
    }

    header('Location: /webbanhang/Product/cart');
}


    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    public function increaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function decreaseQuantity($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']--;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: /webbanhang/Product/cart');
    }

 public function checkout()
{
    require_once 'app/models/DiscountModel.php';

    $discountModel = new DiscountModel($this->db);
    $availableDiscounts = $discountModel->getAvailableDiscounts();

    $cart = $_SESSION['cart'] ?? [];

    $productIds = array_keys($cart);
    $suggestedProducts = [];

    if (!empty($productIds)) {
        $suggestedProducts = $this->productModel->getSuggestionsFromCart($productIds); // dùng lại $this->productModel ✅
    }

    include 'app/views/product/checkout.php';
}



    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function clearCart()
    {
        unset($_SESSION['cart']);
        header('Location: /webbanhang/Product/cart');
    }

   public function processCheckout()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 👉 Thêm sản phẩm gợi ý được tick vào giỏ hàng
        $suggestedIds = $_POST['suggested_products'] ?? [];
        foreach ($suggestedIds as $id) {
            $product = $this->productModel->getProductById($id);
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image' => $product->image
                ];
            }
        }

        // 👉 Tiếp tục xử lý đặt hàng như bình thường (các bước lấy name, phone, tạo đơn, lưu order_details...)
        // ...

        // Các bước tiếp theo trong đoạn này bạn giữ nguyên
    



        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $email = $_POST['email'] ?? null;

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "Giỏ hàng trống.";
            return;
        }

        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        }

        //code mã giảm giá
        $discount_code = $_POST['discount_code'] ?? '';
        $discount_amount = 0;

        if (!empty($discount_code)) {
            require_once 'app/models/DiscountModel.php';
            $discountModel = new DiscountModel($this->db);
            $discount = $discountModel->getByCode($discount_code);
            if ($discount && ($discount['usage_limit'] == 0 || $discount['used_count'] < $discount['usage_limit'])) {
                $discount_amount = $total * ($discount['discount_percent'] / 100) ;

                // ✅ cập nhật lượt dùng
                $update = $this->db->prepare("UPDATE discount_codes SET used_count = used_count + 1 WHERE code = :code");
                $update->execute([':code' => $discount_code]);
            }
        }

        $final_total = $total - $discount_amount;




        $this->db->beginTransaction();
        try {
           $query = "INSERT INTO orders (user_id, name, phone, address, email, created_at, status, total, discount_code, discount_amount)
                    VALUES (:user_id, :name, :phone, :address, :email, NOW(), :status, :total, :discount_code, :discount_amount)";

            $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null; // Lấy user_id nếu có đăng nhập
            
            $stmt = $this->db->prepare($query);
            $status = 0;
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':status', $status);
            
            $stmt->bindParam(':user_id', $user_id);

            $stmt->bindParam(':total', $final_total);
            $stmt->bindParam(':discount_code', $discount_code);
            $stmt->bindParam(':discount_amount', $discount_amount);


            $stmt->execute();

            $order_id = $this->db->lastInsertId();

            foreach ($cart as $product_id => $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                          VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->execute();
            }

            $this->db->commit();
            unset($_SESSION['cart']);

            require 'vendor/autoload.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nguyenquochuyc7@gmail.com';
                $mail->Password = 'YOUR_paáassword_here'; 
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('nguyenquochuyc7@gmail.com', 'ShopeeFood');
                $mail->addAddress($email, $name);
                // Thêm 2 dòng này:
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->isHTML(true);
                $mail->Subject = 'Xác nhận đơn hàng #' . $order_id;
                date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt trước khi dùng date()

                $mail->Body = '
                <!DOCTYPE html>
                <html lang="vi">
                <head>
                <meta charset="UTF-8">
                <style>
                    body {
                    font-family: "Segoe UI", Arial, sans-serif;
                    background-color: #f8f8f8;
                    margin: 0;
                    padding: 0;
                    }
                    .email-container {
                    max-width: 600px;
                    margin: 30px auto;
                    background-color: #ffffff;
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
                    border: 1px solid #eee;
                    }
                    .header {
                    background-color: #ee4d2d;
                    color: white;
                    padding: 20px;
                    text-align: center;
                    }
                    .header h2 {
                    margin: 0;
                    font-size: 22px;
                    }
                    .content {
                    padding: 25px 30px;
                    color: #333;
                    }
                    .content p {
                    font-size: 16px;
                    line-height: 1.5;
                    }
                    .order-info {
                    margin-top: 20px;
                    background-color: #f9f9f9;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    padding: 15px;
                    }
                    .order-info ul {
                    padding: 0;
                    margin: 0;
                    list-style: none;
                    }
                    .order-info li {
                    margin-bottom: 10px;
                    font-size: 15px;
                    }
                    .order-info li::before {
                    content: "🔸";
                    margin-right: 8px;
                    }
                    .cta-button {
                    display: block;
                    width: fit-content;
                    margin: 30px auto 0;
                    background-color: #ee4d2d;
                    color: white;
                    padding: 12px 24px;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: bold;
                    font-size: 15px;
                    }
                    .footer {
                    text-align: center;
                    font-size: 13px;
                    color: #888;
                    padding: 15px 0;
                    }
                </style>
                </head>
                <body>
                <div class="email-container">
                    <div class="header">
                    <h2>📦 Xác Nhận Đơn Hàng Thành Công</h2>
                    </div>
                    <div class="content">
                    <p>Xin chào <strong>' . htmlspecialchars($name) . '</strong>,</p>
                    <p>Cảm ơn bạn đã đặt hàng tại <strong>ShopeeFood</strong>! Dưới đây là thông tin đơn hàng của bạn:</p>
                    
                    <div class="order-info">
                        <ul>
                            <li><strong>Địa chỉ:</strong> ' . htmlspecialchars($address) . '</li>
                            <li><strong>SĐT:</strong> ' . htmlspecialchars($phone) . '</li>
                            <li><strong>Tổng tiền:</strong> ' . number_format($final_total * 1000) . ' đ</li>' .
                            (!empty($discount_code) ? '<li><strong>Đã áp dụng mã:</strong> ' . htmlspecialchars($discount_code) . ' (−' . number_format($discount_amount * 1000) . ' đ)</li>' : '') . '
                            <li><strong>Ngày đặt:</strong> ' . date('d/m/Y H:i') . '</li>
                        </ul>
                    </div>

                    <a class="cta-button" href="http://localhost:8080/webbanhang/Product/orderDetail/' . $order_id . '">🔍 Xem Đơn Hàng</a>

                    </div>
                    <div class="footer">
                    ShopeeFood - Giao món bạn yêu, nhanh như chớp ⚡<br>
                    Nhân viên giao hàng Huydzhehe <br>
                    Hotline hỗ trợ: 123456789
                    </div>
                </div>
                </body>
                </html>';

                $mail->send();
            } catch (Exception $e) {
                error_log("Không thể gửi email: {$mail->ErrorInfo}");
            }
            // ✅ Thêm đoạn này để hiển thị thông báo và chuyển về trang chi tiết đơn hàng
            $_SESSION['flash_message'] = "✅ Đã gửi email xác nhận đơn hàng tới mail của bạn thành công.";
            header("Location: /webbanhang/Product/orderDetail/$order_id");
            exit;
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
        }
    }
}

public function myOrders()  
{
    if (!isset($_SESSION['user'])) {
        header('Location: /webbanhang/account/login');
        exit;
    }

    $userPhone = $_SESSION['user']['phone'];
    $query = "SELECT * FROM orders WHERE phone = :phone ORDER BY created_at DESC";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':phone', $userPhone);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include 'app/views/product/myOrders.php';
}

public function orderDetail($orderId)
{
    // Lấy thông tin đơn hàng
    $query = "SELECT * FROM orders WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Không tìm thấy đơn hàng.";
        return;
    }

    // ✅ Lấy chi tiết đơn hàng kèm sản phẩm
    $query = "SELECT od.quantity, od.price, od.product_id, p.name, p.image 
              FROM order_details od 
              JOIN product p ON od.product_id = p.id 
              WHERE od.order_id = :order_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include 'app/views/order/detail.php';
}




    // tìm kiếm danh mục
   public function list()
{
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $sort = $_GET['sort'] ?? '';

    // ⚠️ Thêm dòng này để xem danh mục gửi lên
    echo "<p style='color:red;'>Danh mục đang chọn: " . htmlspecialchars($category) . "</p>";


    $db = (new Database())->getConnection(); // ✅ bổ sung

    require_once 'app/models/CategoryModel.php';
    $catModel = new CategoryModel($db);
    $categories = $catModel->getAllCategories();

    require_once 'app/models/ProductModel.php';
    $prodModel = new ProductModel($db);
    require_once 'app/models/ReviewModel.php';
    require_once 'app/models/OrderModel.php';

    $products = $prodModel->searchProducts($search, $category, $sort);

    $reviewModel = new ReviewModel($this->db);
    $orderModel = new OrderModel($this->db);

    foreach ($products as &$product) {
        $product->avg_rating = $reviewModel->getAverageRating($product->id);
        $product->purchase_count = $orderModel->countProductPurchased($product->id);
    }

    require 'app/views/product/list.php';
}


    public function orderConfirmation() {
    if (!isset($_SESSION['last_order_id'])) {
        echo "Không tìm thấy đơn hàng.";
        return;
    }

    $orderId = $_SESSION['last_order_id'];

    // Lấy đơn hàng
    $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
    $stmt->execute([':id' => $orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lấy chi tiết đơn hàng
    $stmt = $this->db->prepare("
        SELECT od.*, p.name AS product_name, p.image 
        FROM order_details od 
        JOIN product p ON od.product_id = p.id 
        WHERE od.order_id = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tính tổng tiền
    $total = 0;
    foreach ($orderDetails as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Truyền dữ liệu cho view
    
}

}
?>
