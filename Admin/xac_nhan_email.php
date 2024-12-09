<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh mã</title>
    <link rel="stylesheet" type="text/css" href="../css/laymkadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="../IMG/logo_icon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-p">
            <img src="../img/fg-img.png" alt="fg-img.png">
        </div>
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
                    <a class="txt2" href="../Admin/dangnhapadmin.php">
                        Trở về đăng nhập
                    </a>
                </div>
            </form>
        </div>
        <div class="footer">
            Phần mềm quản lý Web Phim DESI<i class="far fa-copyright" aria-hidden="true"></i>
            <a class="txt2" href="https://www.facebook.com/anvo10981/"> Code Bởi Nhóm 6</a>
        </div>
    </div>

    <?php
    session_start();
    // Kiểm tra xem session có chứa email và mã code không
    if (isset($_SESSION['email']) && isset($_SESSION['code'])) {
        $email = $_SESSION['email'];
        $code = $_SESSION['code'];

        // Kiểm tra nếu mã xác nhận được nhập từ form
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verification_code"])) {
            $verification_code = $_POST["verification_code"];

            // So sánh mã xác nhận
            if ($verification_code == $code) {
                $_SESSION['email']= $email;
                header("Location: ../Admin/tao_mat_khau_moi.php?email=" . $email);
                exit();
            } else {
                // Mã xác nhận không chính xác, hiển thị thông báo lỗi
                echo "Mã xác nhận không chính xác. Vui lòng thử lại.";
            }
        }
    } else {
        // Nếu không có session, bạn có thể chuyển hướng hoặc xử lý theo ý của bạn
        echo "Không có thông tin xác nhận email";
    }
    ?>
</body>
</html>
