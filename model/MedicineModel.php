<?php
    require_once __DIR__ . '/../connect.php';

class MedicineModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getMedicineSuggestions($query) {
        $stmt = $this->conn->prepare("SELECT medicine_id, name, image_url, sales_price FROM Medicine WHERE name LIKE CONCAT('%', ?, '%') LIMIT 10");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'id' => $row['medicine_id'],
                'name' => $row['name'],
                'image_url' => $row['image_url'],
                'price' => $row['sales_price'] 
            ];
        }
        return $suggestions;
    }
    
    
    
}
?>
