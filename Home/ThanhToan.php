<?php
    require("../Home/connect.php");
    $tongtien = 0;
    $email = '';
    $sdt = '';
    if(isset($_SESSION["id_kh"])) {
        $id_kh = $_SESSION["id_kh"];
        $sql_kh="SELECT * FROM khach_hang WHERE mkh='.$id_kh.'";
        $result_kh=$conn->query($sql_kh);
        if ($result_kh && $result_kh->num_rows > 0) {
            $row_kh = $result_kh->fetch_assoc();
            $email = $row_kh['email'];
            $sdt = $row_kh['sdt'];
        }
    }
    if (isset($_POST["tongtien"])) {
        $tongtien = (float)$_POST["tongtien"];
    }
    if (isset($_POST["sl"])) {
        $sl = (float)$_POST["sl"];
    }
    if (isset($_POST["id_sp"])) {
        $id_sp = $_POST["id_sp"];
    }
    if(isset($_POST["ds_sp"])){
        $ds_sp=$_POST["ds_sp"];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["apply-btn"])) {
        $discount_code = $_POST["ma"];
        $query = "SELECT * FROM giam_gia WHERE ma = '$discount_code' AND dieu_kien < '$tongtien'";
        $result2 = $conn->query($query);

        if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $discount_percent = (float)$row["phan_tram"];
            $tongtien = $tongtien - ($tongtien * $discount_percent / 100);
            $new_quantity = $row["sl"] - 1;
            $update_query = "UPDATE giam_gia SET sl = '$new_quantity' WHERE ma = '$discount_code'";
            $conn->query($update_query);

            echo "<script>alert('Nhập Voucher thành công. Tổng tiền mới: ' + '" . number_format($tongtien, 0, ',', '.') . " đ');</script>";
        } else {
            echo "<script>alert('Mã giảm giá không hợp lệ.');</script>";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="icon" href="http://localhost/AHAHUVI/IMG/logo_icon.png">
    <link rel="stylesheet" href="../Css/ThanhToan.css">
    <link rel="stylesheet" href="../AHAHUVI/header.css">
    <link rel="stylesheet" href="../Css/ho_tro.css">
    <link rel="icon" href="../IMG/logo_icon.png">
</head>
<body>
    <header>
        <?php 
        require("../Home/header.php");
        ?>
    </header>
    <form action="../atm/atm_momo.php" method="post" class="form-container">
        
        <h1 class="cart-container">Thanh Toán</h1>
        <div class="form-row">
        <h2>Họ và tên người nhận</h2>
        <input type="text" name="tenkh" placeholder="Nhập họ và tên người nhận" required>
        </div>
        <div class="form-row">
        <h2>Email</h2>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email);?>">
        </div>
        <div class="form-row">
        <h2>Số điện thoại</h2>
        <input type="tel" name="sdt"  value="<?php echo $sdt;?>" required >
        </div>
        <div class="form-row">
        <h2>Địa chỉ nhận hàng</h2>
        <input type="text" name="diachi" placeholder="Nhập địa chỉ nhận hàng" required>
        </div>
        <div class="form-row">
        <h2>Sản phẩm</h2>
        <input type="text" name="ds_sp" value="<?php echo $ds_sp;?>">
        </div>
        <div class="form-row">
        <h2>Mã khuyến mãi</h2>
        <input class="discount-code" type="text" placeholder="Nhập mã giảm giá" name="ma">
        </div>
        <button type="button" class="apply-btn" name="apply_btn">Áp dụng</button><br>
        <div class="form-row">
        <h2>Phương thức thanh toán</h2>
        <div class="payment-options">
            <input type="radio" name="pttt" id="momo" value="momo" required>
            <label for="momo"> Ví MoMo</label>

            <input type="radio" name="pttt" id="cash" value="cash" required>
            <label for="cash">Thanh toán khi nhận hàng</label>
        </div>
        </div>
        
        <h1 class="t-price"><br>Tổng tiền: <?= number_format($tongtien, 0, ',', '.') ?> đ<br></h1>
        <input type="hidden" name="tongtien" value="<?= $tongtien ?>">

        <button type="submit" class="submit-btn">Xác nhận thanh toán</button>
    </form>
    <script>
        document.querySelector('.apply-btn').addEventListener('click', function() {
    var discountCode = document.querySelector('input[name="ma"]').value;
    var tongtien = <?= json_encode($tongtien); ?>; // PHP xuất tổng tiền sang JavaScript

    if (discountCode.trim() === '') {
        alert('Vui lòng nhập mã giảm giá.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'apply_discount.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            if (response.success) {
                alert(response.message);
                // Cập nhật tổng tiền hiển thị
                document.querySelector('.t-price').textContent = 'Tổng tiền: ' + response.newTotalFormatted + ' đ';
                document.querySelector('input[name="tongtien"]').value = response.newTotal; // Cập nhật giá trị ẩn
            } else {
                alert(response.message);
            }
        }
    };

    xhr.send('ma=' + encodeURIComponent(discountCode) + '&tongtien=' + encodeURIComponent(tongtien));
});

    </script>
</body>
<script src="../js/ho_tro.js"></script>
<?php require("../Home/ho_tro.php") ?>
<div class="mau_body"></div>
<script src="../js/banner.js"></script>
<?php require("../Home/footer.php") ?>
</body>
</html>
