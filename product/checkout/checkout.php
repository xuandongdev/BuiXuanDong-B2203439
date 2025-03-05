<?php
session_start();
require_once __DIR__ . '/../../connect.php';
require_once __DIR__ . '/../../controller/PaymentController.php';


$user_id = isset($_SESSION['user_detail']->id_user) ? $_SESSION['user_detail']->id_user : 1;


$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

if (empty($cart)) {
    echo "Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.";
    exit;
}

$paymentController = new PaymentController($conn);
$orderInfo = $paymentController->checkout($user_id, $cart);

unset($_SESSION['cart']);


$qrData = "OrderID:" . $orderInfo['order_id'] . ";Total:" . $orderInfo['total'];

$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thanh toán - Nhà thuốc 24h</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .qr-code {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center">Thanh toán</h1>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h3>Đơn hàng của bạn</h3>
                <p><strong>Mã đơn hàng:</strong> <?php echo $orderInfo['order_id']; ?></p>
                <p><strong>Tổng tiền:</strong> <?php echo number_format($orderInfo['total'], 2); ?> VNĐ</p>
                <p>Quét mã QR bên dưới để thanh toán</p>
                <div class="qr-code">
                    <img src="<?php echo $qrUrl; ?>" alt="QR Code thanh toán">
                </div>
                <a href="../../product/drugstore/drugstore.php" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>