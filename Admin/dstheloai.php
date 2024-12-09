<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dsdanhmuc.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách thể loại</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <?php
        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';

        $sql_count = "SELECT COUNT(*) AS total_theloai
        FROM the_loai tl
        INNER JOIN danh_muc dm ON tl.id_danh_muc = dm.id_danh_muc";

        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_count .= " WHERE (tl.id_the_loai LIKE '%$search_keyword%'  
                    OR tl.ten_the_loai LIKE '%$search_keyword%'
                    OR dm.ten_danh_muc LIKE '%$search_keyword%')";
        }

        $result_count = $conn->query($sql_count);
        if ($result_count) {
            $row_count = $result_count->fetch_assoc();
            $total_theloai = $row_count['total_theloai'];
        } else {
            $total_theloai = 0;
        }
        if (!$result_count) {
            die("Lỗi truy vấn: " . $conn->error);
        }
        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';
        $sql_theloai = "SELECT tl.id_the_loai, tl.ten_the_loai, dm.ten_danh_muc
                FROM the_loai tl
                INNER JOIN danh_muc dm ON tl.id_danh_muc = dm.id_danh_muc";

        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_theloai .= " WHERE (tl.id_the_loai LIKE '%$search_keyword%'  
                             OR tl.ten_the_loai LIKE '%$search_keyword%'
                             OR dm.ten_danh_muc LIKE '%$search_keyword%')";
        }

        $result_theloai = $conn->query($sql_theloai);
        if (!$result_theloai) {
            die("Truy vấn sản phẩm lỗi: " . $conn->error);
        }


        if (isset($_GET['edit_id'])) {
            $edit_id = $_GET['edit_id']; // Lấy ID thể loại từ URL
            $sql_edit = "SELECT tl.id_the_loai, tl.ten_the_loai, dm.id_danh_muc, dm.ten_danh_muc
                         FROM the_loai tl
                         INNER JOIN danh_muc dm ON tl.id_danh_muc = dm.id_danh_muc
                         WHERE tl.id_the_loai = ?";
            $stmt = $conn->prepare($sql_edit);
            $stmt->bind_param("i", $edit_id);
            $stmt->execute();
            $result_edit = $stmt->get_result();

            if ($row_edit = $result_edit->fetch_assoc()) {
                $id_the_loai = $row_edit['id_the_loai'];
                $ten_the_loai = $row_edit['ten_the_loai'];
                $selected_danh_muc = $row_edit['id_danh_muc'];
                $ten_danh_muc = $row_edit['ten_danh_muc'];
            } else {
                echo "<script>alert('Không tìm thấy thông tin thể loại này!');</script>";
                echo "<script>window.location.href = 'dstheloai.php';</script>";
            }
        } else {
            // Giá trị mặc định khi không có gì được chọn
            $id_the_loai = '';
            $ten_the_loai = '';
            $selected_danh_muc = '';
            $ten_danh_muc = '';
        }


        // xử lý sau khi nhấn cập nhật
        if (isset($_POST['update_category'])) {
            // Lấy dữ liệu từ form
            $id_the_loai = $_POST['id_the_loai'];
            $ten_the_loai = $_POST['ten_the_loai'];
            $id_danh_muc = $_POST['id_danh_muc'];

            // Kiểm tra nếu chưa chọn danh mục
            if (empty($id_danh_muc)) {
                echo "<script>alert('Vui lòng chọn danh mục!');</script>";
            } else {
                // Cập nhật cơ sở dữ liệu
                $sql_update = "UPDATE the_loai SET ten_the_loai = ?, id_danh_muc = ? WHERE id_the_loai = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("sii", $ten_the_loai, $id_danh_muc, $id_the_loai);

                if ($stmt_update->execute()) {
                    echo "<script>alert('Thể loại đã được cập nhật thành công!');</script>";
                    echo "<script>window.location.href = 'dstheloai.php';</script>";
                } else {
                    echo "<script>alert('Lỗi khi cập nhật: " . $stmt_update->error . "');</script>";
                }

                $stmt_update->close();
            }
        }

        if (isset($_GET['delete_id'])) {
            $id_the_loai = $_GET['delete_id']; // ID thể loại cần xóa

            // Bước 1: Xóa sản phẩm trong giỏ hàng liên quan đến thể loại
            $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                   INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                   WHERE sp.id_the_loai = ?";
            $stmt_xoagh = $conn->prepare($sql_xoa_gh);
            $stmt_xoagh->bind_param("i", $id_the_loai);
            if (!$stmt_xoagh->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                $stmt_xoagh->close();
                exit;
            }
            $stmt_xoagh->close();

            // Bước 2: Xóa sản phẩm thuộc thể loại
            $sql_xoa_sp = "DELETE FROM san_pham WHERE id_the_loai = ?";
            $stmt_xoasp = $conn->prepare($sql_xoa_sp);
            $stmt_xoasp->bind_param("i", $id_the_loai);
            if (!$stmt_xoasp->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                $stmt_xoasp->close();
                exit;
            }
            $stmt_xoasp->close();

            // Bước 3: Xóa thể loại
            $sql_xoa_the_loai = "DELETE FROM the_loai WHERE id_the_loai = ?";
            $stmt_xoa_tl = $conn->prepare($sql_xoa_the_loai);
            $stmt_xoa_tl->bind_param("i", $id_the_loai);
            if ($stmt_xoa_tl->execute()) {
                echo "<script type='text/javascript'>
                alert('Thể loại và các dữ liệu liên quan đã được xóa thành công.');
                window.location.href = 'dstheloai.php';
              </script>";
            } else {
                echo "<script type='text/javascript'>
                alert('Lỗi khi xóa thể loại: " . $conn->error . "');
              </script>";
            }
            $stmt_xoa_tl->close();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
            if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                $delete_ids = $_POST['delete_ids'];
                $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
                $types = str_repeat("i", count($delete_ids)); // Tạo chuỗi kiểu dữ liệu
        
                // Bước 1: Xóa sản phẩm trong giỏ hàng liên quan đến các thể loại
                $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                               INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                               WHERE sp.id_the_loai IN ($placeholders)";
                $stmt_xoagh = $conn->prepare($sql_xoa_gh);
                $stmt_xoagh->bind_param($types, ...$delete_ids);
                if (!$stmt_xoagh->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                    $stmt_xoagh->close();
                    exit;
                }
                $stmt_xoagh->close();
        
                // Bước 2: Xóa sản phẩm thuộc các thể loại
                $sql_xoa_sp = "DELETE FROM san_pham WHERE id_the_loai IN ($placeholders)";
                $stmt_xoasp = $conn->prepare($sql_xoa_sp);
                $stmt_xoasp->bind_param($types, ...$delete_ids);
                if (!$stmt_xoasp->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                    $stmt_xoasp->close();
                    exit;
                }
                $stmt_xoasp->close();
        
                // Bước 3: Xóa các thể loại
                $sql_xoa_tl = "DELETE FROM the_loai WHERE id_the_loai IN ($placeholders)";
                $stmt_xoa_tl = $conn->prepare($sql_xoa_tl);
                $stmt_xoa_tl->bind_param($types, ...$delete_ids);
                if ($stmt_xoa_tl->execute()) {
                    echo "<script>alert('Đã xóa các thể loại được chọn!');</script>";
                    echo "<script>location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                } else {
                    echo "<script>alert('Lỗi khi xóa thể loại: {$stmt_xoa_tl->error}');</script>";
                }
                $stmt_xoa_tl->close();
            } else {
                echo "<script>alert('Vui lòng chọn ít nhất một thể loại để xóa!');</script>";
            }
        }
        
        if (isset($_POST['add_category'])) {
            // Lấy dữ liệu từ form
            $ten_the_loai = $_POST['ten_the_loai'];
            $id_danh_muc = $_POST['id_danh_muc'];
        
            // Kiểm tra dữ liệu đầu vào
            if (empty($ten_the_loai)) {
                echo "<script>alert('Vui lòng nhập tên thể loại!');</script>";
            } elseif (empty($id_danh_muc)) {
                echo "<script>alert('Vui lòng chọn danh mục!');</script>";
            } else {
                // Chuẩn bị câu lệnh SQL để thêm thể loại
                $sql_insert = "INSERT INTO the_loai (ten_the_loai, id_danh_muc) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("si", $ten_the_loai, $id_danh_muc);
        
                if ($stmt_insert->execute()) {
                    echo "<script>alert('Thể loại đã được thêm thành công!');</script>";
                    echo "<script>window.location.href = 'dstheloai.php';</script>";
                } else {
                    echo "<script>alert('Lỗi khi thêm thể loại: " . $stmt_insert->error . "');</script>";
                }
        
                $stmt_insert->close();
            }
        }
        
        ?>

        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách thể loại</p>
                <form action="" method="POST" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="soluongdm"><?= $total_theloai ?> Thể loại</div>
            <form method="POST" action="">
                <div class="danhmuctraiphai">
                    <div class="danhmuctrai">
                        <table class="bang_sp">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                                    <th>MTL</th>
                                    <th>Tên danh mục</th>
                                    <th>Tên thể loại</th>
                                    <th>Cài đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_theloai->num_rows > 0) {
                                    while ($row = $result_theloai->fetch_assoc()) {
                                        echo "<tr>
                                <td><input type='checkbox' class='row-checkbox' name='delete_ids[]' value='{$row['id_the_loai']}' onclick='highlightRow(this)'></td>
                                <td>{$row['id_the_loai']}</td>
                                <td>{$row['ten_danh_muc']}</td>
                                <td>{$row['ten_the_loai']}</td>
                                <td>
                                <a href='?edit_id={$row['id_the_loai']}'>
                                <i class='fa-solid fa-screwdriver-wrench'></i>
                                </a>
                                <a href='?delete_id={$row['id_the_loai']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa thể loại này?\")'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                                </td>
                                </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="danhmucphai">
                        <div class="nhom-dau-vao">
                            <label for="mtl">Mã thể loại (MTL)</label>
                            <input type="text" id="mtl" name="id_the_loai" value="<?= htmlspecialchars($id_the_loai) ?>" placeholder="Nhập mã thể loại" readonly>
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="danhmuc">Danh mục</label>
                            <select id="danhmuc" name="id_danh_muc">
                                <option value="" <?= empty($selected_danh_muc) ? 'selected' : '' ?>>Chọn danh mục</option>
                                <?php
                                $sql_danhmuc = "SELECT id_danh_muc, ten_danh_muc FROM danh_muc";
                                $result_danhmuc = $conn->query($sql_danhmuc);
                                if ($result_danhmuc->num_rows > 0) {
                                    while ($row = $result_danhmuc->fetch_assoc()) {
                                        $selected = ($row['id_danh_muc'] == $selected_danh_muc) ? 'selected' : '';
                                        echo "<option value='{$row['id_danh_muc']}' $selected>{$row['ten_danh_muc']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="tentheloai">Tên thể loại</label>
                            <input type="text" id="tentheloai" name="ten_the_loai" value="<?= htmlspecialchars($ten_the_loai) ?>" placeholder="Nhập tên thể loại">
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