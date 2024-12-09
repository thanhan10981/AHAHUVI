<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="icon" href="../IMG/logo_icon.png">
    <link rel="stylesheet" href="../Css/quen_mk.css">
    
</head>
<body>

    <?php require_once 'connect.php' ?>
    <?php require("../Home/header.php") ?>
    <div class="auth-container">

        <div class="nav-links">
            <a class="login active">KHÔI PHỤC MẬT KHẨU</a>
        </div>
        <!-- Quên mk -->
        <div id="login-form" class="form-container active">
            <form method="POST" action="../Home/xuly_laymk.php">
                <label for="">Email</label>
                <div class="input-email">
                    <input type="text" placeholder="Nhập email đã đăng ký" name="email" id="email" value="" />
                </div>
                <div class="btn">
                    <button type="submit" > Lấy mã xác nhận </button>
                </div>
                
                <div class="text">
                    <a class="txt2" href="../Home/login.php">
                        Trở về đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php require("../Home/footer.php") ?>

</body>

</html>