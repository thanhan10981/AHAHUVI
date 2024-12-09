<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dsdanhmuc.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách nhà cung cấp</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <?php
        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';
        $sql_count = "SELECT COUNT(*) AS total_ncc FROM nha_cung_cap";

        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_count .= " WHERE ten_nhacungcap LIKE '%$search_keyword%'";
        }

        $result_count = $conn->query($sql_count);
        if ($result_count) {
            $row_count = $result_count->fetch_assoc();
            $total_ncc = $row_count['total_ncc'];
        } else {
            $total_ncc = 0;
        }

        if (!$result_count) {
            die("Lỗi truy vấn: " . $conn->error);
        }
        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';
        $sql_nhacungcap = "SELECT id_nhacungcap, ten_nhacungcap FROM nha_cung_cap";

        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_nhacungcap .= " WHERE ten_nhacungcap LIKE '%$search_keyword%'";
        }

        $result_nhacungcap = $conn->query($sql_nhacungcap);
        if (!$result_nhacungcap) {
            die("Truy vấn nhà cung cấp lỗi: " . $conn->error);
        }


        if (isset($_GET['edit_id'])) {
            $id_ncc = $_GET['edit_id']; // Lấy ID danh mục từ URL

            // Truy vấn để lấy thông tin danh mục
            $sql = "SELECT * FROM nha_cung_cap WHERE id_nhacungcap = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_ncc);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $id_ncc = $row['id_nhacungcap'];
            $ten_ncc = $row['ten_nhacungcap'];
        } else {
            // Nếu không có danh mục nào được chọn, đặt giá trị mặc định cho các trường nhập liệu
            $id_ncc = '';
            $ten_ncc = '';
        }

        // xử lý sau khi nhấn cập nhật
        if (isset($_POST['update_category'])) {
            $id_ncc = $_POST['id_nhacungcap'];
            $ten_ncc = $_POST['ten_nhacungcap'];

            // Truy vấn cập nhật danh mục
            if (empty($id_ncc) || empty($ten_ncc)) {
                echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
            } else {
                $sql_update = "UPDATE nha_cung_cap SET ten_nhacungcap = ? WHERE id_nhacungcap = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $ten_ncc, $id_ncc);
            
                if ($stmt_update->execute()) {
                    echo "<script>alert('Nhà cung cấp đã được cập nhật thành công!');</script>";
                    echo "<script>window.location.href = 'ds_ncc.php';</script>";
                } else {
                    echo "<script>alert('Lỗi khi cập nhật nhà cung cấp: " . $conn->error . "');</script>";
                }
            
                $stmt_update->close();
            }  
        }

        if (isset($_GET['delete_id'])) {
            $id_nha_cung_cap = $_GET['delete_id']; // ID nhà cung cấp cần xóa
        
            // Bước 1: Xóa sản phẩm trong giỏ hàng liên quan đến nhà cung cấp
            $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                           INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                           WHERE sp.id_ncc = ?";
            $stmt_xoagh = $conn->prepare($sql_xoa_gh);
            $stmt_xoagh->bind_param("i", $id_nha_cung_cap);
            if (!$stmt_xoagh->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                $stmt_xoagh->close();
                exit;
            }
            $stmt_xoagh->close();
        
            // Bước 2: Xóa sản phẩm thuộc nhà cung cấp
            $sql_xoa_sp = "DELETE FROM san_pham WHERE id_ncc = ?";
            $stmt_xoasp = $conn->prepare($sql_xoa_sp);
            $stmt_xoasp->bind_param("i", $id_nha_cung_cap);
            if (!$stmt_xoasp->execute()) {
                echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                $stmt_xoasp->close();
                exit;
            }
            $stmt_xoasp->close();
        
            // Bước 3: Xóa nhà cung cấp
            $sql_xoa_ncc = "DELETE FROM nha_cung_cap WHERE id_nhacungcap = ?";
            $stmt_xoa_ncc = $conn->prepare($sql_xoa_ncc);
            $stmt_xoa_ncc->bind_param("i", $id_nha_cung_cap);
            if ($stmt_xoa_ncc->execute()) {
                echo "<script type='text/javascript'>
                alert('Nhà cung cấp và các dữ liệu liên quan đã được xóa thành công.');
                window.location.href = 'ds_ncc.php';
              </script>";
            } else {
                echo "<script type='text/javascript'>
                alert('Lỗi khi xóa nhà cung cấp: " . $conn->error . "');
              </script>";
            }
            $stmt_xoa_ncc->close();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
            if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                $delete_ids = $_POST['delete_ids'];
                $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
                $types = str_repeat("i", count($delete_ids)); // Tạo chuỗi kiểu dữ liệu
        
                // Bước 1: Xóa sản phẩm trong giỏ hàng liên quan đến các nhà cung cấp
                $sql_xoa_gh = "DELETE gh FROM san_pham_gio_hang gh
                               INNER JOIN san_pham sp ON gh.id_sp = sp.id_sp
                               WHERE sp.id_ncc IN ($placeholders)";
                $stmt_xoagh = $conn->prepare($sql_xoa_gh);
                $stmt_xoagh->bind_param($types, ...$delete_ids);
                if (!$stmt_xoagh->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm trong giỏ hàng: " . $conn->error . "');</script>";
                    $stmt_xoagh->close();
                    exit;
                }
                $stmt_xoagh->close();
        
                // Bước 2: Xóa sản phẩm thuộc các nhà cung cấp
                $sql_xoa_sp = "DELETE FROM san_pham WHERE id_ncc IN ($placeholders)";
                $stmt_xoasp = $conn->prepare($sql_xoa_sp);
                $stmt_xoasp->bind_param($types, ...$delete_ids);
                if (!$stmt_xoasp->execute()) {
                    echo "<script>alert('Lỗi khi xóa sản phẩm: " . $conn->error . "');</script>";
                    $stmt_xoasp->close();
                    exit;
                }
                $stmt_xoasp->close();
        
                // Bước 3: Xóa các nhà cung cấp
                $sql_xoa_ncc = "DELETE FROM nha_cung_cap WHERE id_nhacungcap IN ($placeholders)";
                $stmt_xoa_ncc = $conn->prepare($sql_xoa_ncc);
                $stmt_xoa_ncc->bind_param($types, ...$delete_ids);
                if ($stmt_xoa_ncc->execute()) {
                    echo "<script>alert('Đã xóa các nhà cung cấp được chọn!');</script>";
                    echo "<script>location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                } else {
                    echo "<script>alert('Lỗi khi xóa nhà cung cấp: {$stmt_xoa_ncc->error}');</script>";
                }
                $stmt_xoa_ncc->close();
            } else {
                echo "<script>alert('Vui lòng chọn ít nhất một nhà cung cấp để xóa!');</script>";
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
            $ten_ncc = $_POST['ten_nhacungcap'];
            
            if (empty($ten_ncc)) {
                echo "<script>alert('Vui lòng nhập tên nhà cung cấp!');</script>";
            } else {
                $sql_insert = "INSERT INTO nha_cung_cap (ten_nhacungcap) VALUES (?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("s", $ten_ncc);
                
                if ($stmt_insert->execute()) {
                    echo "<script>alert('Nhà cung cấp đã được thêm thành công!');</script>";
                    echo "<script>window.location.href = 'ds_ncc.php';</script>";
                } else {
                    echo "<script>alert('Lỗi khi thêm nhà cung cấp: " . $conn->error . "');</script>";
                    error_log("Error in SQL query: " . $conn->error);  // Log SQL error
                }
        
                $stmt_insert->close();
            }
        }
        
        
        ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách nhà cung cấp</p>
                <form action="" method="POST" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="soluongdm"><?= $total_ncc ?> Nhà cung cấp</div>
            <form method="POST" action="">
                <div class="danhmuctraiphai">
                    <div class="danhmuctrai">
                        <table class="bang_sp">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                                    <th>MNCC</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Cài đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_nhacungcap->num_rows > 0) {
                                    while ($row = $result_nhacungcap->fetch_assoc()) {
                                        echo "
                            <tr>
                                <td><input type='checkbox' class='row-checkbox' name='delete_ids[]' value='{$row['id_nhacungcap']}' onclick='highlightRow(this)'></td>
                                <td>{$row['id_nhacungcap']}</td>
                                <td>{$row['ten_nhacungcap']}</td>
                               <td>
                                <a href='?edit_id={$row['id_nhacungcap']}'>
                                <i class='fa-solid fa-screwdriver-wrench'></i>
                                </a>
                                <a href='?delete_id={$row['id_nhacungcap']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa thể loại này?\")'>
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
                            <label for="mncc">Mã nhà cung cấp (MNCC)</label>
                            <input type="text" id="mncc" name="id_nhacungcap" value="<?= $id_ncc ?>" placeholder="Nhập mã nhà cung cấp">
                        </div>
                        <div class="nhom-dau-vao">
                            <label for="tenncc">Tên nhà cung cấp</label>
                            <input type="text" id="tenncc" name="ten_nhacungcap" value="<?= $ten_ncc ?>" placeholder="Nhập tên nhà cung cấp">
                        </div>
                        <div class="nut-bieu-mau">
                            <button type="submit" name="update_category">CẬP NHẬT</button>
                            <button type="submit" name="add_category">THÊM</button>
                            <button type="submit" name="delete_selected">XÓA</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <script src="../Js/dssp_ad.js"></script>
</body>

</html>