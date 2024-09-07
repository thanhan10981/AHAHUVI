<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desi.vn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/trangchinhdadangnhap.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="icon" type="image/png" href="../img/logo.png" />

</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>
                 <?php  require("../Home/header.php") ?>
                </th>
            </tr>
            <tr>
                <th>
                    <div class="container">
                        <?php  require "../Admin/connect.php"; 
                        $sql = "SELECT anh, tenanh FROM anh_banner";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<div class='image-container'onmouseenter='showControls()' onmouseleave='hideControls()'>";
                            $firstImage = true;
                            $imageCount = 0; 
                            while($row = $result->fetch_assoc()) {
                                $activeClass = $firstImage ? "active" : ""; 
                                echo "<img src='../img/" . $row["anh"] . "' alt='" . $row["tenanh"] . "' class='$activeClass'>";
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
                        <button class="prev" onclick="chuyenAnhTruoc()"><span><i class="fa-sharp fa-solid fa-less-than fa-1.5xl" style="color: #959ca7;"></i></span></button>
                        <button class="next" onclick="chuyenAnhSau()"><span><i class="fa-sharp fa-solid fa-greater-than fa-1.5xl" style="color: #959ca7;"></i></span></button>
                    </div>

                    <script src="../js/banner.js"></script>
                </th>
            </tr>           
            <table>
            <tr>
                <td>
                        <?php require("../Home/mua_ve_online.php") ?>
                </td>
            </tr>
            </table>
          
            <tr>
                <section class="phim-dang-chieu">
                    <table>
                        <tr>
                            <td>
                                <div class="thanh-ngang"></div>
                                <div class="thanh-ngang"></div>
                            </td>
                            <td>
                                <h1>Đang Chiếu</h1>
                            </td>
                            <td>
                                <div class="thanh-ngang0"></div>
                                <div class="thanh-ngang0"></div>
                            </td>
                        </tr>
                    </table>
                    <div>
                <?php  
               
                require "../Admin/connect.php"; 
                $sql = "SELECT * FROM phim_dang_chieu";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<button class="prev0" onclick="chuyenAnhTruoc_DangChieu()"><span>‹</span></button>';
                    echo '<button class="next0" onclick="chuyenAnhSau_DangChieu()"><span>›</span></button>';
                    echo '<ul>';
                    while($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo "<a href='../Home/mo_ta_phim_dang_chieu.php?maphim=".$row["maphim"]."'>";
                        echo "<th><img src='../img/" . $row["anh"] . "' alt='Hình ảnh phim'></th>";
                        echo '<h3><i class="fa-solid fa-ticket"></i> Đặt vé</h3>';
                        echo '</a>';
                        echo "<a href='../Home/mo_ta_phim_dang_chieu.php?maphim=".$row["maphim"]."'>";
                        echo '<h3>Mô tả</h3>';
                        echo '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo "Không có dữ liệu";
                }
                ?>
            </div>

                </section>
                <section class="phim-sap-chieu">
                    <table>
                        <tr>
                            <td>
                                <div class="thanh-ngang1"></div>
                                <div class="thanh-ngang1"></div>
                            </td>
                            <td>
                                <h1>Sắp Chiếu</h1>
                            </td>
                            <td>
                                <div class="thanh-ngang2"></div>
                                <div class="thanh-ngang2"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="phim-navigation">
                    <button class="prev1" onclick="chuyenAnhTruoc_SapChieu()"><span>‹</span></button>
                    <button class="next1" onclick="chuyenAnhSau_SapChieu()"><span>›</span></button>
                </div>
                <ul>
                        <?php  
                        require "../Admin/connect.php"; 
                        $sql = "SELECT * FROM sap_chieu";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<li>';
                                echo "<a href='../Home/mo_ta_sap_chieu.php?maphim=".$row["maphim"]."'>";
                                echo "<th><img src='../img/" . $row["anh"] . "' alt='Hình ảnh phim'></th>";
                                echo '<h3><i class="fa-solid fa-ticket"></i> Đặt trước</h3>';
                                echo '</a>';
                                echo "<a href='../Home/mo_ta_sap_chieu.php?maphim=".$row["maphim"]."'>";
                                echo '<h3>Mô tả</h3>';
                                echo '</a>';
                                echo '</li>';
                            }
                        } else {
                            echo "Không có dữ liệu";
                        }
                        ?>
                    </ul>
                </section>

                <script src="../js/gioithieu.js"></script>
            </tr>
        
            <tr>

                <div class="content-1">
                    <table>
                        <tr>
                            <td>
                                <div class="thanh-ngang3"></div>
                                <div class="thanh-ngang3"></div>
                            </td>
                            <td>
                                <h1 class="title">KHUYẾN MÃI VÀ SỰ KIỆN</h1>
                            </td>
                            <td>
                                <div class="thanh-ngang4"></div>
                                <div class="thanh-ngang4"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="image-container-1">
                        <a href="../Home/uudai1.php"><img class="img1" src="../img/Red-Yellow-Creative-Movie-Retro-Cinema-Flyer.png" alt="Khuyến mãi 1" /></a>
                        <a href="../Home/uudai2.php"><img class="img1" src="../img/Cinema-levee-de-fonds-affiche.png" alt="Khuyến mãi 2" /></a>
                    </div>
                </div>

            </tr>

        </table>
      
        <?php require("../Home/footer.php")?>
    </div>
</body>

</html>