<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $pas = $password;
    if ($password != $confirm_password) {
        echo "<script>alert('Mật khẩu và xác nhận mật khẩu không khớp.'); window.location.href = '../Admin/tao_mat_khau_moi.php'; </script>";
        exit();     
    } else {
       
        $email = $_SESSION['email'];
        if (empty($email)) {
            echo "<script>alert('Không tìm thấy địa chỉ email.'); window.location.href = '../Admin/tao_mat_khau_moi.php'; </script>";
            exit();
        }
       
        require("../Home/connect.php");
        $sql = "UPDATE tai_khoan_quan_tri SET mat_khau = '$pas' WHERE email='$email'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Tạo mật khẩu mới thành công.'); window.location.href = '../Admin/dangnhapadmin.php'; </script>";
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
    background-color: #f0f4ff; /* Lighter background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0 auto;
}

.container {
    max-width: 450px; /* Increased width for better layout */
    width: 100%;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.6s ease-in-out;
    box-sizing: border-box; /* Ensure padding is included in width */
}


form {
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}



/* Input labels styling */
label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 8px;
    font-family: 'Arial', sans-serif;
}

/* Input fields styling */
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    font-family: 'Arial', sans-serif;
    transition: all 0.3s ease;
}

input[type="password"]:focus {
    border-color: #6c5ce7;
    outline: none;
    box-shadow: 0 0 5px rgba(108, 92, 247, 0.5);
}

/* Button styling */
button {
    width: 100%;
    padding: 12px;
    background-color: #6c5ce7;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-family: 'Arial', sans-serif;
    transition: all 0.3s ease;
}

button:hover {
    background-color: #4e3ae1;
}

/* Error message styling */
p {
    color: #e74c3c;
    font-size: 14px;
    text-align: center;
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    color: #555;
    font-size: 15px;
    display: block;
    margin-bottom: 10px;
}

input[type="password"] {
    width: 100%;
    padding: 14px;
    margin: 0; /* Remove extra margin to avoid spacing issues */
    border: 1px solid #ccc;
    border-radius: 10px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

input[type="password"]:focus {
    border-color: #4CAF50;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    outline: none;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 16px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    width: 100%;
    font-size: 17px;
    font-weight: 600;
    transition: background-color 0.3s, transform 0.2s;
}

button[type="submit"]:hover {
    background-color: #45a049;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 128, 0, 0.2);
}

button[type="submit"]:active {
    transform: translateY(1px);
    box-shadow: none;
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

.error-message {
    text-align: center;
    color: #ff4d4d;
    font-weight: 600;
    background-color: #ffe6e6;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 25px;
}



    </style>
</head>
<body>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php $_SERVER["PHP_SELF"]; ?>">
        <label for="password">Mật khẩu mới:</label><br>
        <input type="password" id="password" name="password" required autocomplete="new-password"><br><br>
        <label for="confirm_password">Xác nhận mật khẩu:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password"><br><br>
        <button type="submit">Tạo Mật Khẩu Mới</button>
    </form>
</body>

</html>
