<?php
class CategoryModel
{
    private $db;
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }
    // danh mục tìm kiếm 
    public function getAllCategories() {
    $sql = "SELECT * FROM categories";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function create($name, $description) {
    $stmt = $this->conn->prepare("INSERT INTO category (name, description) VALUES (:name, :description)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

public function getById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM category WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function update($id, $name, $description) {
    $stmt = $this->conn->prepare("UPDATE category SET name = :name, description = :description WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

public function delete($id) {
    $stmt = $this->conn->prepare("DELETE FROM category WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

}
?>
