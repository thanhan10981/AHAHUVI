
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập    Đăng ký</title>
    <link rel="icon" href="../IMG/logo.png">
    <link rel="icon" href="data:,">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="stylesheet" href="../Css/header.css"> 
</head>
<body>

<?php require_once 'connect.php' ?>
 <?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        
    //Kiểm tra xem số điện thoại đã tồn tại trong cơ sở dữ liệu chưa
    $checkPhone_number = "SELECT * FROM khach_hang WHERE phone_number = '$phone_number'";
    $result = $conn->query($checkPhone_number);

    if ($result->num_rows > 0) {
        echo "<script>alert('Số điện thoại đã tồn tại!');</script>";
    } else {
         // Băm mật khẩu trước khi lưu vào cơ sở dữ liệu
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Thực hiện thêm thông tin đăng ký vào cơ sở dữ liệu
        $insertQuery = "INSERT INTO khach_hang (sdt, mk) VALUES ('$phone_number', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>
                    alert('Đăng ký thành công!');
                    window.location.href = '';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Có lỗi xảy ra trong quá trình đăng ký.');</script>";
        }
    }
}    
?> 

<?php require("../Home/header.php") ?>
    <div class="auth-container">
        
        <div class="nav-links">
        <a class="login active">Đăng nhập</a>
       
        <a class="register">Đăng ký</a>
       
        </div>

        <!-- Đăng nhập -->
        <div id="login-form" class="form-container active">
            <form method="POST" action="../Home/xu_ly_dn.php" >
                <label for="">Số điện thoại/Email</label>
                <input type="text" name="login_email" placeholder="Nhập số điện thoại hoặc email" required>
                <label for="">Mật khẩu</label>   
                <input type="password" name="login_password" placeholder="Nhập mật khẩu" required autocomplete="current-password">
                <div class="toggle">
    <a href="../Home/khoiphucmk.php">Quên mật khẩu?</a>
</div>
                
                <button type="submit" class="submit-btn" name="login" id="loginBtn">Đăng nhập</button>
                
            </form>
        </div>
        
        <!-- Đăng ký -->
        <div id="register-form" class="form-container">
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" >
        <div class="input-container">
            <label for="">Số điện thoại/Email</label>
            <input type="text" name="phone_number" id="phone-number" placeholder="Nhập số điện thoại hoặc email" required>
        </div>
        <label for="">Mật khẩu</label>
        <input type="password" name="password" placeholder="Nhập mật khẩu" required autocomplete="new-password">
        <button type="submit" class="submit-btn">Đăng ký</button>
    </form>
</div>

    </div>

<?php require("../Home/footer.php") ?>    

    <script src="../Js/login.js"></script>

</body>
</html>
