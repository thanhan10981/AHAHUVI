<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dssp_ad.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách sản phẩm</p>
                <form action="" method="POST" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <?php
            require('../Home/connect.php');
            $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';
            $selected_danh_muc = isset($_POST['danh_muc']) ? $_POST['danh_muc'] : null;
            $selected_the_loai = isset($_POST['the_loai']) ? $_POST['the_loai'] : null;
            $selected_ncc = isset($_POST['nha_cung_cap']) ? $_POST['nha_cung_cap'] : null;

            $sql_san_pham = "SELECT sp.*, tl.ten_the_loai, dm.ten_danh_muc, ncc.ten_nhacungcap 
                 FROM san_pham sp
                 LEFT JOIN the_loai tl ON sp.id_the_loai = tl.id_the_loai
                 LEFT JOIN danh_muc dm ON tl.id_danh_muc = dm.id_danh_muc
                 LEFT JOIN nha_cung_cap ncc ON sp.id_ncc = ncc.id_nhacungcap
                 WHERE 1=1";

            if ($selected_danh_muc) {
                $sql_san_pham .= " AND dm.id_danh_muc = $selected_danh_muc";
            }

            if ($selected_the_loai) {
                $sql_san_pham .= " AND tl.id_the_loai = $selected_the_loai";
            }

            if ($selected_ncc) {
                $sql_san_pham .= " AND ncc.id_nhacungcap = $selected_ncc";
            }
            if (!empty($search_keyword)) {
                $search_keyword = $conn->real_escape_string($search_keyword);
                $sql_san_pham .= " AND (sp.ten_sp LIKE '%$search_keyword%' 
                                        OR sp.mo_ta LIKE '%$search_keyword%'
                                        OR sp.tac_gia LIKE '%$search_keyword%' 
                                        OR tl.ten_the_loai LIKE '%$search_keyword%' 
                                        OR dm.ten_danh_muc LIKE '%$search_keyword%' 
                                        OR ncc.ten_nhacungcap LIKE '%$search_keyword%')";
            }


            $sql_count = "SELECT COUNT(*) AS total_products
              FROM san_pham sp
              LEFT JOIN the_loai tl ON sp.id_the_loai = tl.id_the_loai
              LEFT JOIN danh_muc dm ON tl.id_danh_muc = dm.id_danh_muc
              LEFT JOIN nha_cung_cap ncc ON sp.id_ncc = ncc.id_nhacungcap
              WHERE 1=1";

            if ($selected_danh_muc) {
                $sql_count .= " AND dm.id_danh_muc = $selected_danh_muc";
            }

            if ($selected_the_loai) {
                $sql_count .= " AND tl.id_the_loai = $selected_the_loai";
            }

            if ($selected_ncc) {
                $sql_count .= " AND ncc.id_nhacungcap = $selected_ncc";
            }
            if (!empty($search_keyword)) {
                $search_keyword = $conn->real_escape_string($search_keyword);
                $sql_count .= " AND (sp.ten_sp LIKE '%$search_keyword%' 
                                     OR sp.mo_ta LIKE '%$search_keyword%' 
                                     OR sp.tac_gia LIKE '%$search_keyword%' 
                                     OR tl.ten_the_loai LIKE '%$search_keyword%' 
                                     OR dm.ten_danh_muc LIKE '%$search_keyword%' 
                                     OR ncc.ten_nhacungcap LIKE '%$search_keyword%')";
            }

            $result_san_pham = $conn->query($sql_san_pham);
            if (!$result_san_pham) {
                die("Truy vấn sản phẩm lỗi: " . $conn->error);
            }
            $result_count = $conn->query($sql_count);
            if ($result_count) {
                $row_count = $result_count->fetch_assoc();
                $total_products = $row_count['total_products'];
            } else {
                $total_products = 0; // Nếu có lỗi trong truy vấn
            }
            $sql_danh_muc = "SELECT * FROM danh_muc";
            $result_danh_muc = $conn->query($sql_danh_muc);

            $sql_the_loai = $selected_danh_muc
                ? "SELECT * FROM the_loai WHERE id_danh_muc = $selected_danh_muc"
                : "SELECT * FROM the_loai";
            $result_the_loai = $conn->query($sql_the_loai);

            $sql_ncc = "SELECT * FROM nha_cung_cap";
            $result_ncc = $conn->query($sql_ncc);

            if (isset($_GET['delete_id'])) {
                $id_sp = $_GET['delete_id'];

                $sql_xoa_gio_hang = "DELETE FROM san_pham_gio_hang WHERE id_sp = ?";
                $stmt_gio_hang = $conn->prepare($sql_xoa_gio_hang);
                $stmt_gio_hang->bind_param("i", $id_sp);
                $stmt_gio_hang->execute();
                $stmt_gio_hang->close();

                $sql_xoa_san_pham = "DELETE FROM san_pham WHERE id_sp = ?";
                $stmt_san_pham = $conn->prepare($sql_xoa_san_pham);
                $stmt_san_pham->bind_param("i", $id_sp);

                if ($stmt_san_pham->execute()) {
                    echo "<script type='text/javascript'>
                            alert('Sản phẩm đã được xóa thành công.');
                            window.location.href = 'dssp_ad.php'; // Trang bạn muốn chuyển đến
                          </script>";
                } else {
                    echo "<script type='text/javascript'>
                            alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');
                          </script>";
                }

                $stmt_san_pham->close();
            }
            ?>
            <form method="POST">
                <div class="boloc">
                    <div class="soluongsp"><?= $total_products ?> sản phẩm</div>
                    <div class="loc">
                        <div class="loc_danhmuc">
                            <select id="danh_muc" name="danh_muc" onchange="this.form.submit()">
                                <option value="">Tất cả danh mục</option>
                                <?php
                                if ($result_danh_muc->num_rows > 0) {
                                    while ($row = $result_danh_muc->fetch_assoc()) {
                                        $selected = ($row['id_danh_muc'] == $selected_danh_muc) ? 'selected' : '';
                                        echo "<option value='{$row['id_danh_muc']}' $selected>{$row['ten_danh_muc']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="loc_theoloai">
                            <select id="the_loai" name="the_loai" onchange="this.form.submit()">
                                <option value="">Tất cả thể loại</option>
                                <?php
                                if ($result_the_loai->num_rows > 0) {
                                    while ($row = $result_the_loai->fetch_assoc()) {
                                        $selected = ($row['id_the_loai'] == $selected_the_loai) ? 'selected' : '';
                                        echo "<option value='{$row['id_the_loai']}' $selected>{$row['ten_the_loai']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="nha_cung_cap">
                            <select id="nha_cung_cap" name="nha_cung_cap" onchange="this.form.submit()">
                                <option value="">Tất cả NCC</option>
                                <?php
                                if ($result_ncc->num_rows > 0) {
                                    while ($row = $result_ncc->fetch_assoc()) {
                                        $selected = ($row['id_nhacungcap'] == $selected_ncc) ? 'selected' : '';
                                        echo "<option value='{$row['id_nhacungcap']}' $selected>{$row['ten_nhacungcap']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
                if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                    $delete_ids = $_POST['delete_ids'];
                    $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));

                    $sql_xoa_lien_quan = "DELETE FROM san_pham_gio_hang WHERE id_sp IN ($placeholders)";
                    $stmt_lien_quan = $conn->prepare($sql_xoa_lien_quan);
                    $stmt_lien_quan->bind_param(str_repeat('i', count($delete_ids)), ...$delete_ids);
                    $stmt_lien_quan->execute();
                    $stmt_lien_quan->close();

                    $sql_xoa = "DELETE FROM san_pham WHERE id_sp IN ($placeholders)";
                    $stmt = $conn->prepare($sql_xoa);
                    $stmt->bind_param(str_repeat('i', count($delete_ids)), ...$delete_ids);

                    if ($stmt->execute()) {
                        echo "<script>alert('Đã xóa các sản phẩm được chọn!');</script>";
                        echo "<script>location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                    } else {
                        echo "<script>alert('Lỗi khi xóa sản phẩm: {$stmt->error}');</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');</script>";
                }
            }

            $conn->close();
            ?>
            <form method="POST" action="">
                <div class="table-container">
                    <table class="bang_sp">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                                <th>MSP</th>
                                <th>Tên</th>
                                <th>Thể loại</th>
                                <th>Danh mục</th>
                                <th>Ảnh bìa</th>
                                <th>Ảnh phụ</th>
                                <th>Giá</th>
                                <th>Tác giả</th>
                                <th>NXB</th>
                                <th>Nhà XB</th>
                                <th>NCC</th>
                                <th>Mô tả</th>
                                <th>Cài đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_san_pham->num_rows > 0) {
                                while ($row = $result_san_pham->fetch_assoc()) {
                                    $anh_phu = explode(',', $row['anh_phu']);
                                    echo "<tr>
                            <td><input type='checkbox' class='row-checkbox' name='delete_ids[]' value='{$row['id_sp']}' onclick='highlightRow(this)'></td>
                            <td>{$row['id_sp']}</td>
                            <td>{$row['ten_sp']}</td>
                            <td>{$row['ten_the_loai']}</td>
                            <td>{$row['ten_danh_muc']}</td>
                            <td><img src='../IMG/{$row['anh_bia']}' alt='Ảnh bìa' class='small-img'></td>
                            <td>";
                                    foreach ($anh_phu as $anh) {
                                        echo "<img src='../IMG/$anh' alt='Ảnh phụ' class='small-img'>";
                                    }
                                    echo "</td>
                            <td>{$row['gia']}</td>
                            <td>{$row['tac_gia']}</td>
                            <td>{$row['nxb']}</td>
                            <td>{$row['nha_xb']}</td>
                            <td>{$row['ten_nhacungcap']}</td>
                            <td>{$row['mo_ta']}</td>
                            <td>
                                <a href='themsp_ad.php?id={$row['id_sp']}'>
                                    <i class='fa-solid fa-screwdriver-wrench'></i>
                                </a>
                                <a href='?delete_id={$row['id_sp']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sản phẩm này?\")'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                            </td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='15'>Không có sản phẩm nào.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="nut">
                    <button type="submit" name="delete_selected" class="themsp">Xóa</button>
                    <button type="button" class="themsp" onclick="location.href='themsp_ad.php'">Thêm</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../Js/dssp_ad.js"></script>
</body>

</html>