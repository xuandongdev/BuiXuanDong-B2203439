<?php
session_start();
require '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra dữ liệu có rỗng không
    if (empty($username) || empty($password)) {
        die("Vui lòng nhập username và mật khẩu.");
    }

    // Kiểm tra xem username có tồn tại không
    $sql = "SELECT username, password_hash FROM accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password_hash"])) {
            // Lưu thông tin vào session
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            echo "Đăng nhập thành công!";
            header("Location: index.php");
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Username không tồn tại.";
    }

    $stmt->close();
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
        <!-- Form Login -->
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Login</div>
                <div class="title-register" style="display: none;">Register</div>
            </div>
        </div>

        <form action="login.php" method="POST" class="login-form" autocomplete="off">
            <div class="input-box">
                <input type="text" class="input-field" id="log-username" name="username" required>
                <label for="log-username" class="label">Username</label>
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" id="log-pass" name="password" required>
                <label for="log-pass" class="label">Password</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>
            <div class="form-cols">
                <div class="col-1"></div>
                <div class="col-2">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
            <div class="input-box">
                <button type="submit" class="btn-submit" id="SignInBtn">
                    Sign In <i class='bx bx-log-in'></i>
                </button>
            </div>
        </form>

        <div class="switch-form">
            <span>Don't have an account? <a href="regis.php">Register</a></span>
        </div>

    </div>
</body>

</html>