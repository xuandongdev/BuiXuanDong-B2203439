<?php
    session_start();

    if (isset($_GET['id'])) {
        $medicine_id = $_GET['id'];
        if (isset($_SESSION['cart'][$medicine_id])) {
            unset($_SESSION['cart'][$medicine_id]);
            echo '<script>alert("Xóa sản phẩm khỏi giỏ hàng thành công."); window.location.href="cart.php";</script>';
        } else {
            echo '<script>alert("Sản phẩm không tồn tại trong giỏ hàng."); window.location.reload();</script>';
        }
    } else {
        echo '<script>alert("Không xác định sản phẩm cần xóa."); window.location.reload();</script>';
    }
    exit();
?>
