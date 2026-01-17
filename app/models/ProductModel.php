<?php
class ProductModel
{
    private $db;
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
{
     
    $query = "SELECT 
        p.id, 
        p.name, 
        p.description, 
        p.price, 
        p.image, 
        c.name AS category_name,
        IFNULL(r.avg_rating, 0) AS avg_rating,
        IFNULL(od.purchase_count, 0) AS purchase_count
    FROM product p
    LEFT JOIN category c ON p.category_id = c.id
    LEFT JOIN (
        SELECT product_id, ROUND(AVG(rating), 1) AS avg_rating
        FROM review
        GROUP BY product_id
    ) r ON p.id = r.product_id
    LEFT JOIN (
        SELECT product_id, COUNT(DISTINCT order_id) AS purchase_count
        FROM order_details
        GROUP BY product_id
    ) od ON p.id = od.product_id";


    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    public function getProductById($id)
    {
        $query = "SELECT p.*, c.name as category_name
                  FROM product p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function searchProductsByName($keyword)
    {
        $query = "SELECT p.*, c.name as category_name
                  FROM product p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.name LIKE :keyword";

        $stmt = $this->conn->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addProduct($name, $description, $price, $category_id, $image = "")
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO product (name, description, price, category_id, image)
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }
   public function getSuggestionsFromCart($productIds, $limit = 5)
{
    if (empty($productIds)) return [];

    $placeholders = rtrim(str_repeat('?,', count($productIds)), ',');

    $sql = "
        SELECT od2.product_id, p.name, p.image, p.price, COUNT(*) as frequency
        FROM order_details od1
        JOIN order_details od2 ON od1.order_id = od2.order_id
        JOIN product p ON od2.product_id = p.id
        WHERE od1.product_id IN ($placeholders)
          AND od2.product_id NOT IN ($placeholders)
        GROUP BY od2.product_id
        ORDER BY frequency DESC
        LIMIT $limit
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(array_merge($productIds, $productIds)); // dùng cho IN và NOT IN

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function updateProduct($id, $name, $description, $price, $category_id, $image = null)
    {
        $fields = "name = :name, description = :description, price = :price, category_id = :category_id";
        if ($image !== null) {
            $fields .= ", image = :image";
        }

        $query = "UPDATE product SET $fields WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        if ($image !== null) {
            $stmt->bindParam(':image', $image);
        }

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    // danh mục tìm kiếm 
    public function searchProducts($search = '', $category = '', $sort = '')
{
    $sql = "SELECT 
                p.id, p.name, p.description, p.price, p.image, 
                c.name AS category_name,
                IFNULL(r.avg_rating, 0) AS avg_rating,
                IFNULL(od.purchase_count, 0) AS purchase_count
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN (
                SELECT product_id, ROUND(AVG(rating), 1) AS avg_rating
                FROM review
                GROUP BY product_id
            ) r ON p.id = r.product_id
            LEFT JOIN (
                SELECT product_id, COUNT(DISTINCT order_id) AS purchase_count
                FROM order_details
                GROUP BY product_id
            ) od ON p.id = od.product_id
            WHERE 1";

    $params = [];

    if ($search !== '') {
        $sql .= " AND p.name LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    if ($category !== '') {
        $sql .= " AND p.category_id = :category";
        $params[':category'] = $category;
    }

    if ($sort === 'asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($sort === 'desc') {
        $sql .= " ORDER BY p.price DESC";
    }

    $stmt = $this->conn->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    public function searchProductsByNameSorted($keyword, $sort)
{
    $sql = "SELECT 
                p.id, p.name, p.description, p.price, p.image, 
                c.name AS category_name,
                IFNULL(r.avg_rating, 0) AS avg_rating,
                IFNULL(od.purchase_count, 0) AS purchase_count
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN (
                SELECT product_id, ROUND(AVG(rating), 1) AS avg_rating
                FROM review
                GROUP BY product_id
            ) r ON p.id = r.product_id
            LEFT JOIN (
                SELECT product_id, COUNT(DISTINCT order_id) AS purchase_count
                FROM order_details
                GROUP BY product_id
            ) od ON p.id = od.product_id
            WHERE p.name LIKE :keyword";  // ✅ BỔ SUNG ĐIỀU KIỆN

    if ($sort === 'asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($sort === 'desc') {
        $sql .= " ORDER BY p.price DESC";
    }


        
    $stmt = $this->conn->prepare($sql);
    $kw = '%' . $keyword . '%';
    $stmt->bindParam(':keyword', $kw);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    public function getProductsSorted($sort)
{
      $sql = "SELECT 
                p.id, p.name, p.description, p.price, p.image, 
                c.name AS category_name,
                IFNULL(r.avg_rating, 0) AS avg_rating,
                IFNULL(od.purchase_count, 0) AS purchase_count
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            LEFT JOIN (
                SELECT product_id, ROUND(AVG(rating), 1) AS avg_rating
                FROM review
                GROUP BY product_id
            ) r ON p.id = r.product_id
            LEFT JOIN (
                SELECT product_id, COUNT(DISTINCT order_id) AS purchase_count
                FROM order_details
                GROUP BY product_id
            ) od ON p.id = od.product_id
            WHERE 1";

    if ($sort === 'asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($sort === 'desc') {
        $sql .= " ORDER BY p.price DESC";
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
   


    public function deleteProduct($id)
    {
        $query = "DELETE FROM product WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
