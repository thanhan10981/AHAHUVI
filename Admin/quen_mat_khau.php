<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Khôi phục mật khẩu | Website quản trị AHAHUVI</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/laymkadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="../IMG/logo_admin.png" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-p">
            <img src="../img/fg-img.png" alt="fg-img.png">
        </div>
        <div class="container-login">
            <form class="login-tieude" action="../Admin/xu_ly_laymk.php" method="post">
                <div class="login-t">
                    <b>KHÔI PHỤC MẬT KHẨU</b>
                </div>
                <div class="input-email">
                    <input class="input" type="text" placeholder="Nhập email" name="email" id="email" value="" />
                </div>
                <div class="btn">
                    <input type="submit" value="Lấy mật khẩu" name="btn"/>
                </div>
                <div class="text">
                    <a class="txt2" href="../Admin/dangnhapadmin.php">
                        Trở về đăng nhập
                    </a>
                </div>
            </form>
        </div>
        <div class="footer">
            Phần mềm quản lý Bán sách AHAHUVI<i class="far fa-copyright" aria-hidden="true"></i>
            <a class="txt2" href="https://www.facebook.com/anvo10981/"> Code Bởi Nhóm 1</a>
        </div>
    </div>
</body>
</html>
