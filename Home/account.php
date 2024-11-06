<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://example.com/path/to/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMbU5/1gI2Yo2e13G16/ai8t8mUnS4/03/JQ5" crossorigin="anonymous">
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <link rel="stylesheet" href="../Css/account.css">
    <link rel="stylesheet" href="../Css/header.css">
    <title>Trang Tài Khoản</title>
</head>
<body>
<?php require("../Home/header.php"); ?>
    
    <div class="container">
    
        <div class="sidebar">
        <h1>Tài khoản</h1>
            <ul>
                <li onclick="showSection('account')">Thông tin tài khoản</li>
                <li onclick="showSection('address')">Địa chỉ</li>
                <li onclick="showSection('orders')">Đơn hàng của tôi</li>
                <li onclick="showSection('voucher')">Ví Voucher</li>
                <li onclick="showSection('reviews')">Nhận xét của tôi</li>
            </ul>
        </div>
        <div class="content">
            <div id="account" class="section">
                <h2>Hồ sơ cá nhân</h2>
                <form id="account-form">
                    <div class="form-group">
                    <label for="fullname">Họ và tên:</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Chưa có email" required>
                    </div>
                    <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="button-container">
                    <button type="submit">Lưu thông tin</button>
                    </div>
                </form>
            </div>




            <div id="address" class="address-section" style="display:none;">
    <h2>Thêm địa chỉ mới</h2>
    <form id="addressForm">
        <div class="form-group">
            <label for="addressName">Họ và tên:</label>
            <input type="text" id="addressName" name="addressName" placeholder="Nhập họ và tên" required>
        </div>
        <div class="form-group">
            <label for="addressPhone">Điện thoại:</label>
            <input type="tel" id="addressPhone" name="addressPhone" placeholder="Nhập số điện thoại" required>
        </div>


        <form id="addressForm">
    <div class="form-group">
        <label for="addressCity">Tỉnh/thành phố:</label>
        <select id="addressCity" name="addressCity" required>
            <option value="">Chọn tỉnh/thành phố</option>
            <option value="HN">Hà Nội</option>
            <option value="HCM">Hồ Chí Minh</option>
            <option value="DN">Đà Nẵng</option>
            <option value="HP">Hải Phòng</option>
            <option value="CT">Cần Thơ</option>
            <option value="KH">Khánh Hòa</option>
            <option value="QN">Quảng Ninh</option>
            <option value="BT">Bến Tre</option>
            <option value="AG">An Giang</option>
            <option value="BD">Bình Dương</option>
            <option value="LA">Long An</option>
            <option value="VT">Vũng Tàu</option>
            <option value="NA">Nghệ An</option>
            <option value="TH">Thanh Hóa</option>
            <option value="QB">Quảng Bình</option>
            <option value="BDN">Bình Định</option>
            <option value="PY">Phú Yên</option>
        </select>
    </div>
    <div class="form-group">
        <label for="addressDistrict">Quận/Huyện:</label>
        <select id="addressDistrict" name="addressDistrict" required disabled>
            <option value="">Chọn quận/huyện</option>
        </select>
    </div>
</form>


        <div class="form-group">
            <label for="addressWard">Xã/Phường:</label>
            <input type="text" id="addressWard" name="addressWard" placeholder="Nhập xã/phường" required>
        </div>
        <div class="form-group">
            <label for="addressDetail">Địa chỉ:</label>
            <input type="text" id="addressDetail" name="addressDetail" placeholder="Nhập địa chỉ" required>
        </div>
        <div class="button-container">
            <button type="submit">Lưu địa chỉ</button>
        </div>
    </form>
</div>

            <div id="orders" class="section" style="display:none;">
                <h2>Đơn hàng</h2>
                <div class="order-item">
        <p><strong>Mã đơn hàng:</strong> ORD123456</p>
        <p><strong>Tên sách:</strong> Hướng Dẫn Học Tập</p>
        <p><strong>Số lượng:</strong> 1</p>
        <p><strong>Giá:</strong> 200.000 VNĐ</p>
        <p><strong>Trạng thái:</strong> Đang xử lý</p>
    </div>
            </div>

            <div id="voucher" class="section" style="display:none;">
    <h2>Ví Voucher</h2>
    
    <!-- Voucher Item 1 -->
    <div class="voucher-item">
        <img src="https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/ico_coupongreen.svg?q=10637" alt="Voucher Image" class="voucher-img">
        <div class="voucher-info">
            <p class="voucher-title">Mã giảm giá</p>
            <p class="voucher-code"><strong>AHAHUVI20K</strong> 
            <i class="fa fa-copy copy-icon" onclick="copyVoucherCode('ABC123'); event.stopPropagation();"></i>
            <p class="voucher-expiry"><strong>HSD:</strong> 30/12/2024</p>
        </div>
        <button onclick="copyVoucherCode('ABC123')" class="copy-btn">Copy mã</button>
    </div>
    
    <!-- Voucher Item 2 -->
    <div class="voucher-item">
        <img src="https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/ico_coupongreen.svg?q=10637" alt="Voucher Image" class="voucher-img">
        <div class="voucher-info">
            <p class="voucher-title">Mã giảm giá</p>
            <p class="voucher-code"><strong>AHAHUVI50K</strong>
            <i class="fa fa-copy copy-icon" onclick="copyVoucherCode('ABC123'); event.stopPropagation();"></i>
            <p class="voucher-expiry"><strong>HSD:</strong> 15/01/2025</p>
        </div>
        <button onclick="copyVoucherCode('HAHUVI')" class="copy-btn">Copy mã</button>
    </div>
</div>

            <div id="reviews" class="section" style="display:none;">
                <h2>Nhận xét của tôi</h2>
                <p>Bạn chưa có nhận xét nào.</p>
            </div>
        </div>
    </div>
    
    <?php require("../Home/footer.php") ?>  

<script src="../Js/account.js"></script>

</body>
</html>
