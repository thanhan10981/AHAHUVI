<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Css/header.css">

</head>

<body>
    <div class="mau"></div>
    <div class="mau-menu"></div>
    <div class="header">
        <?php
    require "../Home/connect.php";
            $sql = "SELECT ten FROM quang_cao where vi_tri='header'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if ($result->num_rows > 0) {
                echo' <a href="../Home/Index.php"><img src="../IMG/'.$row['ten'].'" alt="Ảnh quảng cáo"></a>';
            }
            ?>
       
    </div>
    <div class="header-from">
        <div class="nav_bar">
            <a href="../Home/Index.php" class="logo"><img src="../IMG/logo.png" alt="Logo"></a>
            <a href="#" class="menu"><img src="../IMG/menu.png" alt="menu"></a>
            <?php session_start();
            $sql = "
            SELECT dm.id_danh_muc, dm.ten_danh_muc, tl.id_the_loai, tl.ten_the_loai
            FROM danh_muc dm
            JOIN the_loai tl ON dm.id_danh_muc = tl.id_danh_muc
            ORDER BY dm.id_danh_muc
        ";
            require("../Home/connect.php");
            $result = $conn->query($sql);
            $menu = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $menu[$row['id_danh_muc']]['ten_danh_muc'] = $row['ten_danh_muc'];
                    $menu[$row['id_danh_muc']]['the_loai'][] = [
                        'id_the_loai' => $row['id_the_loai'],
                        'ten_the_loai' => $row['ten_the_loai']
                    ];
                }
            } else {
                echo "Không có kết quả.";
            }
            ?>
            <div class="nav-menu">
                <ul>
                    <div class="mega-menu">
                        <?php foreach ($menu as $id_danh_muc => $danh_muc): ?>
                            <div class="menu-column">
                                <h4><a href="allproduct.php?danhmuc_id=<?php echo $id_danh_muc; ?>"><?php echo $danh_muc['ten_danh_muc']; ?></a></h4>
                                <?php
                                $i = 0; 
                                foreach ($danh_muc['the_loai'] as $the_loai):
                                    if ($i >= 5) break; 
                                ?>
                                    <a href="allproduct.php?theloai_id=<?php echo $the_loai['id_the_loai']; ?>">
                                        <?php echo $the_loai['ten_the_loai']; ?>
                                    </a>
                                <?php
                                    $i++; 
                                endforeach;
                              echo' <a href="../Home/allproduct.php">Xem thêm</a>';
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </ul>
            </div>
            <form action="../Home/allproduct.php" class="search_form">
                <input type="text" name="keyword" placeholder="Tìm kiếm...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="icon_group">
                <a href="javascript:void(0);" id="iconGroup" class="show">
                    <i class="fas fa-bell"></i>
                    <span>Thông Báo</span>
                </a>
                <div id="notificationForm" class="notification-form">
                    <h3>Thông báo 🔔</h3>
                    <?php
                    if (isset($_SESSION["id_kh"])) {
                        $id_kh = $_SESSION["id_kh"];
                        require("../Home/connect.php");
                        $_SESSION["id_kh"] = $id_kh;
                        $sql_tb = "SELECT * FROM thong_bao WHERE id_kh ='$id_kh'";
                        $result_tb = $conn->query($sql_tb);
                        $ii = 0;
                        if ($result_tb->num_rows > 0) {
                            while ($row = $result_tb->fetch_assoc()) {
                                $ii++;
                            }
                        } else {
                            echo '<p>Bạn chưa có thông báo nào mới nhất🔔 .</p>';
                        }
                        if ($ii > 0) {
                            echo '<p>Bạn có ' . $ii . ' thông báo 🔔 mới. Nhấp vào đây để xem chi tiết từng thông báo.</p>';
                        }
                        echo '  <a href="../Home/account.php?tabs=notify" class="read-all">Xem tất cả</a>';
                    } else {
                        echo '<p>Vui lòng đăng nhập để nhận thông báo 🔔.</p>';
                        echo '  <a href="" class="read-all">Xem tất cả</a>';
                    }

                    ?>

                </div>
                <a href="../Home/GioHang.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Giỏ Hàng</span>
                </a>

                <a href="javascript:void(0);" class="user">
                    <i class="fas fa-user"></i>
                    <span>Tài Khoản</sTan>
                </a>

                <div class="account-options">
                    <?php
                    if (isset($_SESSION["id_kh"])) {
                        // Nếu người dùng đã đăng nhập
                        echo '<a href="../Home/account.php?tabs=hscn">Thông tin tài khoản</a>';
                        echo '<a href="../Home/logout.php" onclick="return confirm(\'Bạn có chắc chắn muốn đăng xuất không?\');">Đăng xuất</a>';
                    } else {
                        // Nếu người dùng chưa đăng nhập
                        echo '<a href="../Home/login.php">Đăng nhập</a>';
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</body>
<script>
    const iconGroup = document.getElementById("iconGroup");
    const notificationForm = document.getElementById("notificationForm");
    iconGroup.addEventListener("mouseenter", () => {
        notificationForm.classList.add("active");
    });
    iconGroup.addEventListener("mouseleave", () => {
        notificationForm.classList.remove("active");
    });
    notificationIcon.addEventListener("mouseout", function() {
        setTimeout(function() {
            notificationForm.classList.remove("active");
        }, 300); // Thời gian trì hoãn trước khi ẩn, giúp người dùng có thời gian để nhấp
    });

    notificationForm.addEventListener("mouseout", function() {
        setTimeout(function() {
            notificationForm.classList.remove("active");
        }, 300); // Thời gian trì hoãn trước khi ẩn
    });
</script>

</html>