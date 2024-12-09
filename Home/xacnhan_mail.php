<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Kiểm tra nếu email và mã xác nhận có trong session
if (isset($_SESSION['email']) && isset($_SESSION['code'])) {
    $email = $_SESSION['email'];
    $code = $_SESSION['code'];

    // Kiểm tra nếu form đã được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verification_code"])) {
        $verification_code = $_POST["verification_code"];

        // So sánh mã xác nhận
        if ($verification_code == $code) {
            // Nếu mã đúng, chuyển hướng đến trang tạo mật khẩu mới
            header("Location: ../Home/tao_mk.php?email=" . urlencode($email));
            exit();
        } else {
            // Nếu mã không đúng, hiển thị thông báo lỗi
            echo "<script>alert('Mã xác nhận không chính xác. Vui lòng thử lại.');</script>";
        }
    }
} else {
    // Nếu không có session, hiển thị thông báo lỗi
    echo "<script>alert('Không có thông tin xác nhận email.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh mã</title>
    <link rel="stylesheet" type="text/css" href="../css/laymk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="../IMG/logo_icon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<?php require("../Home/header.php") ?>
    <div class="container">
        <div class="container-login">
            <form class="login-tieude" action="" method="post">
                <div class="login-t">
                    <b>NHẬP MÃ XÁC NHẬN</b>
                </div>
                <div class="input-email">
                    <input class="input" type="text" placeholder="Nhập mã xác nhận" name="verification_code" id="verification_code" required />
                </div>
                <div class="btn">
                    <input type="submit" value="Xác nhận" name="btn"/>
                </div>
                <div class="text">
                    <a class="txt2" href="../Home/login.php">
                        Trở về đăng nhập
                    </a>
                </div>
            </form>
        </div>
        <?php require("../Home/footer.php") ?>
    </div>

</body>
</html>
