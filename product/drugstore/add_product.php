<?php 
    session_start();
    if (!$_SESSION['user_detail']->customer_id) { 
        echo ' <script language="javascript"> window.location = "../../user/login.php"; </script>'; 
    } 
    include '../../connect.php'; 
    $id = $_GET['id']; 
    $type = $_GET['type'];
    $customer_id = $_SESSION['user_detail']->customer_id; 
    $query = mysqli_query($conn, "SELECT * FROM `Orders` WHERE medicine_id = '$id' AND customer_id = '$customer_id'");
    $row = mysqli_fetch_assoc($query); 

    if ($row) { 
        if ($type == 'add'){ 
            $quantity = $row['quantity'] + 1; 
        } else { 
            $quantity = $row['quantity'] - 1; 
        } 
        $queryInsertCart = "UPDATE `Order_Detail` SET `quantity`= '$quantity' WHERE customer_id = '$customer_id' AND medicine_id = '$id'"; 
    } else { 
        if ($type == 'add') { 
            $queryInsertCart = "INSERT INTO `Order_Detail` (customer_id, medicine_id, quantity) VALUES ('$customer_id', '$id', 1)"; 
        }
    } 

    $result = mysqli_query($conn, $queryInsertCart); 
    echo '<script language="javascript"> window.location = "./cart.php"; </script>'; 
?>
