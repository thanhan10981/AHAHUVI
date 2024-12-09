<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHAHUVI.com - nhà sách trực tuyến</title>
    <link rel="icon" href="http://localhost/AHAHUVI/IMG/logo_icon.png">
    <link rel="stylesheet" href="../Css/index.css">
    <link rel="stylesheet" href="../Css/ho_tro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<?php require("../Home/header.php") ?>
<div class="than-index">
    <div class="banner-view">
        <div class="container">
            <?php
            require "../Home/connect.php";
            $sql = "SELECT ten FROM quang_cao where vi_tri='anh-quang_cao-chinh'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<div class='image-container' onmouseenter='showControls()' onmouseleave='hideControls()'>";
                $firstImage = true;
                $imageCount = 0;
                while ($row = $result->fetch_assoc()) {
                    $activeClass = $firstImage ? "active" : "";
                    echo "<img src='../IMG/{$row['ten']}' alt='ảnh banner' class='{$activeClass}'>";
                    $firstImage = false;
                    $imageCount++;
                }
                echo "</div>";
            } else {
                echo "Không có dữ liệu";
            }
            ?>
            <div class="dots">
                <?php
                for ($i = 0; $i < $imageCount; $i++) {
                    echo "<span class='dot' onclick='chuyenAnh($i)'></span>";
                }
                ?>
            </div>
            <button class="prev" onclick="chuyenAnhTruoc()">
                <span><</span>
            </button>
            <button class="next" onclick="chuyenAnhSau()">
                <span>></span>
            </button>
        </div>

        <div class="banner-voucher">
            <p>
                <?php  //ảnh phía trên
                $sql1 = "SELECT ten FROM quang_cao where vi_tri='anh-quang_cao-giam_gia1'";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_assoc();
                echo "<a href='#'><img src='../IMG/{$row1['ten']}' alt='ảnh banner voucher'></a>";
                ?>
            </p>
            <p>
                <?php  //ảnh phía dưới
                $sql2 = "SELECT ten FROM quang_cao where vi_tri='anh-quang_cao-giam_gia2'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();
                echo "<a href='#'><img src='../IMG/{$row2['ten']}' alt='ảnh banner voucher'></a>";
                ?>
            </p>

        </div>

        </table>
    </div>
    <div class="icon-list">
        <div class="icon-item">
            <a href=""><img src="../IMG/ZenBooks.png" alt="ZenBooks"></a>
            <p>ZenBooks</p>
        </div>
        <div class="icon-item">
            <a href=""><img src="../IMG/icon_Mannga.png" alt="icon_Mannga"></a>
            <p>Mannga</p>
        </div>
        <div class="icon-item">
            <a href=""><img src="../IMG/Icon_GiamGia.png" alt="GiamGia"></a>
            <p>Sản phẩm được trợ giá</p>
        </div>
        <div class="icon-item">
            <a href=""> <img src="../IMG/Icon_MaGiamGia.png" alt="Icon_MaGiamGia"></a>
            <p>Mã giảm giá</p>
        </div>
        <div class="icon-item">
            <a href=""> <img src="../IMG/Icon_VanPhongPham.png" alt="Icon_VanPhongPham"></a>
            <p>Back To School</p>
        </div>
        <div class="icon-item">
            <a href=""><img src="../IMG/Icon_SanPhamMoi.png" alt="Icon_SanPhamMoi"></a>
            <p>Sản Phẩm Mới</p>
        </div>
    </div>
    <div class="danh-muc">
        <div class="icon_danh_muc">Sản Phẩm Giảm Giá</div>
        <div class="product-carousel">
            <div class="product-container">
                <?php
                require "../Home/connect.php";
                $sql_sp_gg = "SELECT id_sp, ten_sp, anh_bia, phan_tram, gia, gia_giam FROM san_pham WHERE phan_tram > 0";
                $result_sp_gg = $conn->query($sql_sp_gg);
                if ($result_sp_gg->num_rows > 0) {
                    while ($row = $result_sp_gg->fetch_assoc()) {
                        echo '
                    <div class="product-card">
                        <a href="../Home/productDetail.php?id_sp=' . $row["id_sp"] . '">
                            <img src="../IMG/' . $row["anh_bia"] . '" alt="ảnh">
                            <h3>' . $row["ten_sp"] . '</h3>
                            <div class="price">
                                <span class="current-price">' . number_format($row["gia_giam"], 0, ',', '.') . ' đ</span>
                                <span class="old-price">' . number_format($row["gia"], 0, ',', '.') . ' đ</span>
                            </div>
                            <div class="discount">-' . $row["phan_tram"] . '%</div>
                        </a>
                    </div>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <div class="menu-container">
        <div class="menu-header">
            <img src="https://img.icons8.com/ios-filled/50/000000/menu-2.png" alt="Menu icon">
            <span class="danh">Danh mục sản phẩm</span>
        </div>
        <div class="product-list">
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=1">
                    <img src="../IMG/SGK24.png" alt="SGK 2024">
                    <p>SGK 2024</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=3">
                    <img src="../IMG/kinhte-1.png" alt="Bài Học Kinh Doanh">
                    <p>Bài Học Kinh Doanh</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=1">
                    <img src="../IMG/van_hoc.png" alt="Văn Học">
                    <p>Văn Học</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=5">
                    <img src="../IMG/goc-nho-cua-nang.png" alt="Sách tô màu">
                    <p>Sách Tô Màu</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=4">
                    <img src="../IMG/tam_ly_ky_nang.png" alt="Tâm Lý Kỹ Năng">
                    <p>Tâm Lý Kỹ Năng</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=5">
                    <img src="../IMG/thieu_nhi.png" alt="Thiếu Nhi">
                    <p>Thiếu Nhi</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=7">
                    <img src="../IMG/sach_hoc_ngoai_ngu.png" alt="Sách Học Ngoại Ngữ">
                    <p>Sách Học Ngoại Ngữ</p>
                </a>
            </div>
            <div class="product-item">
                <a href="../Home/allproduct.php?danhmuc_id=8">
                    <img src="../IMG/ngoai-van.png" alt="Ngoại Văn">
                    <p>Ngoại Văn</p>
                </a>
            </div>
        </div>
    </div>
    <div class="book-section">
        <h2 class="section-title">
            <span class="icon"><i class="fa-solid fa-book" style="color: #d34545;"></i></span>
            Tủ sách nổi bật
        </h2>
        <div class="book-container">
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=7">
                    <img src="../IMG/so-tay-ngu-phap.png" alt="Take note! Ngắn gọn - Dễ học">
                    <p>Take note! Ngắn gọn - Dễ học</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=2">
                    <img src="../IMG/song-ngu-thieu-nhi.png" alt="Song ngữ Thiếu nhi">
                    <p>Song ngữ Thiếu nhi</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=5">
                    <img src="../IMG/ehon-nhat-ban.png" alt="Ehon Nhật Bản">
                    <p>Ehon Nhật Bản</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=2">
                    <img src="../IMG/to-mau-cam-xuc.png" alt="Tô màu cảm xúc">
                    <p>Tô màu cảm xúc</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=3">
                    <img src="../IMG/tu-duy-sieu-viet.png" alt="Tư duy siêu việt">
                    <p>Tư duy siêu việt</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=3">
                    <img src="../IMG/nghe-thuat-MKT.png" alt="Nghệ thuật MKT">
                    <p>Nghệ thuật MKT</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=3">
                    <img src="../IMG/dau-tu-tuong-lai.png" alt="Đầu tư tương lai">
                    <p>Đầu tư tương lai</p>
                </a>
            </div>
            <div class="book-item">
                <a href="../Home/allproduct.php?danhmuc_id=4">
                    <img src="../IMG/chua_lanh_noi_dau.png" alt="Chữa lành tâm hồn">
                    <p>Chữa lành tâm hồn</p>
                </a>
            </div>
        </div>
    </div>
    <div class="ranking-section">
        <h1>Bảng xếp hạng bán chạy </h1>
        <!-- <div class="tabs">
            <ul>
                <li class="active"> Xếp </li>
                <li class="active"> Hạng </li>
                <li class="active"> Sản </li>
                <li class="active"> Phẩm </li>
                <li class="active"> Được </li>
                <li class="active"> Yêu </li>
                <li class="active"> Thích </li>
                <li class="active"> Nhất </li>
            </ul>
        </div> -->
        <div class="content">
            <div class="left">
                <?php
                require('../Home/connect.php');

                $sql_sp = " SELECT sp.id_sp, sp.ten_sp, sp.gia, sp.anh_bia, SUM(spdm.sl) AS total_sold
                FROM san_pham_dat_mua AS spdm
                JOIN san_pham AS sp ON spdm.id_sp = sp.id_sp
                GROUP BY sp.id_sp
                ORDER BY total_sold DESC
                LIMIT 5 ";
              
                $result = mysqli_query($conn, $sql_sp);
                $ii = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                <div class="book-item-1" onclick="loadProductDetails(' . $row['id_sp'] . ')">
                    <span class="rank">' . $ii . '</span>
                    <img src="../IMG/' . $row['anh_bia'] . '" alt="' . $row['ten_sp'] . '">
                    <div class="book-info">
                        <h3>' . $row['ten_sp'] . '</h3>
                        <p>' . number_format($row['gia'], 0, ',', '.') . ' VND</p>
                        <p>' . $row['total_sold'] * 10 . ' điểm</p>
                    </div>
                </div>';
                    $ii++;
                }
                ?>
            </div>
            <?php
                    $sql_sp2 = "
                    SELECT 
                        sp.id_sp, 
                        sp.ten_sp, 
                        sp.gia, 
                        sp.anh_bia, 
                        sp.tac_gia, 
                        sp.nha_xb, 
                        COALESCE(sp.gia_giam, sp.gia) AS gia_giam, 
                        COALESCE(sp.phan_tram, 0) AS phan_tram, 
                        sp.mo_ta, 
                        COALESCE(SUM(spdm.sl), 0) AS total_sold
                    FROM 
                        san_pham_dat_mua AS spdm
                    RIGHT JOIN 
                        san_pham AS sp ON spdm.id_sp = sp.id_sp
                    GROUP BY 
                        sp.id_sp
                    ORDER BY 
                        total_sold DESC
                    LIMIT 1";
                
              
                    $result1 = mysqli_query($conn, $sql_sp2);
                    $row = mysqli_fetch_assoc($result1);

                    echo '<div class="right" id="right-section"> <a href="../Home/productDetail.php?id_sp='.$row['id_sp'].'">
                    <img id="product-image" src="../IMG/' . $row['anh_bia'] . '" alt="Product Image"></a>
                    <div class="book-details">
                        <h2 id="product-name">' . $row['ten_sp'] . '</h2>
                        <p id="product-author">Tác giả: ' . $row['tac_gia'] . '</p>
                        <p id="product-publisher">Nhà xuất bản: ' . $row['nha_xb'] . '</p>
                        <p class="price">
                            <span id="product-price"class="price">' . number_format($row['gia_giam'], 0, ',', '.') . 'đ</span>';

                    if (!empty($row['gia_giam'])) {
                        echo '<span id="original-price"class="original-price">' . number_format($row['gia'], 0, ',', '.') . 'đ</span>';
                    }
                    if (!empty($row['phan_tram'])) {
                        echo '<span id="discount">-' . $row['phan_tram'] . '%</span>';
                    }

                    echo '</p>
                <div class="description" id="product-description">' . $row['mo_ta'] . '</div>
            </div>
        </div>';
                    ?>

        </div>
        <script src="../Js/xep_hang_right.js"></script>
    </div>
    <div class="main-container">
        <div class="section-header">
            <h3>Manga nổi bật</h3>
                </div>
        <div class="items-grid">
            <div class="item-card">
                <div class="stock-label">Sắp Có Hàng</div>
                <img src="../IMG/duoc-su.png" alt="Dược Sư">
                <p>Combo Sách Dược Sư Tự Sự - Tập 12 (Manga) + Tập 5 (Light Novel)</p>
                <div class="pricing-info">
                    <span class="current-price">157.150 đ</span>
                    <span class="old-price">172.000 đ</span>
                    <span class="discount-label">-8%</span>
                </div>
                <p>Đã bán 127</p>
            </div>
            <div class="item-card">
                <div class="stock-label">Sắp Có Hàng</div>
                <img src="../IMG/duoc-su.png" alt="Dược Sư">
                <p>[Manga] Dược Sư Tự Sự - Tập 12 - Tặng Kèm Standee Ivory + Bìa 2 in 1</p>
                <div class="pricing-info">
                    <span class="current-price">44.650 đ</span>
                    <span class="old-price">47.000 đ</span>
                    <span class="discount-label">-5%</span>
                </div>
                <p>Đã bán 180</p>
            </div>
            <div class="item-card">
                <div class="stock-label">Sắp Có Hàng</div>
                <img src="../IMG/duoc-su.png" alt="One Piece">
                <p>Combo Manga - One Piece - Tập 103 - Bản Bìa Áo + Limited Edition</p>
                <div class="pricing-info">
                    <span class="current-price">153.750 đ</span>
                    <span class="old-price">155.000 đ</span>
                    <span class="discount-label">-1%</span>
                </div>
                <p>Đã bán 159</p>
            </div>
            <div class="item-card">
                <div class="stock-label">Sắp Có Hàng</div>
                <img src="../IMG/duoc-su.png" alt="One Piece">
                <p>Combo Manga - One Piece - Tập 103 - Chiến Binh Giải Phóng - Bìa Áo</p>
                <div class="pricing-info">
                    <span class="current-price">150.900 đ</span>
                    <span class="old-price">152.000 đ</span>
                    <span class="discount-label">-1%</span>
                </div>
                <p>Đã bán 89</p>
            </div>
            <div class="item-card">
                <div class="stock-label">Sắp Có Hàng</div>
                <img src="../IMG/duoc-su.png" alt="One Piece">
                <p>One Piece - Tập 103 - Chiến Binh Giải Phóng - Limited Edition</p>
                <div class="pricing-info">
                    <span class="current-price">130.000 đ</span>
                </div>
                <p>Đã bán 240</p>
            </div>
        </div>
    </div>
</div>
<script src="../js/ho_tro.js"></script>
<?php require("../Home/ho_tro.php") ?>
<div class="mau_body"></div>
<script src="../js/banner.js"></script>
<?php require("../Home/footer.php") ?>
</body>

</html>