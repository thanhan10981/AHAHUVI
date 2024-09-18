<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="../Css/ThanhToan.css">
    <link rel="stylesheet" href="../Css/header.css">
</head>
<body>
    <header>
        <?php require("../Home/header.php") ?>
    </header>
    <div class="form-container">
        <h2>Họ và tên người nhận</h2>
        <input type="text" placeholder="Nhập họ và tên người nhận" required>

        <h2>Email</h2>
        <input type="email" placeholder="Nhập email" required>

        <h2>Số điện thoại</h2>
        <input type="tel" placeholder="Vd: 0979123xxx (10 ký tự số)" required>
        <span class="error-msg">Thông tin này không thể để trống</span>

        <h2>Địa chỉ nhận hàng</h2>
        <input type="text" placeholder="Nhập địa chỉ nhận hàng" required>

        <h2>Tổng tiền:</h2>

        <h3>Phương thức thanh toán</h3>
        <div class="payment-options">
            <input type="radio" name="payment" id="momo" value="momo">
            <label for="momo"> Ví MoMo</label>

            <input type="radio" name="payment" id="cash" value="cash">
            <label for="cash">Thanh toán khi nhận hàng</label>
        </div>

        <h3>Mã khuyến mãi/Mã quà tặng</h3>
        <input type="text" placeholder="Nhập mã khuyến mãi/Quà tặng">
        <button class="apply-btn">Áp dụng</button>

        <h3>Thông tin khác</h3>
        <p>Nhập mã khuyến mãi vào để giảm giá</p>

        <button class="submit-btn">Xác nhận thanh toán</button>
    </div>
</body>
</html>
