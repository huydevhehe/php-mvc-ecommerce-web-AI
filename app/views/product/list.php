<?php
require_once 'app/helpers/SessionHelper.php';
include 'app/views/shares/header.php';
?>

<!-- BANNER CAROUSEL -->
<div class="container mt-3">
    <div id="bannerCarousel" class="carousel slide mb-4 rounded" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner rounded shadow-sm">
            <div class="carousel-item active">
                <img src="/webbanhang/uploads/banner/1.jpg" class="d-block w-100 banner-img" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="/webbanhang/uploads/banner/2.jpg" class="d-block w-100 banner-img" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="/webbanhang/uploads/banner/3.jpg" class="d-block w-100 banner-img" alt="Banner 3">
            </div>
            <div class="carousel-item">
                <img src="/webbanhang/uploads/banner/4.jpg" class="d-block w-100 banner-img" alt="Banner 4">
            </div>
        </div>

        <!-- Nút chuyển trái/phải mờ -->
        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon custom-arrow" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon custom-arrow" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>



<!-- TIÊU ĐỀ, TÌM KIẾM VÀ NÚT THÊM -->
<div class="container mt-4">
    <h1 class="mb-3 text-center">Danh sách sản phẩm</h1>

    <!-- Đoạn code mới: form tìm kiếm căn giữa gọn, không chiếm nhiều hàng -->
<form method="GET" action="" class="mb-4">
    <div class="row g-2 justify-content-center align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Tìm tên sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">Tất cả danh mục</option>
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $cat) {
                        $selected = (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-control">
                <option value="">Sắp xếp theo giá</option>
                <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : '' ?>>Giá giảm dần</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            
        </div>
    </div>
</form>


    <?php if (SessionHelper::isAdmin()): ?>
        <div class="text-center mb-4">
            <a href="/webbanhang/Product/add" class="btn rainbow-button rainbow-auto">+ Thêm sản phẩm mới</a>

        </div>
    <?php endif; ?>

    <div class="row" id="product-list">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            

            <div class="col-md-3 mb-4">
                <div class="card card-product h-100">
                    <div class="image-wrapper">
                        <?php if ($product->image): ?>
                            <img src="/webbanhang/<?= $product->image ?>" alt="<?= htmlspecialchars($product->name) ?>">
                        <?php else: ?>
                            <div class="image-wrapper bg-light text-center">Không có ảnh</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <a href="/webbanhang/Product/show/<?= $product->id ?>" class="card-title product-name mb-2"><?= htmlspecialchars($product->name) ?></a>
                        <p class="card-text product-price"><?= number_format($product->price * 1000) ?> VND</p>

                        <?php
                        $avgRating = isset($product->avg_rating) ? number_format($product->avg_rating, 1) : '0.0';
                        $purchaseCount = $product->purchase_count ?? 0;
                        ?>

                        <div class="text-muted small">
                            ⭐ <?= $avgRating ?>/5 | 🛒 <?= $purchaseCount ?> lượt mua
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <a href="/webbanhang/Product/buyNow/<?= $product->id ?>" class="btn btn-sm rainbow-button rounded-pill fw-bold shadow-sm me-1">⚡ Mua ngay</a>
                        <a href="#" onclick="addToCart(<?= $product->id ?>)" class="btn btn-sm rainbow-button">🛒 Thêm vào giỏ hàng</a>
                        <a href="/webbanhang/Product/show/<?= $product->id ?>" class="btn btn-sm rainbow-button">👁️ Xem</a>
                        <?php if (SessionHelper::isAdmin()): ?>
                            <a href="/webbanhang/Product/edit/<?= $product->id ?>" class="btn btn-sm rainbow-button ms-2">Sửa</a>
                            <button class="btn btn-sm rainbow-button ms-1" onclick="deleteProduct(<?= $product->id ?>)">Xóa</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center text-muted py-5">
            Không tìm thấy sản phẩm nào.
        </div>
    <?php endif; ?>
</div>

</div>

<?php include 'app/views/shares/footer.php'; ?>

<!-- CSS -->
<style>
    form .form-control, form select {
    min-width: 0;
    width: 100%;
}

/* Tăng thời gian trượt mượt */
.carousel-item {
    transition: transform 1.2s ease-in-out, opacity 1.2s ease-in-out;
}

.banner-img {
    height: 350px;
    object-fit: cover;
    border-radius: 15px;
}

/* Làm mờ nút chuyển ảnh */
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-size: 100% 100%;
    filter: brightness(0.6);
    width: 30px;
    height: 30px;
}/* css cho banner */

.card-product {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease;
    height: 100%;
    font-size: 15px;
}
.card-product:hover {
    transform: scale(1.02);
}
.card-product .image-wrapper {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.card-product .image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}
.rainbow-button.rainbow-auto::before {
    opacity: 1 !important;         /* luôn hiện hiệu ứng */
    animation-play-state: running; /* chạy tự động */
}

.rainbow-button {
    background: white;
    color: black;
    border: none;
    position: relative;
    z-index: 1;
    overflow: hidden;
    transition: color 0.3s ease;
}
.rainbow-button::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(60deg, #ff0000, #ff9900, #ffff00, #33cc33, #3399ff, #9900cc, #ff0066, #ff0000);
    background-size: 400% 400%;
    animation: rainbowShift 8s linear infinite;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.5s ease;
    filter: blur(10px);
}
.rainbow-button:hover {
    color: white;
}
.rainbow-button:hover::before {
    opacity: 1;
    animation-play-state: running;
}

.product-name {
    font-size: 17px;
    font-weight: 700;
    color: #1a73e8;
    text-decoration: none;
    transition: color 0.3s ease;
    display: block;
}

.product-name:hover {
    color: #0b59d6;
    text-decoration: underline;
}

.product-price {
    font-size: 16px;
    font-weight: 600;
    color: #2e7d32;
}


@keyframes rainbowShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khi chọn danh mục hoặc sắp xếp sẽ submit form ngay
    document.querySelector('select[name="category"]').addEventListener('change', function() {
        this.form.submit();
    });
    document.querySelector('select[name="sort"]').addEventListener('change', function() {
        this.form.submit();
    });

    // Khi gõ tên sản phẩm, nếu dừng 0.5s hoặc nhấn Enter sẽ tự động submit
    let searchInput = document.querySelector('input[name="search"]');
    let timer = null;
    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            searchInput.form.submit();
        }, 500); // 500ms sau khi dừng gõ sẽ submit
    });
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === "Enter") {
            e.preventDefault(); // Không reload trang, chỉ submit
            searchInput.form.submit();
        }
    });
});
function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/webbanhang/api/product/${id}`, {
            method: 'DELETE'
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product deleted successfully') {
                    location.reload();
                } else {
                    alert('Xóa sản phẩm thất bại');
                }
            });
    }
}

function addToCart(productId) {
    fetch(`/webbanhang/Product/addToCart/${productId}`)
        .then(response => {
            if (response.ok) {
                alert('🛒 Sản phẩm đã được thêm vào giỏ hàng!');
            } else {
                alert('❌ Thêm vào giỏ hàng thất bại.');
            }
        })
        .catch(error => {
            alert('❌ Lỗi mạng. Vui lòng thử lại.');
        });
}
</script>
