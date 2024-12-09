<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../Home/connect.php");
$danhmuc_id = isset($_GET['danhmuc_id']) ? intval($_GET['danhmuc_id']) : null;
$theloai_id = isset($_GET['theloai_id']) ? intval($_GET['theloai_id']) : null;
$id_nhacungcap = isset($_GET['id_nhacungcap']) ? intval($_GET['id_nhacungcap']) : null;
$keyword = isset($_GET['keyword']) ? intval($_GET['keyword']) : null;

$ten_danhmuc = '';
$ten_theloai = '';
if ($danhmuc_id) {
    $sql_danhmuc = "SELECT ten_danh_muc FROM danh_muc WHERE id_danh_muc = ?";
    $stmt_danhmuc = $conn->prepare($sql_danhmuc);
    $stmt_danhmuc->bind_param("i", $danhmuc_id);
    $stmt_danhmuc->execute();
    $result_danhmuc = $stmt_danhmuc->get_result();
    if ($result_danhmuc && $result_danhmuc->num_rows > 0) {
        $row = $result_danhmuc->fetch_assoc();
        $ten_danhmuc = htmlspecialchars($row['ten_danh_muc']);
    }

    $sql_theloai_list = "SELECT id_the_loai, ten_the_loai FROM the_loai WHERE id_danh_muc = ?";
    $stmt_theloai_list = $conn->prepare($sql_theloai_list);
    $stmt_theloai_list->bind_param("i", $danhmuc_id);
    $stmt_theloai_list->execute();
    $result_theloai_list = $stmt_theloai_list->get_result();
}

if ($theloai_id) {
    $sql_theloai = "SELECT ten_the_loai, id_danh_muc FROM the_loai WHERE id_the_loai = ?";
    $stmt_theloai = $conn->prepare($sql_theloai);
    $stmt_theloai->bind_param("i", $theloai_id);
    $stmt_theloai->execute();
    $result_theloai = $stmt_theloai->get_result();
    if ($result_theloai && $result_theloai->num_rows > 0) {
        $row = $result_theloai->fetch_assoc();
        $ten_theloai = htmlspecialchars($row['ten_the_loai']);
        $danhmuc_id = intval($row['id_danh_muc']);

        $sql_danhmuc = "SELECT ten_danh_muc FROM danh_muc WHERE id_danh_muc = ?";
        $stmt_danhmuc = $conn->prepare($sql_danhmuc);
        $stmt_danhmuc->bind_param("i", $danhmuc_id);
        $stmt_danhmuc->execute();
        $result_danhmuc = $stmt_danhmuc->get_result();
        if ($result_danhmuc && $result_danhmuc->num_rows > 0) {
            $row_danhmuc = $result_danhmuc->fetch_assoc();
            $ten_danhmuc = htmlspecialchars($row_danhmuc['ten_danh_muc']);
        }
    } else {
        echo "Không tìm thấy thể loại.";
    }
}

if ($danhmuc_id || $theloai_id) {
    $sql_theloai_list_all = "SELECT id_the_loai, ten_the_loai FROM the_loai WHERE id_danh_muc = ?";
    $stmt_theloai_list_all = $conn->prepare($sql_theloai_list_all);
    $stmt_theloai_list_all->bind_param("i", $danhmuc_id);
    $stmt_theloai_list_all->execute();
    $result_theloai_list_all = $stmt_theloai_list_all->get_result();
} else {
    $sql_theloai_list_all = "SELECT id_the_loai, ten_the_loai FROM the_loai";
    $result_theloai_list_all = $conn->query($sql_theloai_list_all);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHAHUVI.com - nhà sách trực tuyến</title>
    <link rel="icon" href="../IMG/logo.png">
    <link rel="stylesheet" href="../Css/allproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php require("../Home/header.php") ?>
    <div class="than-tatcasp">
        <div class="mucsp">
            <ol class="danhmuc">
                <li class="danhmuctheloai"><a href="index.php">TRANG CHỦ</a><i class="fa-solid fa-chevron-right"></i></li>
                <?php if ($ten_danhmuc): ?>
                    <li class="danhmuctheloai"><a href="allproduct.php?danhmuc_id=<?= $danhmuc_id ?>"><?= $ten_danhmuc ?></a><i class="fa-solid fa-chevron-right"></i></li>
                <?php endif; ?>
                <?php if ($ten_theloai): ?>
                    <li class="danhmuctheloai"><a href="allproduct.php?danhmuc_id=<?= $danhmuc_id ?>&theloai_id=<?= $theloai_id ?>"><?= $ten_theloai ?></a></li>
                <?php endif; ?>
            </ol>
        </div>
        <div class="tatcasp">
            <div class="sidebar">
                <h3>Nhóm Sản Phẩm</h3>
                <ul class="filter-list theloai-list">
                    <li>Tất Cả Nhóm Sản Phẩm</li>
                    <?php if ($ten_danhmuc): ?>
                        <li><a href="allproduct.php?danhmuc_id=<?= $danhmuc_id ?>" class="danhmucsp"><?= $ten_danhmuc ?></a></li>
                    <?php endif; ?>
                    <?php
                    if ($result_theloai_list_all->num_rows > 0) {
                        while ($row = $result_theloai_list_all->fetch_assoc()) {
                            // Kiểm tra xem thể loại có đang được chọn không
                            $activeClass = ($theloai_id == $row['id_the_loai']) ? 'active' : ''; // Thêm class 'active' nếu thể loại được chọn

                            // Hiển thị thể loại với theloai_id
                            echo '<li><a href="allproduct.php?danhmuc_id=' . $danhmuc_id . '&theloai_id=' . $row["id_the_loai"] . '" class="theloaisp ' . $activeClass . '">' . htmlspecialchars($row["ten_the_loai"]) . '</a></li>';
                        }
                    } else {
                        echo '<li>Không có thể loại nào</li>';
                    }
                    ?>
                </ul>
                <button class="nutxemthem">Xem thêm</button>
                <button class="rutgon">Rút gọn</button>
                <hr>
                <h3>Giá</h3>
                <ul class="filter-list">
                    <li><input type="radio" name="gia" value="0-150000" onclick="filterByPrice(0, 150000)">0đ - 150.000đ</li>
                    <li><input type="radio" name="gia" value="150000-300000" onclick="filterByPrice(150000, 300000)">150.000đ - 300.000đ</li>
                    <li><input type="radio" name="gia" value="300000-500000" onclick="filterByPrice(300000, 500000)">300.000đ - 500.000đ</li>
                    <li><input type="radio" name="gia" value="500000-700000" onclick="filterByPrice(500000, 700000)">500.000đ - 700.000đ</li>
                    <li><input type="radio" name="gia" value="700000+" onclick="filterByPrice(700000, null)">700.000đ trở lên</li>
                </ul>
                <hr>
                <?php
                require("../Home/connect.php");
                $sql_nhacc = "SELECT ten_nhacungcap,id_nhacungcap FROM nha_cung_cap";
                $result_ncc = $conn->query($sql_nhacc);
                ?>
                <h3>Nhà Cung Cấp</h3>
                <ul class="filter-list ncc-list">
                    <?php
                    if ($result_ncc->num_rows > 0) {
                        while ($row = $result_ncc->fetch_assoc()) {
                            $ten_nhacungcap = htmlspecialchars($row["ten_nhacungcap"]);
                            $id_nhacungcap = htmlspecialchars($row["id_nhacungcap"]);
                            // Kiểm tra nếu nhà cung cấp hiện tại đã được chọn
                            $isChecked = (isset($_GET['nhacungcap']) && $_GET['nhacungcap'] === $ten_nhacungcap) ? 'checked' : '';
                            echo '<li><input type="radio" name="nhacungcap" value="' . $ten_nhacungcap . '" onclick="selectSupplier(\'' . $ten_nhacungcap . '\', \'' . $id_nhacungcap . '\')" ' . $isChecked . '>' . $ten_nhacungcap . '</li>';
                        }
                    }
                    ?>
                </ul>
                <button class="nutxemthem-ncc">Xem thêm</button>
                <button class="rutgon-ncc">Rút gọn</button>
            </div>
            <?php

            $min_gia = isset($_GET['gia']) ? explode('-', $_GET['gia'])[0] : null;
            $max_gia = isset($_GET['gia']) ? explode('-', $_GET['gia'])[1] : null;
            $max_gia = ($max_gia === "null" || $max_gia === "") ? null : $max_gia;



            if (isset($_GET['gia'])) {
                list($min_gia, $max_gia) = explode('-', $_GET['gia']);
                $min_gia = intval($min_gia);
                $max_gia = $max_gia === "null" ? null : intval($max_gia);
            }

            if ($min_gia !== null && $max_gia !== null) {
                // Truy vấn cho khoảng giá cụ thể
                $query = "SELECT * FROM san_pham WHERE gia_sanpham BETWEEN $min_gia AND $max_gia";
            } elseif ($min_gia !== null) {
                // Truy vấn cho giá từ $min_gia trở lên
                $query = "SELECT * FROM san_pham WHERE gia_sanpham >= $min_gia";
            }
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $sp_per_page = 12;
            $offset = ($page - 1) * $sp_per_page;
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
            $danhmuc_id = isset($_GET['danhmuc_id']) ? $_GET['danhmuc_id'] : null;
            $theloai_id = isset($_GET['theloai_id']) ? $_GET['theloai_id'] : null;
            $sql_count = "SELECT COUNT(*) AS total FROM san_pham WHERE (? IS NULL OR id_danh_muc = ?) AND (? IS NULL OR id_ncc = ?) AND (? IS NULL OR id_the_loai = ?) AND (? IS NULL OR gia >= ?) AND (? IS NULL OR gia <= ?) AND (? IS NULL OR ten_sp LIKE ?)";
            $stmt_count = $conn->prepare($sql_count);
            if ($stmt_count === false) {
                die('Lỗi truy vấn SQL: ' . $conn->error);
            }
            $keyword_param = ($keyword !== null) ? "%" . $keyword . "%" : null;
            $stmt_count->bind_param(
                "iiiiiiddddss",
                $danhmuc_id,$danhmuc_id, 
                $id_nhacungcap, $id_nhacungcap, 
                $theloai_id, $theloai_id,   
                $min_gia, $min_gia,         
                $max_gia, $max_gia, 
                $keyword, $keyword_param          
            );
            $stmt_count->execute();
            if ($stmt_count === false) {
                die('Lỗi truy vấn SQL: ' . $conn->error);
            }
            $result_count = $stmt_count->get_result();
            $row_count = $result_count->fetch_assoc();
            $total_san_pham = $row_count['total'];
            $total_pages = ceil($total_san_pham / $sp_per_page);
            ?>
            <div class="than-tatcasp-phai">
                <div class="boloc">
                    <div class="iconboloc"><i class="fa-solid fa-filter"></i></div>
                    <div class="soluongsp"><?php echo $total_san_pham; ?></div>
                    <div class="mucdachon">
                        <?php
                        if ($ten_theloai) {
                            echo htmlspecialchars($ten_theloai);
                        } elseif ($ten_danhmuc) {
                            echo htmlspecialchars($ten_danhmuc);
                        }
                        ?>
                    </div>

                    <?php
                    if ($min_gia !== null && $max_gia !== null) {
                        echo '<div class="giaboloc">';
                        echo "Giá: " . number_format($min_gia, 0, '', ',') . "đ - " . number_format($max_gia, 0, '', ',') . "đ";
                        echo '<i class="fa-solid fa-xmark" onclick="clearPriceFilter()"></i>';
                        echo '</div>';
                    } elseif ($min_gia !== null) {
                        echo '<div class="giaboloc">';
                        echo "Giá: " . number_format($min_gia, 0, '', ',') . "đ trở lên";
                        echo '<i class="fa-solid fa-xmark" onclick="clearPriceFilter()"></i>';
                        echo '</div>';
                    }

                    ?>
                    <?php
                    // Hiển thị nhà cung cấp đã chọn và nút xóa
                    if (isset($_GET['nhacungcap'])) {
                        $nhacungcap = htmlspecialchars($_GET['nhacungcap']);
                        $id_nhacungcap = htmlspecialchars($_GET['id_nhacungcap']);
                        echo '<div class="nhacungcap">Nhà Cung Cấp: <span>' . $nhacungcap . '</span><i class="fa-solid fa-xmark" onclick="clearSupplierFilter()"></i></div>';
                    }
                    ?>

                </div>
                <hr>
                <div class="danhsachsp">
                    <?php
                    require("../Home/connect.php");
                    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
                    $sql_sp = "SELECT DISTINCT id_sp, ten_sp, gia, phan_tram, gia_giam, anh_bia, id_ncc 
                               FROM san_pham 
                               WHERE (? IS NULL OR id_danh_muc = ?) 
                                 AND (? IS NULL OR id_the_loai = ?) 
                                 AND (? IS NULL OR gia >= ?) 
                                 AND (? IS NULL OR gia <= ?) 
                                AND (? IS NULL OR id_ncc = ?) 
                                 AND (? IS NULL OR ten_sp LIKE ?) 
                               LIMIT ? OFFSET ?";
                               
                    $stmt_sp = $conn->prepare($sql_sp);
                    if ($stmt_sp === false) {
                        die('Lỗi truy vấn SQL: ' . $conn->error);
                    }
                    
                    // Xử lý từ khóa để sử dụng trong LIKE
                    $keyword_param = ($keyword !== null) ? "%" . $keyword . "%" : null;
                    
                    // Gán các tham số vào câu truy vấn
                    $stmt_sp->bind_param(
                        "iiiiddddiissii",
                        $danhmuc_id, $danhmuc_id,
                        $theloai_id, $theloai_id,
                        $min_gia, $min_gia,
                        $max_gia, $max_gia,
                        $id_nhacungcap, $id_nhacungcap,
                        $keyword,$keyword_param,
                        $sp_per_page,
                        $offset
                    );
                    
                    // Thực thi truy vấn
                    $stmt_sp->execute();
                    $result_sp = $stmt_sp->get_result();
                    

                    while ($row = $result_sp->fetch_assoc()) {

                        $id_sp = $row['id_sp'];
                        $query_sao = "SELECT AVG(danh_gia) as trung_binh_sao FROM binh_luan WHERE id_sp = ?";

                        if ($stmt = $conn->prepare($query_sao)) {
                            $stmt->bind_param('i', $id_sp); // Tham số sản phẩm
                            $stmt->execute();
                            $result_sao = $stmt->get_result();
                            $row_sao = $result_sao->fetch_assoc();
                            $trung_binh_sao = $row_sao['trung_binh_sao'] ?? 0;
                            $so_sao = round($trung_binh_sao);

                            echo '
                            <div class="sp">
                                <form action="productdetail.php" method="get">
                                    <input type="hidden" name="id_sp" value="' . htmlspecialchars($row['id_sp']) . '">
                                    <button type="submit" style="background: none; border: none; padding: 0;">
                                    <img src="../IMG/' . htmlspecialchars($row['anh_bia']) . '" alt="' . htmlspecialchars($row['ten_sp']) . '">
                                    <h4>' . htmlspecialchars($row['ten_sp']) . '</h4>
                                    </button>
                                </form>
                                <span class="giamgia"> ' . htmlspecialchars($row['phan_tram']) . '% </span>
                            <div class="giatien">
                            <span class="giacu">' . number_format($row['gia'], 0, '', ',') . 'đ</span>
                            <span class="giamoi">' . number_format($row['gia_giam'], 0, '', ',') . 'đ</span>
                            </div>
                            <div class="sao">';
                            for ($i = 0; $i <= 5; $i++) {
                                if ($i < $so_sao) {
                                    echo '<i class="fas fa-star" style="color: #FFD700;"></i>';
                                } else {
                                    echo '<i class="fas fa-star"></i>';
                                }
                            }
                            echo  '</div>
                        </div>';
                        }
                    }

                    ?>
                </div>
                <div class="chuyentrang">
                    <?php if ($page > 1): ?>
                        <a href="?danhmuc_id=<?= $danhmuc_id ?>&theloai_id=<?= $theloai_id ?>&page=<?= $page - 1 ?>"><i class="fa-solid fa-backward"></i></a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?danhmuc_id=<?= $danhmuc_id ?>&theloai_id=<?= $theloai_id ?>&page=<?= $i ?>" class="sotrang <?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?danhmuc_id=<?= $danhmuc_id ?>&theloai_id=<?= $theloai_id ?>&page=<?= $page + 1 ?>"><i class="fa-solid fa-forward"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php require("../Home/footer.php") ?>
    <script src="../Js/allproduct.js"></script>
</body>

</html>