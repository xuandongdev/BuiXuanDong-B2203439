<?php
    session_start();
    require_once __DIR__ . '/../../connect.php';

    if (isset($_GET['id']) && isset($_GET['amount'])) {
        $medicine_id = intval($_GET['id']);
        $amount = intval($_GET['amount']);
        $unit = isset($_GET['unit']) ? $_GET['unit'] : '';  

       
        $stmt = $conn->prepare("SELECT medicine_id, name, sales_price, image_url FROM medicine WHERE medicine_id = ?");
        $stmt->bind_param("i", $medicine_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $medicine = $result->fetch_assoc();
            
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            
            if (isset($_SESSION['cart'][$medicine_id]) && $_SESSION['cart'][$medicine_id]['unit'] == $unit) {
                $_SESSION['cart'][$medicine_id]['amount'] += $amount;
            } else {
                
                $_SESSION['cart'][$medicine_id] = array(
                    'id'        => $medicine['medicine_id'],
                    'name'      => $medicine['name'],
                    'price'     => $medicine['sales_price'],
                    'image_url' => $medicine['image_url'],
                    'amount'    => $amount,
                    'unit'      => $unit
                );
            }
        }
    }

    echo '<script>alert("Thêm sản phẩm vào giỏ thành công"); window.location.href="drugstore.php";</script>';
    exit();
?>
