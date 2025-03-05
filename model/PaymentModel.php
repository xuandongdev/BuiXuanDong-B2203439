<?php

    class PaymentModel
    {
        private $conn;

        public function __construct($conn)
        {
            $this->conn = $conn;
        }

        
        public function createOrder($orderData)
        {
            $total = $orderData['total'];
           
            $status_id = 1;

            
            $stmt = $this->conn->prepare("INSERT INTO orders (order_id, total_amount, status_id) VALUES (NULL, ?, ?)");
            $stmt->bind_param("di", $total, $status_id);
            $stmt->execute();
            $order_id = $stmt->insert_id;
            $stmt->close();

            return $order_id;
        }
    }
?>