<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/logo.png">
    <link rel="stylesheet" href="../Css/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Trang Tài Khoản</title>
</head>

<body>
    <?php require("../Home/header.php") ?>
    <div class="container">
        <div class="sidebar">
            <h1>Tài khoản</h1>
            <ul>
                <li><a href="../Home/account.php?tabs=hscn"><i class="fa-solid fa-user"></i> Hồ sơ cá nhân</a></li>
                <li><a href="../Home/account.php?tabs=tdcm"><i class="fa-solid fa-location-dot"></i> Địa chỉ</a></li>
                <li><a href="../Home/account.php?tabs=order"><i class="fa-regular fa-file-lines"></i> Đơn hàng của tôi</a></li>
                <li><a href="../Home/account.php?tabs=voucher"><i class="fa-solid fa-ticket"></i> Ví Voucher </a></li>
                <li><a href="../Home/account.php?tabs=notify"><i class="fa-regular fa-bell"></i> Thông báo</a></li>
                <li><a href="../Home/account.php?tabs=review"> <i class="fa-regular fa-star"></i> Nhận xét của tôi</a></li>
            </ul>
        </div>
        <div class="content">
            <?php
            require "../Home/connect.php";

            if (isset($_SESSION["id_kh"])) {

                $id = $_SESSION["id_kh"];
                $sql_ac = "SELECT * from khach_hang WHERE mkh='$id'";
                $result_id = $conn->query($sql_ac);
                if ($result_id->num_rows > 0) {
                    $row_new = $result_id->fetch_assoc();
                    $parts = explode(',', $row_new['dia_chi']);
                    $so_nha = trim($parts[0] ?? '');
                    $phuong = trim($parts[1] ?? '');
                    $huyen = trim($parts[2] ?? '');
                    $tinh = trim($parts[3] ?? '');
                }
            }
            ?>
            <?php
            $tabs = $_GET['tabs'] ?? $_POST['tabs'] ?? null;
            if ($tabs == 'hscn') { ?>

                <div id="account" class="section">
                    <h2>Hồ sơ cá nhân</h2>
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "<div id='success-message' style='color: green; font-weight: bold;'>" . $_SESSION['success_message'] . "</div>";
                        unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
                    }
                    if (isset($_SESSION['error_message'])) {
                        echo "<div id='error-message' style='color: red; font-weight: bold;'>" . $_SESSION['error_message'] . "</div>";
                        unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
                    }
                    ?>
                    <form id="account-form" method="POST" action="update.php">
                        <div class="form-group">
                            <input type="hidden" name="id_kh" value="<?php echo $id; ?>">
                            <label for="fullname">Họ và tên:</label>
                            <input type="text" id="fullname" name="fullname" value="<?php echo isset($ten_kh) ? $ten_kh : $row_new['ten_kh']; ?>" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : $row_new['email']; ?>" placeholder="Chưa có email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo isset($sdt) ? $sdt : $row_new['sdt']; ?>" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="form-group">
                            <label for="gt">Giới tính:</label>
                            <input type="text" id="gt" name="gt" value="<?php echo isset($gioi_tinh) ? $gioi_tinh : $row_new['gioi_tinh']; ?>" placeholder="Nhập giới tính" required>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Ngày Sinh:</label>
                            <input type="date" id="birthday" name="birthday" class="input-left" value="<?php echo isset($ngay_sinh) ? $ngay_sinh : $row_new['ngay_sinh']; ?>" placeholder="Ngày sinh" required>
                        </div>
                        <input type="submit" style="margin-left: 40%;" name="btn-up" value="Lưu thông tin"></input>
                    </form>
                    <!-- Thông báo cập nhật thành công -->
                    <div id="success-message" style="display: none; color: green; font-weight: bold;">Thông tin đã được cập nhật thành công!</div>
                </div>
            <?php } else if ($tabs == 'tdcm') { ?>

                <div id="address" class="address-section">
                    <h2>Thêm địa chỉ mới</h2>
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "<div id='success-message' style='color: green; font-weight: bold;'>" . $_SESSION['success_message'] . "</div>";
                        unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
                    }
                    if (isset($_SESSION['error_message'])) {
                        echo "<div id='error-message' style='color: red; font-weight: bold;'>" . $_SESSION['error_message'] . "</div>";
                        unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
                    }
                    ?>
                    <form id="account-form" method="POST" action="../Home/updateaddress.php">
                        <div class="form-group">
                            <label for="addressName">Họ và tên:</label>
                            <input type="text" id="fullname" name="fullname" value="<?php echo isset($ten_kh) ? $ten_kh : $row_new['ten_kh']; ?>" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class="form-group">
                            <label for="addressPhone">Điện thoại:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $row_new['sdt']; ?>" placeholder="Nhập số điện thoại" required>
                        </div>

                        <!-- Địa chỉ -->
                        <div class="form-group">
                            <label for="addressCity">Tỉnh/thành phố:</label>
                            <select id="city" name="addressCity" required>
                                <?php
                                // Chọn tỉnh/thành phố
                                if ($tinh == "") {
                                    echo '<option value="">Chọn tỉnh/thành phố</option>';
                                } else {
                                    echo '<option>' . $tinh . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="addressDistrict">Quận/Huyện:</label>
                            <select id="district" name="district" required>
                                <?php
                                // Chọn quận/huyện
                                if ($huyen == "") {
                                    echo '<option value="">Chọn quận/huyện</option>';
                                } else {
                                    echo '<option>' . $huyen . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="addressWard">Xã/Phường:</label>
                            <select id="ward" name="ward" required>
                                <?php
                                // Chọn xã/phường
                                if ($phuong == "") {
                                    echo '<option value="">Chọn xã/phường</option>';
                                } else {
                                    echo '<option>' . $phuong . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="addressDetail">Địa chỉ:</label>
                            <input type="text" id="addressDetail" name="addressDetail" value="<?php echo $so_nha; ?>" placeholder="Nhập địa chỉ" required>
                        </div>

                        <!-- Ẩn các trường để lưu trữ thông tin chi tiết -->
                        <input type="hidden" id="hiddenCity" name="hiddenCity" value="<?php echo $tinh; ?>">
                        <input type="hidden" id="hiddenDistrict" name="hiddenDistrict" value="<?php echo $huyen; ?>">
                        <input type="hidden" id="hiddenWard" name="hiddenWard" value="<?php echo $phuong; ?>">

                        <div class="button-container">
                            <input type="submit" name="btn-update" value="Lưu địa chỉ">
                        </div>
                </div>

            <?php } else if ($tabs == 'notify') { ?>
                <div id="notify" class="section">
                    <div class="notify-item">
                        <p onclick="showContent('all')" class="active">Tất cả</p>
                        <p onclick="showContent('order')">Đơn hàng</p>
                        <p onclick="showContent('event')">Sự kiện</p>
                        <p onclick="showContent('discount')">Mã giảm giá</p>
                        <p onclick="showContent('confirm')">Xác nhận</p>
                    </div>
                </div>

                <?php
                require("../Home/connect.php");
                $id_kh = $_SESSION["id_kh"] ? $_SESSION["id_kh"] : null;
                if ($id_kh) {
                    $sql_all = "SELECT * FROM thong_bao WHERE id_kh = '$id_kh'";
                    $result_all = $conn->query($sql_all);
                    echo '<div id="all" class="content1 active">';
                    while ($row = $result_all->fetch_assoc()) {
                        echo '<p>' . $row['noi_dung'] . '</p>    <br><br>  ';
                    }
                    echo '</div>';

                    // Đơn hàng
                    echo '<div id="order" class="content1">';
                    $sql_dh = "SELECT * FROM don_hang WHERE id_kh = '$id_kh'";
                    $result_dh = $conn->query($sql_dh);
                    if ($result_dh->num_rows > 0) {
                        while ($row1 = $result_dh->fetch_assoc()) {
                            echo '<p>Đơn hàng tại địa chỉ ' . $row1['dia_chi'] . ' với tổng tiền ' . number_format($row1['tong_tien']) . 'đ</p><br><br>';
                        }
                    } else {
                        echo '<p>Chưa có thông báo cho Đơn hàng.</p>';
                    }
                    echo '</div>';

                    // Sự kiện
                    echo '<div id="event" class="content1">Chưa có thông báo cho Sự kiện.</div>';

                    // Mã giảm giá
                    echo '<div id="discount" class="content1">Chưa có thông báo cho Mã giảm giá mới.</div>';

                    // Xác nhận


                    echo '<div id="confirm" class="content1">';
                    $result_dh->data_seek(0);
                    while ($row1 = $result_dh->fetch_assoc()) {
                        $disabled = ($row1['trang_thai'] === 'thành công') ? 'disabled' : '';
                        echo '<div class="order-row">'; // Dùng div cha
                        echo '<p>Đơn hàng tại địa chỉ ' . $row1['dia_chi'] . ' với tổng tiền ' . number_format($row1['tong_tien']) . 'đ</p>';
                        echo '<form class="custom-form" action="../Home/xac_nhan_don_hang.php" method="post">
                <input type="hidden" name="id_dh" value="' . $row1['id_don_hang'] . '">
                <input type="hidden" name="id" value="' . $row1['id_kh'] . '">
                <input type="submit" value="xác nhận" ' . $disabled . '>
            </form>';
                        if ($row1['trang_thai'] === 'thành công') {
                            echo '<p class="status">Trạng thái: <strong>' . $row1['trang_thai'] . '</strong></p>';
                        }
                        echo '</div>'; // Đóng div cha
                    }
                    echo '</div>';
                } else {
                    echo '<p>Vui lòng đăng nhập!.</p>';
                }
                ?>

                <script>
                    function showContent(id) {
                        const contents = document.querySelectorAll('.content1');
                        contents.forEach(content => {
                            content.classList.remove('active');
                        });
                        document.getElementById(id).classList.add('active');
                        const tabs = document.querySelectorAll('.notify-item p');
                        tabs.forEach(tab => {
                            tab.classList.remove('active');
                        });
                        event.target.classList.add('active');
                    }
                </script>

            <?php } else if ($tabs == 'voucher') { ?>

                <div id="voucher" class="section">
                    <h2>Ví Voucher</h2>
                    <?php
                    $sql = "SELECT `id_giam_gia`, `ma`, `gia_giam`, `phan_tram`, `sl`, `ngay_tao`, `hsd`, `dieu_kien` FROM `giam_gia` WHERE 1";
                    $result = $conn->query($sql);

                    // Kiểm tra nếu có kết quả
                    if ($result->num_rows > 0) {
                        // Lặp qua các kết quả và hiển thị voucher
                        while ($row = $result->fetch_assoc()) {
                            // Định dạng số tiền gia_giam
                            $formatted_discount = number_format($row["gia_giam"], 0, ',', '.');
                            $formatted_condition = number_format($row["dieu_kien"], 0, ',', '.');
                            echo '<div class="voucher-item">
                    <img src="https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/ico_coupongreen.svg?q=10637" alt="Voucher Image" class="voucher-img">
                    <div class="voucher-info">
                    <p class="voucher-code"><strong>' . $row["ma"] . '</strong></p>
                    <p class="voucher-discount"><strong>Giảm giá:</strong> ' . $formatted_discount . ' VNĐ</p>
                    <p class="voucher-expiry"><strong>HSD:</strong> ' . date("d/m/Y", strtotime($row["hsd"])) . '</p>
                    <p class="voucher-condition"><strong>Điều kiện: </strong> mua trên ' . $formatted_condition . ' VNĐ</p> </p>
                    </div>
                    <button onclick="copyVoucherCode(\'' . $row["ma"] . '\')" class="copyma">Copy mã</button>
            </div>';
                        }
                    } else {
                        echo "Không có voucher nào";
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>
                </div>
            <?php } else if ($tabs == 'order') { ?>

                <div id="orders" class="section">
                    <h2>Đơn hàng</h2>
                    <?php
                    // Kiểm tra xem session có chứa ID khách hàng không
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    // Kiểm tra xem session có chứa ID khách hàng không
                    if (isset($_SESSION["id_kh"])) {
                        $id_kh = $_SESSION["id_kh"];
                    } else {
                        echo "Không có ID khách hàng trong session.";
                        exit(); // Dừng nếu không có ID khách hàng
                    }

                    // Truy vấn dữ liệu đơn hàng của khách hàng từ cơ sở dữ liệu
                    $sql_order = "SELECT * FROM don_hang WHERE id_kh = '$id_kh' ORDER BY ngay_tao DESC";
                    $result_orders = $conn->query($sql_order);
                    if (!$result_orders) {
                        echo "Lỗi truy vấn SQL: " . $conn->error;
                        exit(); 
                    }
                    if ($result_orders->num_rows > 0) {
                        while ($row_order = $result_orders->fetch_assoc()) {
                            echo "<div class='order-item'>";
                            echo "<p><strong>Mã đơn hàng:</strong> " . $row_order['id_don_hang'] . "</p>";
                            echo "<p><strong>Giá:</strong> " . number_format($row_order['tong_tien'], 0, ',', '.') . " VNĐ</p>";
                            echo "<p><strong>Trạng thái:</strong> " . $row_order['trang_thai'] . "</p>";
                            echo "<p><strong>Ngày tạo:</strong> " . $row_order['ngay_tao'] . "</p>";

                            // Nếu trạng thái đơn hàng là "Thành công", hiển thị nút đánh giá
                            if ($row_order['trang_thai'] === "thành công") {
                                $sql_idsp = "SELECT id_sp FROM san_pham_dat_mua WHERE id_don_hang = " . $row_order['id_don_hang'];
                                $r = $conn->query($sql_idsp);
                            
                                if ($r && $r->num_rows > 0) {
                                    $rrow = $r->fetch_assoc();
                                    $id_sp = $rrow['id_sp'];
                            
                                    // Kiểm tra nếu sản phẩm đã được đánh giá
                                    $sql_check_review = "SELECT id_binh_luan FROM binh_luan WHERE id_sp = $id_sp AND id_kh = $id_kh";
                                    $review_result = $conn->query($sql_check_review);
                            
                                    if ($review_result && $review_result->num_rows > 0) {
                                        // Nếu sản phẩm đã được đánh giá
                                        echo "<p>Đã đánh giá sản phẩm.</p>";
                                    } else {
                                        // Nếu sản phẩm chưa được đánh giá
                                        echo "<button class='review-button' onclick='redirectToReviewPage(" . $row_order['id_don_hang'] . ", " . $id_sp . ")'>Đánh giá sản phẩm</button>";
                                    }
                                } else {
                                    echo "<p>Không tìm thấy sản phẩm trong đơn hàng.</p>";
                                }
                            }
                            

                            echo "</div>";
                        }
                    } else {
                        echo "<p>Không có đơn hàng nào.</p>";
                    }

                    // Thêm JavaScript để xử lý chuyển hướng khi nhấn nút đánh giá
                    echo "<script>
                        function redirectToReviewPage(orderId, productId) {
                            window.location.href = 'account.php?id_don_hang=' + orderId + '&id_sp=' + productId;
                        }
                        </script>";

                    ?>
                </div>
            <?php } else if ($tabs == 'review') { ?>
                <div id="reviews" class="section">
                    <h2>Nhận xét của tôi</h2>
                    <table>
                        <tbody>
                            <?php
                            include 'nhan_xet.php'; // Lấy dữ liệu từ file nhan_xet.php
                            if (!empty($comments)):
                                foreach ($comments as $comment): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($comment['ngay_tao']) ?></td>
                                        <td><?= htmlspecialchars($comment['ten_sp']) ?></td>
                                        <td>
                                            <!-- Đánh giá (1-5 sao) -->
                                            <?php
                                            $rating = $comment['danh_gia'];
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $rating ? "★" : "☆"; // Hiển thị sao tương ứng với mức độ đánh giá
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($comment['noi_dung_binh_luan']) ?></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="3">Bạn chưa có nhận xét nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php } else if ($i) {

                // Kiểm tra xem có mã đơn hàng và ID sản phẩm trong URL không
                if (isset($_GET['id_don_hang']) && isset($_GET['id_sp'])) {
                    $id_don_hang = $_GET['id_don_hang'];
                    $id_sp = $_GET['id_sp'];
                } else {
                    echo "Thông tin không đầy đủ.";
                    exit();
                }
            ?>
                <h2>Đánh giá sản phẩm</h2>
                <form class="form-dg" action="xu_ly_danh_gia.php" method="POST">
                    <input type="hidden" name="id_don_hang" value="<?php echo $id_don_hang; ?>">
                    <input type="hidden" name="id_sp" value="<?php echo $id_sp; ?>">

                    <label for="rating">Đánh giá:</label>
                    <div class="star-rating">
                        <input type="radio" name="danh_gia" id="star5" value="5">
                        <label for="star5" title="5 sao">★</label>

                        <input type="radio" name="danh_gia" id="star4" value="4">
                        <label for="star4" title="4 sao">★</label>

                        <input type="radio" name="danh_gia" id="star3" value="3">
                        <label for="star3" title="3 sao">★</label>

                        <input type="radio" name="danh_gia" id="star2" value="2">
                        <label for="star2" title="2 sao">★</label>

                        <input type="radio" name="danh_gia" id="star1" value="1">
                        <label for="star1" title="1 sao">★</label>
                    </div>

                    <label for="comment">Nội dung bình luận:</label>
                    <textarea name="noi_dung_binh_luan" id="comment" rows="5" required></textarea>

                    <button class="btn" type="submit">Gửi đánh giá</button>
                </form>

            <?php  }
            ?>
        </div>
    </div>
    </div>
    <?php require("../Home/footer.php") ?>
    <script src="../Js/account.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");

        var Parameter = {
            url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
            method: "GET",
            responseType: "application/json",
        };

        var promise = axios(Parameter);
        promise.then(function(result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            // Lặp qua các tỉnh và thêm vào select
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Name); // Thêm tên tỉnh vào select
            }

            citis.onchange = function() {
                districts.length = 1; // Reset các quận/huyện
                wards.length = 1; // Reset các xã/phường
                if (this.value != "") {
                    const result = data.filter(n => n.Name === this.value); // Lọc tỉnh/thành phố đã chọn
                    for (const k of result[0].Districts) {
                        districts.options[districts.options.length] = new Option(k.Name, k.Name); // Thêm tên quận vào select
                    }
                }
            };

            districts.onchange = function() {
                wards.length = 1; // Reset xã/phường
                const selectedDistrict = this.value;
                const cityData = data.find(x => x.Name === citis.value);
                const districtData = cityData?.Districts.find(k => k.Name === selectedDistrict);
                if (districtData) {
                    for (const ward of districtData.Wards) {
                        wards.options[wards.options.length] = new Option(ward.Name, ward.Name);
                    }
                }
            };

        }

        document.getElementById("addressForm").onsubmit = function() {
            var cityName = citis.options[citis.selectedIndex].text;
            var districtName = districts.options[districts.selectedIndex].text;
            var wardName = wards.options[wards.selectedIndex].text;

            // Kiểm tra giá trị trước khi gán vào các input ẩn
            console.log("City:", cityName);
            console.log("District:", districtName);
            console.log("Ward:", wardName);

            // Gán tên vào các input ẩn trước khi gửi form
            document.getElementById("hiddenCity").value = cityName;
            document.getElementById("hiddenDistrict").value = districtName;
            document.getElementById("hiddenWard").value = wardName;
        };
    </script>
    <script>
        // Lấy tất cả các thẻ <p> có class "selectable"
        const items = document.querySelectorAll('.selectable');

        items.forEach(item => {
            item.addEventListener('click', function() {
                // Xóa class 'selected' khỏi tất cả các thẻ <p>
                items.forEach(p => p.classList.remove('selected'));

                // Thêm class 'selected' vào thẻ <p> được nhấp
                this.classList.add('selected');
            });
        });
    </script>
    <script>
        // Kiểm tra nếu thông báo thành công có tồn tại
        window.onload = function() {
            if (document.getElementById('success-message')) {
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000); // 3000ms = 3 giây
            }

            // Kiểm tra nếu thông báo lỗi có tồn tại
            if (document.getElementById('error-message')) {
                setTimeout(function() {
                    document.getElementById('error-message').style.display = 'none';
                }, 3000); // 3000ms = 3 giây
            }
        }
    </script>

</body>

</html>