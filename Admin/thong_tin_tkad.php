<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="../Css/thong_tin_admin.css">
</head>

<body>
    <div class="than_admin">

        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>THÔNG TIN TÀI KHOẢN</p>
            </div>
            <div class="thong_tin_tai_khoan">
                <div class="content">
                    <div class="info-card">
                        <h2>Thông tin cá nhân</h2>
                        <?php
                        $ma_tai_khoan = $_SESSION["ma_tai_khoan"];
                        require("../Home/connect.php");
                        $sql = "SELECT * FROM tai_khoan_quan_tri WHERE ma_tai_khoan = '$ma_tai_khoan'";
                        $r = $conn->query($sql);
                        $row = $r->fetch_assoc();
                        echo '<p><strong>Họ Tên: </strong>' . $row['ho_ten'] . '</p>
                    <p><strong>Email: </strong>' . $row['email'] . '</p>
                    <p><strong>Mã Tài Khoản: </strong>' . $row['ma_tai_khoan'] . '</p>
                    ' ?>
                    </div>

                    <?php
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    if (strpos($user_agent, 'Chrome') !== false) {
                        $browser = "Chrome";
                    } elseif (strpos($user_agent, 'Firefox') !== false) {
                        $browser = "Firefox";
                    } elseif (strpos($user_agent, 'Safari') !== false) {
                        $browser = "Safari";
                    } else {
                        $browser = "Unknown Browser";
                    }

                    if (strpos($user_agent, 'Windows') !== false) {
                        $os = "Windows";
                    } elseif (strpos($user_agent, 'Mac') !== false) {
                        $os = "MacOS";
                    } elseif (strpos($user_agent, 'Linux') !== false) {
                        $os = "Linux";
                    } else {
                        $os = "Unknown OS";
                    }
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $device_info = "$browser trên $os";
                    $last_login_time = date("d/m/Y, h:i A");
                    ?>

                    <div class="info-card">
                        <h2>Nhật ký đăng nhập</h2>
                        <p><strong>Lần đăng nhập gần nhất:</strong> <?php echo $last_login_time; ?></p>
                        <p><strong>IP đăng nhập:</strong> <?php echo $ip_address; ?></p>
                        <p><strong>Thiết bị:</strong> <?php echo $device_info; ?></p>
                    </div>


                </div>

                <!-- Action Section -->
                <div class="action">
                    <button class="edit-btn">Chỉnh sửa thông tin</button>
                </div>
                <div class="edit-form-container" id="edit-form">
                    <form action="update_user_info.php" method="POST" class="edit-form">
                        <h2>Chỉnh sửa thông tin</h2>
                        <label for="ho_ten">Họ Tên:</label>
                        <input type="text" id="ho_ten" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" required>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                        <label for="matkhau">Mật khẩu:</label>
                        <input type="password" id="matkhau" name="matkhau" placeholder="Nhập mật khẩu mới (nếu muốn thay đổi)">
                        <div class="form-buttons">
                            <button type="submit" class="save-btn">Lưu</button>
                            <button type="button" class="cancel-btn" onclick="closeEditForm()">Hủy</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</body>
<script>
    document.querySelector('.edit-btn').addEventListener('click', function() {
        document.getElementById('edit-form').style.display = 'flex';
    });

    function closeEditForm() {
        document.getElementById('edit-form').style.display = 'none';
    }
</script>

</html>