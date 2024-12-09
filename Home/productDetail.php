<?php

require("../Home/connect.php");

$id_sp = isset($_GET['id_sp']) ? $_GET['id_sp'] : null;

if ($id_sp === null) {
    die("ID sản phẩm không được xác định.");
}
$id_danhmuc = isset($_GET['id_danh_muc']) ? $_GET['id_danh_muc'] : '';
$id_the_loai = isset($_GET['id_the_loai']) ? $_GET['id_the_loai'] : '';

$sql = "SELECT sp.ten_sp, sp.gia, sp.gia_giam, sp.phan_tram, sp.anh_bia, sp.anh_phu, 
               sp.mo_ta, sp.tac_gia, sp.nxb, sp.nha_xb, sp.id_ncc, 
               dm.id_danh_muc, dm.ten_danh_muc, 
               tl.id_the_loai, tl.ten_the_loai
         FROM san_pham sp 
         JOIN danh_muc dm ON sp.id_danh_muc = dm.id_danh_muc 
         JOIN the_loai tl ON sp.id_the_loai = tl.id_the_loai 
         WHERE sp.id_sp = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Lỗi truy vấn SQL: ' . $conn->error);
}

$stmt->bind_param("i", $id_sp);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra xem có sản phẩm không
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    if (!empty($product['anh_phu'])) {
        $product['anh_phu'] = explode(',', $product['anh_phu']);
    } else {
        $product['anh_phu'] = [];
    }
} else {
    $product = null; // Gán null cho $product nếu không tìm thấy
    echo "Không tìm thấy sản phẩm.";
}



$query_sao = "SELECT AVG(danh_gia) as trung_binh_sao FROM binh_luan WHERE id_sp = ?";
$stmt_sao = $conn->prepare($query_sao);
if ($stmt_sao === false) {
    die('Lỗi truy vấn SQL: ' . $conn->error);
}

$stmt_sao->bind_param("i", $id_sp);
$stmt_sao->execute();
$result_sao = $stmt_sao->get_result();
$avg_sao = 0;

if ($result_sao->num_rows > 0) {
    $row_sao = $result_sao->fetch_assoc();
    $avg_sao = round($row_sao['trung_binh_sao'], 1); // Làm tròn số sao trung bình đến 1 chữ số
}


// Truy vấn tổng số lượng đánh giá
$query_tongdg = "SELECT COUNT(*) as tongdg FROM binh_luan WHERE id_sp = ?";
$stmt_tongdg = $conn->prepare($query_tongdg);
$stmt_tongdg->bind_param("i", $id_sp);
$stmt_tongdg->execute();
$result_tongdg = $stmt_tongdg->get_result();
$row_tongdg = $result_tongdg->fetch_assoc();
$tongdg = $row_tongdg['tongdg'];

// Truy vấn số lượng từng mức sao
$query_ratings = "
    SELECT danh_gia, COUNT(*) as count
    FROM binh_luan
    WHERE id_sp = ?
    GROUP BY danh_gia
";
$stmt_ratings = $conn->prepare($query_ratings);
$stmt_ratings->bind_param("i", $id_sp);
$stmt_ratings->execute();
$result_ratings = $stmt_ratings->get_result();

$ratings_count = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

// Lưu số lượng đánh giá vào mảng
while ($row = $result_ratings->fetch_assoc()) {
    $ratings_count[$row['danh_gia']] = $row['count'];
}


$sql_voucher = "select * from giam_gia";
$stmt_voucher = $conn->prepare($sql_voucher);
$stmt_voucher->execute();
$result_voucher = $stmt_voucher->get_result();


$sql_binhluan = "SELECT * FROM binh_luan bl 
                 JOIN khach_hang kh ON bl.id_kh = kh.mkh
                 WHERE bl.id_sp = $id_sp";
$result_bl = $conn->query($sql_binhluan);
if (!$result_bl) {
    echo "Lỗi trong truy vấn SQL." . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHAHUVI.com - nhà sách trực tuyến</title>
    <link rel="icon" href="../IMG/logo.png">
    <link rel="stylesheet" href="../Css/productDetail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php require("../Home/header.php") ?>
    <?php
    if (isset($_SESSION["id_kh"])) {
        $id_kh = $_SESSION["id_kh"];
        $_SESSION["id_kh"] = $id_kh;
    }
    ?>
    <div class="than-chitietsp">
        <div class="mucsp">
            <ol class="danhmuc">
                <?php if ($product): ?>
                    <li class="danhmuctheloai">
                        <a href="allproduct.php?id_danh_muc=<?php echo $product['id_danh_muc']; ?>">
                            <?php echo htmlspecialchars($product['ten_danh_muc']); ?>
                        </a>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li class="danhmuctheloai">
                        <a href="allproduct.php?id_the_loai=<?php echo $product['id_the_loai']; ?>">
                            <?php echo htmlspecialchars($product['ten_the_loai']); ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="danhmuctheloai">
                        <span>Không có thông tin danh mục.</span>
                    </li>
                <?php endif; ?>
            </ol>
        </div>
        <div class="chitietsp">
            <div class="chitietsp-trai">
                <div class="chitietsp-trai1">
                    <img src="../IMG/<?php echo htmlspecialchars($product['anh_bia']); ?>" alt="" class="anhchinh" id="anhchinh">
                    <div class="anhphu">
                        <?php foreach ($product['anh_phu'] as $anh): ?>
                            <img src="../IMG/<?php echo htmlspecialchars(trim($anh)); ?>" alt="" class="anhphu1" onclick="doiAnh(this)">
                        <?php endforeach; ?>
                    </div>
                    <form action="ThanhToan1.php" method="POST" id="giohangform">
                        <input type="hidden" name="id_sp" value="<?php echo $id_sp; ?>">
                        <input type="hidden" name="ten_sp" value="<?php echo $product['ten_sp']; ?>">
                        <input type="hidden" name="gia" value="<?php echo $product['gia']; ?>">
                        <input type="hidden" name="soluong" id="soluong_input" value="1">
                        <input type="hidden" id="actionType" name="action_type" value="">

                        <div class="nutthemmua">
                            <button type="button" title="Thêm vào giỏ hàng" class="nutthem" onclick="submitForm('them')">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span>Thêm vào giỏ hàng</span>
                            </button>
                            <button type="button" title="Mua ngay" class="muangay" onclick="submitForm('muangay')">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Mua ngay</span>
                            </button>
                        </div>

                        <div id="cartSuccessNotification" style="display:none;">
                            <div class="icon"><i class="fa-solid fa-circle-check"></i></div>
                            Sản phẩm đã được thêm vào giỏ hàng.
                        </div>
                    </form>

                </div>
                <div class="chitietsp-trai2">
                    <div class="tieudechitietsp-trai2">
                        <h3>Đánh giá</h3>
                    </div>
                    <div class="danhgiasao">
                        <div class="tbsao">
                            <div class="saoduocdg">
                                <div class="sosao"><?php echo $avg_sao ?></div><span>/</span>
                                <div class="tongsosao">5</div>
                            </div>
                            <div class="sao">
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $avg_sao) {
                                        echo '<i class="fas fa-star" style="color: #FFD700;"></i>';
                                    } else {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            $sql_danhgia = "select count(*) as tong_dg from binh_luan where id_sp = ?";
                            $stmt = $conn->prepare($sql_danhgia);
                            if ($stmt === false) {
                                die("Lỗi trong câu truy vấn SQL: " . $conn->error);
                            }
                            $stmt->bind_param("i", $id_sp);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            ?>
                            <span class="danhgia"><?php echo "( " . $row['tong_dg'] . " đánh giá )"; ?></span>
                        </div>
                        <div class="bieudodanhgia">
                            <?php
                            for ($i = 5; $i >= 1; $i--) {
                                $phantram = $tongdg > 0 ? ($ratings_count[$i] / $tongdg) * 100 : 0;
                                echo '
                                <div class="mucsao">
                                    <span>' . $i . ' sao</span>
                                    <div class="thanhdanhgia">
                                        <div class="chitietthanh" style="width: ' . $phantram . '%;"></div>
                                    </div>
                                    <span>' . round($phantram, 1) . '%</span>
                                </div>
                            ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chitietsp-phai">
                <div class="chitietsp-phai1">
                    <div class="chitietsp-phai1-1">
                        <h1><?php echo htmlspecialchars($product['ten_sp']); ?></h1>
                        <div class="thongtin">
                            <div class="cot-trai">
                                <p>Nhà cung cấp: <a href="" class="info-1" id="nhaCungCap">AZ Việt Nam</a></p>
                                <p>Nhà xuất bản: <span class="info" id="nhaXuatBan"><?php echo htmlspecialchars($product['nha_xb']); ?></span></p>
                            </div>

                            <div class="cot-phai">
                                <p>Tác giả: <span class="info" id="tacGia"><?php echo htmlspecialchars($product['tac_gia']); ?></span></p>
                                <p>Năm xuất bản: <span class="info" id="namxb"><?php echo htmlspecialchars($product['nxb']); ?></span></p>
                            </div>
                        </div>
                        <div class="danhgia-section">
                            <div class="sao">
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $avg_sao) {
                                        echo '<i class="fas fa-star" style="color: #FFD700;"></i>';
                                    } else {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            $sql_danhgia = "select count(*) as tong_dg from binh_luan where id_sp = ?";
                            $stmt = $conn->prepare($sql_danhgia);
                            if ($stmt === false) {
                                die("Lỗi trong câu truy vấn SQL: " . $conn->error);
                            }
                            $stmt->bind_param("i", $id_sp);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            ?>
                            <span class="danhgia"><?php echo "( " . $row['tong_dg'] . " đánh giá )"; ?></span>
                            <span class="gachdung">|</span>
                            <?php
                            $sql = "SELECT sp.id_sp, sp.ten_sp, IFNULL(SUM(sdm.sl), 0) AS total_sold 
                            FROM san_pham sp
                            LEFT JOIN san_pham_dat_mua sdm ON sp.id_sp = sdm.id_sp
                            WHERE sp.id_sp = ?
                            GROUP BY sp.id_sp";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $id_sp);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($row = $result->fetch_assoc()) {
                                $id_sp = $row['id_sp'];
                                $ten_sp = $row['ten_sp'];
                                $total_sold = $row['total_sold'];
                                echo '<span class="daban">Đã bán <strong>' . $total_sold . '</strong></span>';
                            } else {
                                echo 'Sản phẩm không tồn tại hoặc chưa bán.';
                            }
                            ?>
                        </div>
                        <div class="giatien">
                            <span class="giahientai"><?php echo number_format($product['gia_giam'], 0, '', ','); ?><span class="tiente">đ</span></span>
                            <span class="giagoc"><?php echo number_format($product['gia'], 0, '', ','); ?>đ</span>
                            <span class="mucgiam"><?php echo $product['phan_tram'] . "%" ?></span>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION["id_kh"])) {
                        $id_kh = $_SESSION["id_kh"];
                        $sql_kh = "SELECT dia_chi FROM khach_hang WHERE mkh = ?";
                        $stmt_kh = $conn->prepare($sql_kh);
                        if ($stmt_kh) {
                            $stmt_kh->bind_param("i", $id_kh);
                            $stmt_kh->execute();
                            $result_kh = $stmt_kh->get_result();
                            $row_kh = $result_kh->fetch_assoc();
                            if ($row_kh) {
                                $dia_chi = $row_kh["dia_chi"];
                            } else {
                                $dia_chi = "Địa chỉ không xác định";
                            }

                            $stmt_kh->close();
                        }
                    } else {
                        $dia_chi = "Người dùng chưa đăng nhập";
                    }
                    if (strpos($dia_chi, 'Quy Nhơn') !== false) {
                        $so_ngay_giao = 2; // Nếu là Quy Nhơn thì giao hàng trong 2 ngày
                    } else {
                        $so_ngay_giao = 5; // Các địa chỉ khác giao hàng trong 5 ngày
                    }

                    // Tính toán ngày giao hàng dự kiến
                    $timestamp = strtotime("+$so_ngay_giao days");

                    // Mảng chuyển đổi ngày trong tuần sang tiếng Việt
                    $daysOfWeek = [
                        'Monday' => 'Thứ hai',
                        'Tuesday' => 'Thứ ba',
                        'Wednesday' => 'Thứ tư',
                        'Thursday' => 'Thứ năm',
                        'Friday' => 'Thứ sáu',
                        'Saturday' => 'Thứ bảy',
                        'Sunday' => 'Chủ nhật'
                    ];

                    // Lấy ngày trong tuần và thay thế bằng tiếng Việt
                    $dayOfWeek = $daysOfWeek[date('l', $timestamp)];
                    $dateFormatted = date('d/m', $timestamp);
                    $ngay_giao_du_kien = "$dayOfWeek - $dateFormatted";
                    ?>
                    <div class="chitietsp-phai1-2">
                        <div class="thongtinvanchuyen">
                            <h3>Thông tin vận chuyển</h3>
                            <p>Giao hàng đến <span class="diachi"><?php echo htmlspecialchars($dia_chi); ?></span> <button class="thaydoi" id="thaydoi">Thay đổi</button></p>
                            <span class="tieudegiaohang"><i class="fas fa-truck" onclick="openModal()"></i> Giao hàng tiêu chuẩn</span>
                            <p>Dự kiến giao <strong><?php echo $ngay_giao_du_kien; ?></strong></p>
                        </div>
                        <div id="overlay" onclick="closeModal()"></div>
                        <div id="shippingModal">
                            <span class="close-btn" onclick="closeModal()">&times;</span>
                            <h2>Thời gian giao hàng</h2>
                            <p><strong>Thông tin đóng gói, vận chuyển hàng</strong></p>
                            <p>Với đa phần đơn hàng, AHAHUVI cần vài giờ làm việc để kiểm tra thông tin và đóng gói hàng. Nếu các sản phẩm đều có sẵn hàng, AHAHUVI sẽ nhanh chóng bàn giao cho đối tác vận chuyển. Nếu đơn hàng có sản phẩm sắp phát hành, Fahasa.com sẽ ưu tiên giao những sản phẩm có hàng trước cho Quý khách hàng.

                                Trong một số trường hợp, hàng nằm không có sẵn tại kho gần nhất, thời gian giao hàng có thể chậm hơn so với dự kiến do điều hàng. Các phí vận chuyển phát sinh, Fahasa.com sẽ hỗ trợ hoàn toàn.

                                Thời gian giao hàng không tính thứ 7, Chủ nhật, các ngày Lễ, Tết và không bao gồm tuyến huyện đảo xa.</p>
                            <p><strong>Thời gian và chi phí giao hàng tại từng khu vực trong lãnh thổ Việt Nam:</strong></p>
                            <p><strong>1. Nội thành TP.Quy Nhơn, Tỉnh Bình Định</strong></p>
                            <p>Thời gian: 2 ngày</p>
                            <p>Chi phí: 20.000 đồng cho 2 kg đầu tiên. Phụ thu 2.000 đồng cho mỗi kg tiếp theo.</p>
                            <p><strong>1. Các tỉnh thành khác</strong></p>
                            <p>Thời gian: 5 ngày</p>
                            <p>Chi phí: 32.000 đồng cho 2 kg đầu tiên. Phụ thu 3.000 đồng cho mỗi kg tiếp theo.</p>
                        </div>
                        <div class="thongtinkhuyenmai">
                            <h3>Ưu đãi liên quan <button class="xemthemkhuyenmai" id="xemthemkhuyenmai">Xem thêm<i class="fa-solid fa-chevron-right"></i></button></h3>
                            <div class="makhuyenmai">
                                <?php
                                while ($row_voucher = $result_voucher->fetch_assoc()) {
                                    $ma_voucher = htmlspecialchars($row_voucher['ma']);
                                    echo '<span class="ma"><i class="fa-solid fa-percent"></i><a href="">' . $ma_voucher . '</a></span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="chonsoluong">
                            <label for="soluong">Số lượng:</label>
                            <div class="nutsoluong">
                                <button type="button" class="nut giam">-</button>
                                <input type="text" id="soluong" value="1">
                                <button type="button" class="nut tang">+</button>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['diachi']) && isset($_SESSION['id_kh'])) {
                        $diachi_moi = $_POST['diachi'];
                        $id_kh = $_SESSION['id_kh'];


                        $sql = "UPDATE khach_hang SET dia_chi = ? WHERE mkh = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("si", $diachi_moi, $id_kh);


                        if ($stmt->execute()) {
                            echo "Địa chỉ đã được cập nhật thành công!";
                        } else {
                            echo "Cập nhật địa chỉ thất bại!";
                        }

                        $stmt->close();
                        exit();
                    }
                    ?>
                    <div class="thaydoidiachi" id="thaydoidiachi">
                        <div class="popup-diachi">
                            <h3>Chọn địa chỉ giao hàng của bạn</h3>
                            <label><input type="radio" name="diachi" class="diachidachon" checked> Giao hàng đến <?php echo htmlspecialchars($dia_chi); ?></label><br>
                            <label><input type="radio" name="diachi" class="diachidachon"> Giao hàng đến địa chỉ khác</label>
                            <div class="suadiachi">
                                <div class="suathanhpho">
                                    <label for="thanhpho">Tỉnh/Thành Phố</label><br>
                                    <select id="thanhpho" disabled>
                                        <option>Chọn tỉnh/thành phố</option>
                                    </select><br><br>
                                </div>
                                <div class="suaquanhuyen">
                                    <label for="quanhuyen">Quận/Huyện</label><br>
                                    <select id="quanhuyen" disabled>
                                        <option>Chọn quận/huyện</option>
                                    </select><br><br>
                                </div>
                                <div class="suaphuong">
                                    <label for="phuongxa">Phường/Xã</label><br>
                                    <select id="phuongxa" disabled>
                                        <option>Chọn phường/xã</option>
                                    </select>
                                </div>
                            </div>
                            <button id="nuthuy">Hủy</button>
                            <button id="nutxacnhan">Xác nhận</button>
                        </div>
                    </div>
                    <div class="uudailienquan" id="uudailienquan">
                        <div class="popup-uudai">
                            <div class="tieudeuudai">
                                <h3><i class="fa-solid fa-ticket"></i>ƯU ĐÃI LIÊN QUAN</h3>
                            </div>
                            <h4>Mã giảm giá</h4>
                            <div class="makhuyenmai" id="makhuyenmai">
                                <div class="ma"><i class="fa-solid fa-percent"></i><a href="">MÃ GIẢM 10K - ĐƠN HÀNG TỪ 130K<div class="hsd">HSD: 30/9/2024</div></a></div>
                                <div class="ma"><i class="fa-solid fa-percent"></i><a href="">MÃ GIẢM 25K - ĐƠN HÀNG TỪ 280K<div class="hsd">HSD: 30/9/2024</div></a></div>
                            </div>
                            <button id="nutxemthem">Xem thêm</button>
                            <button id="nutrutgon">Rút gọn</button>
                        </div>
                    </div>
                    <div class="chitietsp-phai1-3">
                        <h3>Mô tả sản phẩm</h3>
                        <p><span class="mota" id="mota"><?php echo htmlspecialchars($product['mo_ta']); ?></span></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="danhsachsp">
            <?php
            $ten_sp_lq = '';
            if ($id_sp) {
                $sql_ten_lq = "SELECT ten_sp FROM san_pham WHERE id_sp = ?";
                $stmt_ten_lq = $conn->prepare($sql_ten_lq);
                $stmt_ten_lq->bind_param("i", $id_sp);
                $stmt_ten_lq->execute();
                $result_ten_lq = $stmt_ten_lq->get_result();

                if ($result_ten_lq->num_rows > 0) {
                    $row_ten_lq = $result_ten_lq->fetch_assoc();
                    $ten_sp_lq = $row_ten_lq['ten_sp'];
                } else {
                    echo "<p>Không tìm thấy sản phẩm.</p>";
                    exit;
                }
            } else {
                echo "<p>Không tìm thấy sản phẩm được chọn.</p>";
                exit;
            }

            function loaiboten($ten_sp_lq)
            {
                return preg_replace('/\s*Tập\s*\d+/', '', $ten_sp_lq);
            }

            $tencoban = loaiboten($ten_sp_lq);

            $sql_sp_lq = "SELECT * FROM san_pham WHERE ten_sp LIKE CONCAT('%', ?, '%') AND id_sp != ? ";
            $stmt_sp_lq = $conn->prepare($sql_sp_lq);
            $stmt_sp_lq->bind_param("si", $tencoban, $id_sp);
            $stmt_sp_lq->execute();
            $result_sp_lq = $stmt_sp_lq->get_result();

            ?>

            <h3>SẢN PHẨM LIÊN QUAN</h3>
            <div class="product-carousel">
                <button class="carousel-btn left-btn" onclick="previousProduct()">&#10094;</button>
                <div class="carousel-inner">
                    <?php
                    if ($result_sp_lq->num_rows > 0) {
                        while ($row = $result_sp_lq->fetch_assoc()) {
                            $id_sp_lq = $row['id_sp'];
                            $query_sao = "SELECT AVG(danh_gia) as trung_binh_sao FROM binh_luan WHERE id_sp = ?";
                            $stmt = $conn->prepare($query_sao);
                            $stmt->bind_param('i', $id_sp_lq);
                            $stmt->execute();
                            $result_sao = $stmt->get_result();
                            $row_sao = $result_sao->fetch_assoc();
                            $trung_binh_sao = $row_sao['trung_binh_sao'] ?? 0;
                            $so_sao = round($trung_binh_sao);

                            echo '<div class="sp_lienquan">';
                            echo '
                    <form action="productdetail.php" method="get">
                        <input type="hidden" name="id_sp" value="' . htmlspecialchars($row['id_sp']) . '">
                        <button type="submit" style="background: none; border: none; padding: 0;">
                            <img src="../IMG/' . htmlspecialchars($row['anh_bia']) . '" alt="' . htmlspecialchars($row['ten_sp']) . '">
                            <h4>' . htmlspecialchars($row['ten_sp']) . '</h4>
                        </button>
                    </form>
                    <span class="giamgia">' . htmlspecialchars($row['phan_tram']) . '% </span>
                    <div class="giatien">
                        <span class="giacu">' . number_format($row['gia'], 0, '', ',') . 'đ</span>
                        <span class="giamoi">' . number_format($row['gia_giam'], 0, '', ',') . 'đ</span>
                    </div>
                    <div class="sao">';
                            for ($i = 0; $i < 5; $i++) {
                                echo $i < $so_sao ? '<i class="fas fa-star" style="color: #FFD700;"></i>' : '<i class="fas fa-star"></i>';
                            }
                            echo '</div></div>';
                        }
                    } else {
                        echo "<p>Không tìm thấy sản phẩm liên quan.</p>";
                    }
                    ?>
                </div>
                <button class="carousel-btn right-btn" onclick="nextProduct()">&#10095;</button>
            </div>
            <script>
                let currentIndex = 0;
                const products = document.querySelectorAll('.carousel-inner .sp_lienquan');
                const productsToShow = 5; // Số sản phẩm hiển thị mỗi lần
                const totalProducts = products.length;

                // Cập nhật carousel để dịch chuyển chính xác theo số lượng sản phẩm và chiều rộng mỗi sản phẩm
                function updateCarousel() {
                    const carouselInner = document.querySelector('.carousel-inner');
                    const productWidth = products[0].offsetWidth; // Chiều rộng của một sản phẩm
                    const offset = -currentIndex * productWidth * productsToShow; // Tính khoảng cách cần dịch chuyển
                    carouselInner.style.transform = `translateX(${offset}px)`;
                }

                function nextProduct() {
                    // Kiểm tra nếu chưa đến slide cuối cùng thì tăng chỉ số
                    if (currentIndex < Math.ceil(totalProducts / productsToShow) - 1) {
                        currentIndex++;
                    } else {
                        currentIndex = 0; // Quay lại đầu khi đến cuối
                    }
                    updateCarousel();
                }

                function previousProduct() {
                    // Kiểm tra nếu chưa ở slide đầu tiên thì giảm chỉ số
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = Math.ceil(totalProducts / productsToShow) - 1; // Quay lại cuối khi ở đầu
                    }
                    updateCarousel();
                }

                // Cập nhật carousel ban đầu
                updateCarousel();
            </script>

        </div>

        <div class="Danhgia">
            <h3>ĐÁNH GIÁ SẢN PHẨM</h3>
            <div class="dg_sp">
                <button data-rating="all" class="active">Tất cả (<?php echo $tongdg ?>)</button>
                <button data-rating="5">5 sao (<?php echo $ratings_count[5]; ?>)</button>
                <button data-rating="4">4 sao (<?php echo $ratings_count[4]; ?>)</button>
                <button data-rating="3">3 sao (<?php echo $ratings_count[3]; ?>)</button>
                <button data-rating="2">2 sao (<?php echo $ratings_count[2]; ?>)</button>
                <button data-rating="1">1 sao (<?php echo $ratings_count[1]; ?>)</button>

                <?php
                if ($result_bl && $result_bl->num_rows > 0) {
                    while ($row = $result_bl->fetch_assoc()) {
                        $tenkh_parts = explode(" ", $row['ten_kh']);
                        $ten_kh = end($tenkh_parts);
                ?>
                        <div class="danhgia_traiphai" data-rating="<?php echo $row['danh_gia']; ?>">
                            <div class="danhgia_trai">
                                <div class="tenkh"><?php echo htmlspecialchars($ten_kh); ?></div>
                            </div>
                            <div class="danhgia_phai">
                                <h4><?php echo htmlspecialchars($row['ten_kh']); ?></h4>
                                <div class="sao" style="color: #ccc;">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $row['danh_gia']
                                            ? '<i class="fas fa-star" style="color: gold;"></i>'
                                            : '<i class="fas fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <p><?php echo htmlspecialchars($row['ngay_tao']); ?></p>
                                <p><?php echo htmlspecialchars($row['noi_dung_binh_luan']); ?></p>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>Chưa có bình luận nào cho sản phẩm này.</p>";
                }
                ?>
            </div>


        </div>
    </div>
    <?php require("../Home/footer.php") ?>
    <script src="../js/productDetail.js"></script>
</body>
<?php $id_kh = isset($_SESSION["id_kh"]) ? $_SESSION["id_kh"] : null; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const button = document.querySelector('.nutthem');
        const button1 = document.querySelector('.muangay');
        const id_kh = <?php echo json_encode($id_kh); ?>;

        if (!id_kh) {
            button.disabled = true;
            button1.disabled = true;
        }
    });
</script>

</html>