<?php
session_start(); // Đảm bảo session được khởi tạo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $pas = $password;
    if ($password != $confirm_password) {
        echo "<script>alert('Mật khẩu và xác nhận mật khẩu không khớp.'); window.location.href = '../Home/tao_mk.php'; </script>";
        exit();     
    } else {
        $email = $_SESSION['email']; // Lấy email từ session
        if (empty($email)) {
            echo "<script>alert('Không tìm thấy địa chỉ email.'); window.location.href = '../Home/tao_mk.php'; </script>";
            exit();
        }

        require("../Home/connect.php");
        $sql = "UPDATE khach_hang SET mk = '$pas' WHERE email='$email'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Tạo mật khẩu mới thành công.'); window.location.href = '../Home/login.php'; </script>";
            exit();
        } else {
            $error_message = "Lỗi: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Mật Khẩu Mới</title>
    <link rel="icon" type="image/png" href="../IMG/logo_icon.png" />
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f4ff; /* Màu nền nhẹ */
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    box-sizing: border-box;
    animation: fadeIn 0.6s ease-in-out;
    margin-top: 60px; /* Đảm bảo có khoảng cách từ header */
}
.mkmoi {
    width: 100%;
    max-width: 400px;
    margin-top: 18%;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}
.mkmoi button {
    width: 100%; /* Đảm bảo nút chiếm toàn bộ chiều rộng của container */
    padding: 14px; /* Đặt khoảng cách bên trong để nút to hơn */
    font-size: 15px; /* Kích thước chữ lớn hơn */
    background-color: #6c5ce7; /* Màu nền của nút */
    color: white; /* Màu chữ của nút */
    border: none;
    border-radius: 5px; /* Bo góc cho nút */
    cursor: pointer;
    text-align: center; /* Căn giữa chữ trong nút */
}

label {
    display: block;
    color: #555;
    margin-bottom: 4px;
}

input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="password"]:focus {
    border-color: #6c5ce7;
    outline: none;
    box-shadow: 0 0 5px rgba(108, 92, 247, 0.5);
}
button:hover {
    background-color: #4e3ae1;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    </style>
</head>
<body>
<?php require_once 'connect.php' ?>
<?php require("../Home/header.php") ?>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" class="mkmoi" action="<?php $_SERVER["PHP_SELF"]; ?>">
        <label for="password">Mật khẩu mới:</label><br>
        <input type="password" id="password" name="password" required autocomplete="new-password"><br><br>
        <label for="confirm_password">Xác nhận mật khẩu:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password"><br><br>
        <button type="submit">Tạo Mật Khẩu Mới</button>
    </form>
    <?php require("../Home/footer.php") ?>
</body>
</html>
