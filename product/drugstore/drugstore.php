<?php
require_once __DIR__ . '/../../controller/MedicineController.php';
require_once __DIR__ . '/../../connect.php';


$controller = new MedicineController($conn);

if (isset($_POST['search']) && isset($_POST['key'])) {
  $key = $_POST['key'];
  $filter_result = $controller->searchMedicine($key);
} else if (isset($_POST['1'])) {
  $query = "SELECT * FROM `Medicine` WHERE type_id = (SELECT type_id FROM `Medicine_Type` WHERE type_name = 'dungCuYTe')";
  $filter_result = filterTable($query);
} else if (isset($_POST['2'])) {
  $query = "SELECT * FROM `Medicine` WHERE type_id = (SELECT type_id FROM `Medicine_Type` WHERE type_name = 'thuocDacTri')";
  $filter_result = filterTable($query);
} else if (isset($_POST['3'])) {
  $query = "SELECT * FROM `Medicine` WHERE type_id = (SELECT type_id FROM `Medicine_Type` WHERE type_name = 'thucPhamChucNang')";
  $filter_result = filterTable($query);
} else if (isset($_POST['4'])) {
  $query = "SELECT * FROM `Medicine` WHERE type_id = (SELECT type_id FROM `Medicine_Type` WHERE type_name = 'duocMyPham')";
  $filter_result = filterTable($query);
} else if (isset($_POST['5'])) {
  $query = "SELECT * FROM `Medicine` WHERE type_id = (SELECT type_id FROM `Medicine_Type` WHERE type_name = 'thuocChiDinh')";
  $filter_result = filterTable($query);
} else {
  $query = "SELECT * FROM `Medicine`";
  $filter_result = filterTable($query);
}

function filterTable($query)
{
  require '../../connect.php';
  $result = mysqli_query($conn, $query);
  return $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Nhà thuốc 24h</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,500;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <link rel="stylesheet" href="drugstore.css"/>
  <script src="search.js"></script>

</head>

<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light" style="box-shadow: 0 2px 20px #ccd3e4; border: none">
    <a class="navbar-brand" href="../../dashboard/home/index.php">
      <img src="https://navigates.vn/wp-content/uploads/2023/03/ctu.jpg" alt="nhathuoc24h.com" width="60px" height="auto" />
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <form class="form-inline my-2 my-lg-0" method="POST">
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="6">Tất cả</button>
          </li>
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="5">Theo chỉ định</button>
          </li>
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="4">Thuốc đặc trị</button>
          </li>
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="3">Thực phẩm chức năng</button>
          </li>
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="2">Dược mỹ phẩm</button>
          </li>
          <li class="nav-item nav-link active">
            <button class="btn" type="submit" name="1">Dụng cụ y tế</button>
          </li>
        </form>
      </ul>
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <form id="searchForm" class="form-inline my-2 my-lg-0">
          <input type="text" id="search" placeholder="Nhập tên thuốc..." autocomplete="off">
          <button type="button" name="search" class="btn btn-outline-success my-2 my-sm-0">Tìm kiếm</button>
        </form>
        <div id="suggestions"></div>
        <div id="searchResults" class="item-menu"></div>
        <li class="nav-item active mx-4">
          <a class="nav-item nav-link active text-danger" href="./cart.php">
            <i class="fa fa-cart-plus"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="d-flex justify-content-center" style="margin-top: 70px; margin-bottom: 20px; height: calc(100vh - 131px); overflow-y: auto; padding: 10px 0px;">
    <div class="row wrap justify-content-center w-100">
      <?php if ($filter_result instanceof mysqli_result) {
        while ($row = mysqli_fetch_assoc($filter_result)) : ?>
          <div style="width: 250px; margin: 10px">
            <div class="card" style="box-shadow: 0 2px 20px #ccd3e4; border: none">
              <img class="card-img-top" src="<?php echo $row['image_url']; ?>" alt="Card image cap" height="190" style="object-fit: cover" />
              <div class="card-body d-flex flex-column justify-content-around">
                <div>
                  <h5 class="card-title"><?php echo $row['name']; ?></h5>
                </div>
                <div>
                  <span class="card-text text-truncate d-block"><?php echo $row['indication']; ?></span>
                  <p class="card-text text-danger">
                    <?php echo number_format($row['sales_price']); ?> VNĐ
                  </p>
                </div>
                <div class="d-flex flex-column align-items-center mt-3">
                  <form action="./add-to-cart.php" method="GET" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $row['medicine_id']; ?>">
                    <input type="hidden" name="amount" value="1">
                    <div class="form-group mb-2">
                      <select name="unit" class="form-control">
                        <option value="viên">Viên</option>
                        <option value="vỉ">Vỉ</option>
                        <option value="hộp">Hộp</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-block">Thêm vào giỏ</button>
                  </form>
                  <a href="../product_detail/product-detail.php?id=<?php echo $row['medicine_id']; ?>" class="btn btn-info mt-2">Chi tiết</a>
                </div>

              </div>
            </div>
          </div>
      <?php endwhile;
      } ?>
    </div>
  </div>
  <div class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Giỏ hàng của bạn</h2>
      </div>
      <div class="modal-body" id="cart_item"></div>
      <div class="modal-footer">
        <span class="total">Tổng cộng: <span id="total_bill"></span></span>
        <button type="button" class="btn-footer" onclick="closeModal()">Tiếp tục mua hàng</button>
        <button type="button" class="btn-footer btn-primary" onclick="onPay()">Thanh toán</button>
      </div>
    </div>
  </div>
  <div class="fixed-bottom d-flex justify-content-end pr-5">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7HUIbX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
  function closeModal() {
    document.querySelector(".modal").style.display = "none";
  }

  function onPay() {
    alert("Thanh toán thành công!");
  }
</script>

</html>