<?php
session_start();
require_once __DIR__ . '/../../connect.php';

if (!isset($_GET['id'])) {
    echo "Không có ID sản phẩm.";
    exit;
}

$medicine_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM medicine WHERE medicine_id = ?");
$stmt->bind_param("i", $medicine_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Sản phẩm không tồn tại.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Chi tiết sản phẩm</title>
   
    <link rel="stylesheet" href="products-detail.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-4">
        <div class="row">
            <div class="col-md-5">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            </div>
            <div class="col-md-7">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><strong>Giá bán:</strong> <?php echo number_format($product['sales_price'], 2); ?> VNĐ</p>
                <p><strong>Chỉ định:</strong> <?php echo htmlspecialchars($product['indication']); ?></p>
                <p><strong>Hướng dẫn sử dụng:</strong> <?php echo htmlspecialchars($product['usagelnstructions']); ?></p>
                <p><strong>Ngày sản xuất:</strong> <?php echo htmlspecialchars($product['manufacture_date']); ?></p>
                <p><strong>Hạn sử dụng:</strong> <?php echo htmlspecialchars($product['expiration_date']); ?></p>
                <p><strong>Số lượng tồn:</strong> <?php echo $product['stock_quantity']; ?></p>
                
                <form action="../drugstore/add-to-cart.php" method="GET" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo $product['medicine_id']; ?>">
                    <input type="hidden" name="amount" value="1">
                    <div class="form-group">
                        <label for="unit">Chọn đơn vị:</label>
                        <select name="unit" id="unit" class="form-control w-50">
                            <option value="viên">Viên</option>
                            <option value="vỉ">Vỉ</option>
                            <option value="hộp">Hộp</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Thêm vào giỏ</button>
                </form>
            </div>
        </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>