<?php
class Items {
    private $conn;
    private $table_name = "items";

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function create($item) {
        $query = "INSERT INTO " . $this->table_name . " (title, year, description, price, category_id, created, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $item['title']);
        $stmt->bindParam(2, $item['year']);
        $stmt->bindParam(3, $item['description']);
        $stmt->bindParam(4, $item['price']);
        $stmt->bindParam(5, $item['category_id']);
        $stmt->bindParam(6, $item['created']);
        $stmt->bindParam(7, $item['image_url']);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read($id = null) {
        if ($id) {
            $query = "SELECT i.*, c.name as category_name FROM " . $this->table_name . " i LEFT JOIN categories c ON i.category_id = c.id WHERE i.id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
        } else {
            $query = "SELECT i.*, c.name as category_name FROM " . $this->table_name . " i LEFT JOIN categories c ON i.category_id = c.id";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return false;
        }

        return $result;
    }

    public function update($id, $item) {
        $query = "UPDATE " . $this->table_name . " SET title = ?, year = ?, description = ?, price = ?, category_id = ?, modified = ?, image_url = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $item['title']);
        $stmt->bindParam(2, $item['year']);
        $stmt->bindParam(3, $item['description']);
        $stmt->bindParam(4, $item['price']);
        $stmt->bindParam(5, $item['category_id']);
        $stmt->bindParam(6, $item['modified']);
        $stmt->bindParam(7, $item['image_url']);
        $stmt->bindParam(8, $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>