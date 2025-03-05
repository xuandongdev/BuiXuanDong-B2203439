<?php
    session_start();
    require_once __DIR__ . '/../../connect.php';


    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $total = 0;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giỏ hàng - Nhà thuốc 24h</title>

    <link rel="stylesheet" href="drugstore.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .product-img {
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container my-4">
        <h1 class="text-center">Giỏ hàng của bạn</h1>

        <?php if (empty($cart)): ?>
            <?php echo '<script>alert("Giỏ hàng của bạn trống."); window.location.href="drugstore.php";</script>' ?>
            <!-- <p class="text-center">Giỏ hàng của bạn trống.</p> -->
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên thuốc</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['amount'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <img class="product-img" src="<?php echo $item['image_url']; ?>"
                                    alt="<?php echo $item['name']; ?>" width="80">
                            </td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['amount']; ?>         <?php echo $item['unit']; ?></td>
                            <td><?php echo number_format($item['price'], 2); ?> VNĐ</td>
                            <td><?php echo number_format($subtotal, 2); ?> VNĐ</td>
                            <td>

                                <a href="remove-from-cart.php?id=<?php echo $item['id']; ?>&unit=<?php echo urlencode($item['unit']); ?>"
                                    class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Tổng cộng:</th>
                        <th colspan="2"><?php echo number_format($total, 2); ?> VNĐ</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <a href="../checkout/checkout.php" class="btn btn-primary">Thanh toán</a>
            </div>
            <div class="text-center my-4">
                <a href="drugstore.php" class="btn btn-secondary">Trở về</a>
            </div>
        <?php endif; ?>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>