<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/giamgia_ad.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách SP giảm giá</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách SP giảm giá</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="soluongdm"><?php
            require('../Home/connect.php');
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
            $sql = "SELECT COUNT(*) AS so_luong_san_pham FROM `san_pham`WHERE `phan_tram` > 1";
            if (!empty($keyword)) {
            $sql .= " AND (id_sp LIKE ? OR ten_sp LIKE ? OR gia LIKE ? OR gia_giam LIKE ?)";
            }
            $stmt = $conn->prepare($sql);
            if (!empty($keyword)) {
                $search_term = "%$keyword%";
                $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
            }
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc(); 
            if ($row) {
                 echo $row['so_luong_san_pham']; 
            } else {
                echo "0"; 
            }
            ?>
                Sản phẩm</div>
            <div class="danhmuctraiphai">
                <div class="danhmuctrai">
                    <table class="bang_sp">
                        <thead>
                            <tr>
                                
                                <th>MSP</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá gốc</th>
                                <th>Phần trăm</th>
                                <th>Giá giảm</th>
                                <th>Cài đặt</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require('../Home/connect.php');
                            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                            $sql1 = "SELECT id_sp, ten_sp, gia, gia_giam, phan_tram
                                FROM san_pham 
                                WHERE `phan_tram` > 1";

                            if (!empty($keyword)) {
                                $sql1 .= " AND (id_sp LIKE ? OR ten_sp LIKE ? OR gia LIKE ? OR gia_giam LIKE ?)";
                            }
                            $stmt = $conn->prepare($sql1);
                            if (!empty($keyword)) {
                                $search_term = "%$keyword%";
                                $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo '
                            <tr>
                               
                                <td>' . htmlspecialchars($row['id_sp']) . '</td>
                                <td>' . htmlspecialchars($row['ten_sp']) . '</td>
                                <td>' . number_format(htmlspecialchars($row['gia']) ). 'đ</td>
                                <td>' . htmlspecialchars($row['phan_tram']) . '%</td>
                                <td>' . number_format(htmlspecialchars($row['gia_giam']) ). 'đ</td>
                                <td> <a href="../Admin/xoa_sp_gg.php?id_sp='.htmlspecialchars($row['id_sp']).'" 
                                onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này không?\');">
                                <i class="fa-solid fa-trash"></i>
                                </a></td>
                                <td><form action="#" method="post">
                            <input type="hidden" name="id" value="' . htmlspecialchars($row['id_sp']) . '">
                            <button  class="sua"type="submit"value=""><i class="fa-solid fa-wrench"></i></button>
                            </form></td>
                            </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <?php
                require('../Home/connect.php');
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $sql_sp = "SELECT * FROM san_pham WHERE id_sp = ?";
                $stmt = $conn->prepare($sql_sp);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row1 = $result->fetch_assoc();
                $currentCategoryId = isset($row1['id_danh_muc']) ? $row1['id_danh_muc'] : null;
                $idtl = isset($row1['id_the_loai']) ? $row1['id_the_loai'] : null;
                ?>
                <div class="danhmucphai">
                    <form action="cap_nhat_sp_gg.php" method="post">
                        <div class="nhom-dau-vao">
                            <label for="muccangiam">Chọn danh mục</label>
                            <select id="muccangiam" name="id_danh_muc">
                                <?php
                                if ($currentCategoryId) {
                                    $stmt = $conn->prepare("SELECT `ten_danh_muc` FROM `danh_muc` WHERE `id_danh_muc` = ?");
                                    $stmt->bind_param("i", $currentCategoryId);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        $currentCategory = $result->fetch_assoc();
                                        echo '<option value="' . $currentCategoryId . '" selected>' . htmlspecialchars($currentCategory['ten_danh_muc']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Chọn danh mục</option>';
                                }


                                $sql = "SELECT `id_danh_muc`, `ten_danh_muc` FROM `danh_muc`";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($currentCategoryId && $row['id_danh_muc'] == $currentCategoryId) {
                                            continue;
                                        }
                                        echo '<option value="' . $row['id_danh_muc'] . '">' . htmlspecialchars($row['ten_danh_muc']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="theloai">Chọn thể loại</label>

                            <?php
                            if ($idtl) {
                                $stmt = $conn->prepare("SELECT `ten_the_loai` FROM `the_loai` WHERE `id_the_loai` = ?");
                                $stmt->bind_param("i", $idtl);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    $currentCategory = $result->fetch_assoc();
                                    echo '<select id="theloai" name="id_the_loai"><option value="' . $idtl . '" selected>' . htmlspecialchars($currentCategory['ten_the_loai']) . '</option> </select>';
                                }
                            } else {
                                echo '<select id="theloai" name="id_the_loai">
                                <option value="">Chọn thể loại</option>
                                </select>';
                            }

                            ?>
                        </div>

                        <div class="nhom-dau-vao">
                            <label for="msp">Mã sản phẩm</label>
                            <input type="text" name="id_sp" placeholder="Nhập mã sản phẩm" value="<?php echo htmlspecialchars($row1['id_sp'] ?? ''); ?>">
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="tensp">Tên sản phẩm</label>
                            <input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm" value="<?php echo htmlspecialchars($row1['ten_sp'] ?? ''); ?>">
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="phantram">Phần trăm</label>
                            <input type="text" name="phan_tram" placeholder="Nhập phần trăm giảm" value="<?php echo htmlspecialchars($row1['phan_tram'] ?? ''); ?>%">
                        </div>
                   
                    <div class="nut-bieu-mau">
                        <button type="submit" name="cap_nhat">CẬP NHẬT</button>
                        <button type="submit" name="them">THÊM</button>
                    </div> </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../Js/giam_gia.js"></script>
</body>

</html>