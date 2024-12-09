<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dsdanhmuc.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách danh mục</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <?php
        $sql_count = "SELECT COUNT(*) AS total_danhmuc
         FROM danh_muc dm
         WHERE 1=1";
        $result_count = $conn->query($sql_count);
        if ($result_count) {
            $row_count = $result_count->fetch_assoc();
            $total_danhmuc = $row_count['total_danhmuc'];
        } else {
            $total_danhmuc = 0; // Nếu có lỗi trong truy vấn
        }

        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';
        $sql_danhmuc = "SELECT * FROM danh_muc dm";
        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_danhmuc .= " WHERE (dm.id_danh_muc LIKE '%$search_keyword%'  
                                    OR dm.ten_danh_muc LIKE '%$search_keyword%')";
        }
        $result_danhmuc = $conn->query($sql_danhmuc);
        if (!$result_danhmuc) {
            die("Truy vấn sản phẩm lỗi: " . $conn->error);
        }

        if (isset($_GET['delete_id'])) {
            $id_dm = $_GET['delete_id']; // ID danh mục cần xóa

            $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                WHERE sp.id_danh_muc = ?";
            $stmt_xoagh = $conn->prepare($sql_xoa_gh);
            $stmt_xoagh->bind_param("i", $id_dm);
            if (!$stmt_xoagh->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                $stmt_xoagh->close();
                exit;
            }
            $stmt_xoagh->close();


            $sql_xoa_sp = "DELETE FROM san_pham WHERE id_danh_muc = ?";
            $stmt_xoasp = $conn->prepare($sql_xoa_sp);
            $stmt_xoasp->bind_param("i", $id_dm);
            if (!$stmt_xoasp->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                $stmt_xoasp->close();
                exit;
            }
            $stmt_xoasp->close();


            $sql_xoa_dm = "DELETE FROM danh_muc WHERE id_danh_muc = ?";
            $stmt_xoa_dm = $conn->prepare($sql_xoa_dm);
            $stmt_xoa_dm->bind_param("i", $id_dm);

            if ($stmt_xoa_dm->execute()) {
                echo "<script type='text/javascript'>
                        alert('Danh mục và các sản phẩm liên quan đã được xóa thành công.');
                        window.location.href = 'dsdanhmuc.php';
                      </script>";
            } else {
                echo "<script type='text/javascript'>
                        alert('Lỗi khi xóa danh mục: " . $conn->error . "');
                      </script>";
            }

            $stmt_xoa_dm->close();
        }


        // Xóa nhiều danh mục
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
            if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                $delete_ids = $_POST['delete_ids'];
                $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
        
                // Bước 1: Xóa sản phẩm trong giỏ hàng
                $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                                INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                                WHERE sp.id_danh_muc IN ($placeholders)";
                $stmt_xoagh = $conn->prepare($sql_xoa_gh);
                $types = str_repeat("i", count($delete_ids)); // Tạo chuỗi kiểu dữ liệu cho bind_param
                $stmt_xoagh->bind_param($types, ...$delete_ids); // Truyền mảng vào bind_param
                if (!$stmt_xoagh->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                    $stmt_xoagh->close();
                    exit;
                }
                $stmt_xoagh->close();
        
                // Bước 2: Xóa sản phẩm
                $sql_xoa_sp = "DELETE FROM san_pham WHERE id_danh_muc IN ($placeholders)";
                $stmt_xoasp = $conn->prepare($sql_xoa_sp);
                $stmt_xoasp->bind_param($types, ...$delete_ids); // Truyền mảng vào bind_param
                if (!$stmt_xoasp->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                    $stmt_xoasp->close();
                    exit;
                }
                $stmt_xoasp->close();
        
                // Bước 3: Xóa danh mục
                $sql_xoa_dm = "DELETE FROM danh_muc WHERE id_danh_muc IN ($placeholders)";
                $stmt_xoa_dm = $conn->prepare($sql_xoa_dm);
                $stmt_xoa_dm->bind_param($types, ...$delete_ids); // Truyền mảng vào bind_param
        
                if ($stmt_xoa_dm->execute()) {
                    echo "<script>alert('Đã xóa các danh mục được chọn!');</script>";
                    echo "<script>location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                } else {
                    echo "<script>alert('Lỗi khi xóa danh mục: {$stmt_xoa_dm->error}');</script>";
                }
                $stmt_xoa_dm->close();
            } else {
                echo "<script>alert('Vui lòng chọn ít nhất một danh mục để xóa!');</script>";
            }
        }
        
        if (isset($_GET['edit_id'])) {
            $id_dm = $_GET['edit_id']; // Lấy ID danh mục từ URL
        
            // Truy vấn để lấy thông tin danh mục
            $sql = "SELECT * FROM danh_muc WHERE id_danh_muc = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_dm);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        
            $id_danh_muc = $row['id_danh_muc'];
            $ten_danh_muc = $row['ten_danh_muc'];
        } else {
            // Nếu không có danh mục nào được chọn, đặt giá trị mặc định cho các trường nhập liệu
            $id_danh_muc = '';
            $ten_danh_muc = '';
        }
        
        // xử lý sau khi nhấn cập nhật
        if (isset($_POST['update_category'])) {
            $id_danh_muc = $_POST['id_danh_muc']; // Lấy ID danh mục
            $ten_danh_muc = $_POST['ten_danh_muc']; // Lấy tên danh mục

            // Truy vấn cập nhật danh mục
            $sql_update = "UPDATE danh_muc SET ten_danh_muc = ? WHERE id_danh_muc = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $ten_danh_muc, $id_danh_muc);

            if ($stmt_update->execute()) {
                echo "<script>alert('Danh mục đã được cập nhật thành công!');</script>";
                echo "<script>window.location.href = 'dsdanhmuc.php';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật danh mục: " . $conn->error . "');</script>";
            }

            $stmt_update->close();
        }

        if (isset($_POST['add_category'])) {
            $ten_danh_muc = $_POST['ten_danh_muc'];
            if (!empty($ten_danh_muc)) {
                $sql_insert = "INSERT INTO danh_muc (ten_danh_muc) VALUES (?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("s", $ten_danh_muc);
        
                if ($stmt_insert->execute()) {
                    echo "<script>alert('Danh mục đã được thêm thành công!');</script>";
                    echo "<script>window.location.href = 'dsdanhmuc.php';</script>";
                } else {
                    echo "<script>alert('Lỗi khi thêm danh mục: " . $conn->error . "');</script>";
                }
        
                $stmt_insert->close();
            } else {
                echo "<script>alert('Vui lòng nhập tên danh mục!');</script>";
            }
        }
        ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách danh mục</p>
                <form action="" method="POST" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="soluongdm"><?= $total_danhmuc ?> Danh mục</div>
            <form method="POST" action="">
            <div class="danhmuctraiphai">
                <div class="danhmuctrai">
                    <table class="bang_sp">
                        <thead>
                            <tr>
                                <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                                <th>MDM</th>
                                <th>Tên danh mục</th>
                                <th>Cài đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_danhmuc->num_rows > 0) {
                                while ($row = $result_danhmuc->fetch_assoc()) {
                                    echo "
                            <tr>
                                <td><input type='checkbox' class='row-checkbox' name='delete_ids[]' value='{$row['id_danh_muc']}' onclick='highlightRow(this)'></td>
                                <td>{$row['id_danh_muc']}</td>
                                <td>{$row['ten_danh_muc']}</td>
                                <td>
                                <a href='?edit_id={$row['id_danh_muc']}'>
                                <i class='fa-solid fa-screwdriver-wrench'></i>
                                </a>
                                <a href='?delete_id={$row['id_danh_muc']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa danh mục này?\")'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                                </td>
                            </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Không tìm thấy danh mục nào.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="danhmucphai">
                        <div class="nhom-dau-vao">
                            <label for="mdm">Mã danh mục (MDM)</label>
                            <input type="text" id="mdm" name="id_danh_muc" value="<?= $id_danh_muc ?>">
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="tendanhmuc">Tên danh mục</label>
                            <!-- Điền giá trị tên danh mục vào input -->
                            <input type="text" id="tendanhmuc" name="ten_danh_muc" value="<?= $ten_danh_muc ?>">
                        </div>
                        <div class="nut-bieu-mau">
                            <button type="submit" name="update_category">CẬP NHẬT</button>
                            <button type="submit" name="add_category">THÊM</button>
                            <button type="submit" name="delete_selected">XÓA</button>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script src="../Js/dssp_ad.js"></script>
</body>

</html>