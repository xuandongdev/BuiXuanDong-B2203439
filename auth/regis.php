<?php
require '../connect.php'; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Kiểm tra dữ liệu có rỗng không
    if (empty($fullname) || empty($username) || empty($email) || empty($phone) || empty($password)) {
        die("Vui lòng điền đầy đủ thông tin.");
    }

    // Kiểm tra username hoặc email đã tồn tại chưa
    $sql_check = "SELECT * FROM accounts WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        die("Tên đăng nhập hoặc email đã tồn tại.");
    }

    // Mã hóa mật khẩu
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Thêm tài khoản vào bảng account
    $sql_insert_account = "INSERT INTO accounts (username, password_hash, email, phone) VALUES (?, ?, ?, ?)";
    $stmt_insert_account = $conn->prepare($sql_insert_account);
    $stmt_insert_account->bind_param("ssss", $username, $password_hash, $email, $phone);

    if ($stmt_insert_account->execute()) {
        echo "<script>
                alert('Đăng ký thành công! Bạn sẽ được chuyển đến trang đăng nhập sau 10 giây.');
                setTimeout(function(){ window.location.href = 'login.php'; }, 10000);
              </script>";
    } else {
        echo "Lỗi đăng ký: " . $stmt_insert_account->error;
    }

    // Đóng kết nối
    $stmt_insert_account->close();
    $stmt_check->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./login_regis.css">

</head>

<body>
    <div class="wrapper">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Register</div>
            </div>
        </div>
        <form action="regis.php" method="POST" class="register-form" autocomplete="off">

            <div class="input-box">
                <input type="text" class="input-field" id="reg-fullname" name="fullname" required>
                <label for="reg-fullname" class="label">Full Name</label>
                <i class='bx bx-user-circle icon'></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" id="reg-name" required>
                <label for="reg-name" class="label">Username</label>
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" id="reg-email" required>
                <label for="reg-email" class="label">Email</label>
                <i class='bx bx-envelope icon'></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" id="reg-phone" required>
                <label for="reg-phone" class="label">Phone</label>
                <i class='bx bx-phone icon'></i>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" id="reg-pass" required>
                <label for="reg-pass" class="label">Password</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>
            <div class="form-cols">
                <div class="col-1">
                    <input type="checkbox" id="agree">
                    <label for="agree"> I agree to terms & conditions</label>
                </div>
                <div class="col-2"></div>
            </div>
            <div class="input-box">
                <button class="btn-submit" id="SignUpBtn">Sign Up <i class='bx bx-user-plus'></i></button>
            </div>
            <div class="switch-form">
                <span>Already have an account? <a href="login.php">Login</a></span>
            </div>
        </form>
    </div>
</body>

</html>