<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHAHUVI.com - nhà sách trực tuyến</title>
    <link rel="icon" href="../IMG/logo.png">
    <link rel="stylesheet" href="../Css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<?php require("../Home/header.php") ?>
<div class="than-index">
    <div class="container">
        <?php
        require "../Home/connect.php";
        $sql = "SELECT ten FROM banner where vi_tri='anh-banner-chinh'";
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
            $sql1 = "SELECT ten FROM banner where vi_tri='anh-banner-voucher1'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
            echo "<a href='#'><img src='../IMG/{$row1['ten']}' alt='ảnh banner voucher'></a>";
            ?>
        </p>
        <p>
            <?php  //ảnh phía dưới
            $sql2 = "SELECT ten FROM banner where vi_tri='anh-banner-voucher2'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();
            echo "<a href='#'><img src='../IMG/{$row2['ten']}' alt='ảnh banner voucher'></a>";
            ?>
        </p>
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
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="bienmoithuthanhtien">
                        <h3>Biến Mọi Thứ Thành Tiền</h3>
                        <div class="price">
                            <span class="current-price">75.600 đ</span>
                            <span class="old-price">168.000 đ</span>
                        </div>
                        <div class="discount">-55%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/balochonggu.png" alt="Ba Lô Chống Gù">
                        <h3>Ba Lô Chống Gù Spider-Man</h3>
                        <div class="price">
                            <span class="current-price">872.000 đ</span>
                            <span class="old-price">1.090.000 đ</span>
                        </div>
                        <div class="discount">-20%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/sotayphatgiao.png" alt="Sổ Tay Biểu Tượng Phật Giáo">
                        <h3>Sổ Tay Biểu Tượng Phật Giáo</h3>
                        <div class="price">
                            <span class="current-price">227.500 đ</span>
                            <span class="old-price">350.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>

                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="Thai Giáo">
                        <h3>Thai Giáo - Phương Pháp Dạy Con Từ Trong Bụng Mẹ </h3>
                        <div class="price">
                            <span class="current-price">96.200 đ</span>
                            <span class="old-price">148.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="Thai Giáo">
                        <h3>Thai Giáo - Phương Pháp Dạy Con Từ Trong Bụng Mẹ </h3>
                        <div class="price">
                            <span class="current-price">96.200 đ</span>
                            <span class="old-price">148.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="Thai Giáo">
                        <h3>Thai Giáo - Phương Pháp Dạy Con Từ Trong Bụng Mẹ </h3>
                        <div class="price">
                            <span class="current-price">96.200 đ</span>
                            <span class="old-price">148.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="Thai Giáo">
                        <h3>Thai Giáo - Phương Pháp Dạy Con Từ Trong Bụng Mẹ </h3>
                        <div class="price">
                            <span class="current-price">96.200 đ</span>
                            <span class="old-price">148.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>
                <div class="product-card">
                    <a href="#">
                        <img src="../IMG/bienmoithuthanhtien.png" alt="Thai Giáo">
                        <h3>Thai Giáo - Phương Pháp Dạy Con Từ Trong Bụng Mẹ </h3>
                        <div class="price">
                            <span class="current-price">96.200 đ</span>
                            <span class="old-price">148.000 đ</span>
                        </div>
                        <div class="discount">-35%</div>
                    </a>
                </div>

            </div>

        </div>
    </div>
    <div class="menu-container">
        <div class="menu-header">
            <img src="https://img.icons8.com/ios-filled/50/000000/menu-2.png" alt="Menu icon">
            <span>DANH MỤC SẢN PHẨM</span>
        </div>
        <div class="product-list">
            <div class="product-item">
                <img src="../IMG/long_den.png" alt="Lồng Đèn">
                <p>Lồng Đèn</p>
            </div>
            <div class="product-item">
                <img src="../IMG/binh_nuoc.png" alt="Bình Nước">
                <p>Bình Nước</p>
            </div>
            <div class="product-item">
                <img src="../IMG/board_game_1.png" alt="Boardgame">
                <p>Boardgame</p>
            </div>
            <div class="product-item">
                <img src="../IMG/SGK24.png" alt="SGK 2024">
                <p>SGK 2024</p>
            </div>
            <div class="product-item">
                <img src="../IMG/dam_my.png" alt="Đam Mỹ">
                <p>Đam Mỹ</p>
            </div>
            <div class="product-item">
                <img src="../IMG/van_hoc.png" alt="Văn Học">
                <p>Văn Học</p>
            </div>
            <div class="product-item">
                <img src="../IMG/tam_ly_ky_nang.png" alt="Tâm Lý Kỹ Năng">
                <p>Tâm Lý Kỹ Năng</p>
            </div>
            <div class="product-item">
                <img src="../IMG/thieu_nhi.png" alt="Thiếu Nhi">
                <p>Thiếu Nhi</p>
            </div>
            <div class="product-item">
                <img src="../IMG/sach_hoc_ngoai_ngu.png" alt="Sách Học Ngoại Ngữ">
                <p>Sách Học Ngoại Ngữ</p>
            </div>
            <!-- <div class="product-item">
                <img src="../IMG/ngoai-van.png" alt="Ngoại Văn">
                <p>Ngoại Văn</p>
            </div> -->
        </div>
    </div>
    <div class="book-section">
        <h2 class="section-title">
        <span class="icon"><i class="fa-solid fa-book" style="color: #d34545;"></i></span>
            Tủ Sách Nổi Bật
        </h2>
        <div class="book-container">
            <div class="book-item">
                <img src="../IMG/so-tay-ngu-phap.png" alt="Take note! Ngắn gọn - Dễ học">
                <p>Take note! Ngắn gọn - Dễ học</p>
            </div>
            <div class="book-item">
                <img src="../IMG/song-ngu-thieu-nhi.png" alt="Song ngữ Thiếu nhi">
                <p>Song ngữ Thiếu nhi</p>
            </div>
            <div class="book-item">
                <img src="../IMG/ehon-nhat-ban.png" alt="Ehon Nhật Bản">
                <p>Ehon Nhật Bản</p>
            </div>
            <div class="book-item">
                <img src="../IMG/to-mau-cam-xuc.png" alt="Tô màu cảm xúc">
                <p>Tô màu cảm xúc</p>
            </div>
            <div class="book-item">
                <img src="../IMG/tu-duy-sieu-viet.png" alt="Tư duy siêu việt">
                <p>Tư duy siêu việt</p>
            </div>
            <div class="book-item">
                <img src="../IMG/nghe-thuat-MKT.png" alt="Nghệ thuật MKT">
                <p>Nghệ thuật MKT</p>
            </div>
            <div class="book-item">
                <img src="../IMG/dau-tu-tuong-lai.png" alt="Đầu tư tương lai">
                <p>Đầu tư tương lai</p>
            </div>
            <div class="book-item">
                <img src="../IMG/chua_lanh_noi_dau.png" alt="Chữa lành tâm hồn">
                <p>Chữa lành tâm hồn</p>
            </div>
        </div>
    </div>
    <div class="ranking-section">
        <h1>Bảng xếp hạng bán chạy tuần</h1>
        <div class="tabs">
            <ul>
                <li class="active">Văn học</li>
                <li>Kinh Tế</li>
                <li>Tâm lý - Kỹ năng sống</li>
                <li>Thiếu nhi</li>
                <li>Sách học ngoại ngữ</li>
                <li>Foreign books</li>
                <li>Thể loại khác</li>
            </ul>
        </div>

        <div class="content">
            <div class="left">
                <div class="book-item-1">
                    <span class="rank">01</span>
                    <img src="../IMG/goc-nho-cua-nang.png" alt="Góc Nhỏ Có Nắng">
                    <div class="book-info">
                        <h3>Góc Nhỏ Có Nắng</h3>
                        <p>Little Rainbow</p>
                        <p>4334 điểm</p>
                    </div>
                </div>
                <div class="book-item-1">
                    <span class="rank">02</span>
                    <img src="../IMG/to-binh-yen-hanh-phuc.png" alt="Tô Bình Yên Về Hạnh Phúc">
                    <div class="book-info">
                        <h3>Tô Bình Yên Về Hạnh Phúc (Tái Bản 2022)</h3>
                        <p>Kulzsc</p>
                        <p>1837 điểm</p>
                    </div>
                </div>
                
            </div>

            <div class="right">
                <img src="../IMG/goc-nho-cua-nang.png" alt="Góc Nhỏ Có Nắng">
                <div class="book-details">
                    <h2>Góc Nhỏ Có Nắng</h2>
                    <p>Tác giả: Little Rainbow</p>
                    <p>Nhà xuất bản: Thanh Niên</p>
                    <p class="price">55,760 đ <span class="original-price">68,000 đ</span> <span class="discount">-18%</span></p>
                    <div class="description">
                        <p>- Với 30 chủ đề tô màu phong phú đa dạng, mỗi bức tranh như là một lời thư thả tâm tình gửi đến bạn</p>
                        <p>- Thư giãn và chữa lành: Với những hình ảnh đẹp mắt và đơn giản, tô màu sẽ là một phương pháp hiệu quả giúp bạn chữa lành và nuôi dưỡng tâm hồn</p>
                        <p>- Khám phá sự sáng tạo: Bạn đừng ngại vẽ thêm, tô thêm màu sắc để thể hiện cảm xúc của riêng mình</p>
                        <p>- Chất liệu giấy dày, mịn, đẹp sẽ đem đến cho bạn trải nghiệm tô màu thú vị</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mau_body"></div>
<script src="../js/banner.js"></script>
<?php require("../Home/footer.php") ?>
</body>

</html>