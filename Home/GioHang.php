<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="../Css/GioHang.css">
    <link rel="stylesheet" href="../Css/header.css">
</head>
<body>
    <header>
        <?php require("../AHAHUVI/header.php") ?>
    </header>
    <div class="cart-container">
        <h1>Giỏ Hàng (2 sản phẩm)</h1>
        <div class="cart-item">
            <input type="checkbox" checked name="chbox">
            <img src="../AHAHUVI/img/Chiasetutraitim.jpg" alt="Chia se tu trai tim" border="0">
            <div class="item-info">
                <p>Chia Sẻ Từ Trái Tim (Thích Pháp Hòa)</p>
                <p class="price">126.000 đ <span class="old-price">168.000 đ</span></p>
            </div>
            <div class="quantity">
                <button name="thembot"><h2>-</h2></button>
                <input type="text" value="1">
                <button name="thembot"><h2>+</h2></button>
            </div>
            <p class="total-price">126.000 đ</p>
            <button class="delete">🗑️</button>
        </div>

        <div class="cart-item">
            <input type="checkbox" checked name="chbox">
            <img src="../AHAHUVI/img/Hieuvetraitim.jpg" alt="Hieu ve trai tim" border="0">
            <div class="item-info">
                <p>Hiểu Về Trái Tim (Tái Bản 2023)</p>
                <p class="price">126.400 đ <span class="old-price">158.000 đ</span></p>
            </div>
            <div class="quantity">
                <button name="thembot"><h2>-</h2></button>
                <input type="text" value="1">
                <button name="thembot"><h2>+</h2></button>
            </div>
            <p class="total-price">126.400 đ</p>
            <button class="delete">🗑️</button>
        </div>

        <div class="promotion">
            <p>MÃ GIẢM 25K - ĐƠN HÀNG TỪ 280K</p>
            <button>Mua Thêm</button>
        </div>

        <div class="checkout">
            <p>Thành tiền: 252.400 đ</p>
            <p>Tổng Số Tiền (gồm VAT): 252.400 đ</p>
            <button class="pay">THANH TOÁN</button>
        </div>
    </div>
</body>
</html>
