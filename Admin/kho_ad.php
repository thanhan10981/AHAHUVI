<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dsdanhmuc.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Danh sách Kho</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <?php
        $id_danh_muc_da_chon = isset($_POST['id_danh_muc']) ? $_POST['id_danh_muc'] : '';
        $ten_sp = '';
        $sl = '';
        // Lấy từ khóa tìm kiếm từ form (nếu có)
        $search_keyword = isset($_POST['search_keyword']) ? trim($_POST['search_keyword']) : '';

        // Đếm tổng số sản phẩm trong kho
        $sql_count = "SELECT COUNT(*) AS total_sp FROM kho k
              JOIN san_pham sp ON k.id_sp = sp.id_sp";

        if (!empty($search_keyword)) {
            $search_keyword = $conn->real_escape_string($search_keyword);
            $sql_count .= " WHERE sp.ten_sp LIKE '%$search_keyword%'";
        }

        $result_count = $conn->query($sql_count);
        if ($result_count) {
            $row_count = $result_count->fetch_assoc();
            $total_sp = $row_count['total_sp'];
        } else {
            $total_sp = 0;
        }

        if (!$result_count) {
            die("Lỗi truy vấn: " . $conn->error);
        }

        // Lấy danh sách sản phẩm trong kho
        $sql_sanpham = "SELECT k.id_sp, sp.ten_sp, k.sl FROM kho k
                JOIN san_pham sp ON k.id_sp = sp.id_sp";

        if (!empty($search_keyword)) {
            $sql_sanpham .= " WHERE sp.ten_sp LIKE '%$search_keyword%'";
        }

        $result_sanpham = $conn->query($sql_sanpham);
        if (!$result_sanpham) {
            die("Truy vấn sản phẩm lỗi: " . $conn->error);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
            $id_danh_muc = isset($_POST['id_danh_muc']) ? intval($_POST['id_danh_muc']) : null;
            $id_the_loai = isset($_POST['id_the_loai']) ? intval($_POST['id_the_loai']) : null;
            $id_sp = isset($_POST['id_sp']) ? intval($_POST['id_sp']) : null;
            $sl = isset($_POST['sl']) ? intval($_POST['sl']) : null;

            if (empty($sl) || $sl <= 0) {
                echo "<script>alert('Vui lòng nhập số lượng hợp lệ!');</script>";
            } else {
                if ($id_sp) {
                    // Thêm số lượng cho sản phẩm cụ thể
                    $sql_check = "SELECT * FROM kho WHERE id_sp = ?";
                    $stmt_check = $conn->prepare($sql_check);
                    $stmt_check->bind_param("i", $id_sp);
                    $stmt_check->execute();
                    $result_check = $stmt_check->get_result();

                    if ($result_check->num_rows > 0) {
                        // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                        $sql_update = "UPDATE kho SET sl = sl + ? WHERE id_sp = ?";
                        $stmt_update = $conn->prepare($sql_update);
                        $stmt_update->bind_param("ii", $sl, $id_sp);
                        $stmt_update->execute();
                        $stmt_update->close();
                        echo "<script>alert('Số lượng đã được cập nhật cho sản phẩm có mã $id_sp!');</script>";
                        echo "<script>window.location.href = 'kho_ad.php';</script>";
                        exit();
                    } else {
                        // Nếu sản phẩm chưa tồn tại, chèn mới
                        $sql_insert = "INSERT INTO kho (id_sp, sl) VALUES (?, ?)";
                        $stmt_insert = $conn->prepare($sql_insert);
                        $stmt_insert->bind_param("ii", $id_sp, $sl);
                        $stmt_insert->execute();
                        $stmt_insert->close();
                        echo "<script>alert('Sản phẩm có mã $id_sp đã được thêm vào kho!');</script>";
                        echo "<script>window.location.href = 'kho_ad.php';</script>";
                        exit();
                    }
                } elseif ($id_danh_muc && $id_the_loai) {
                    // Thêm số lượng cho tất cả sản phẩm thuộc danh mục và thể loại
                    $sql_select = "SELECT id_sp FROM san_pham WHERE id_danh_muc = ? AND id_the_loai = ?";
                    $stmt_select = $conn->prepare($sql_select);
                    $stmt_select->bind_param("ii", $id_danh_muc, $id_the_loai);

                    if ($stmt_select->execute()) {
                        $result_select = $stmt_select->get_result();

                        if ($result_select->num_rows > 0) {
                            while ($row = $result_select->fetch_assoc()) {
                                $id_sp_to_update = $row['id_sp'];

                                // Kiểm tra xem sản phẩm đã có trong kho chưa
                                $sql_check = "SELECT * FROM kho WHERE id_sp = ?";
                                $stmt_check = $conn->prepare($sql_check);
                                $stmt_check->bind_param("i", $id_sp_to_update);
                                $stmt_check->execute();
                                $result_check = $stmt_check->get_result();

                                if ($result_check->num_rows > 0) {
                                    // Nếu đã tồn tại, cập nhật số lượng
                                    $sql_update = "UPDATE kho SET sl = sl + ? WHERE id_sp = ?";
                                    $stmt_update = $conn->prepare($sql_update);
                                    $stmt_update->bind_param("ii", $sl, $id_sp_to_update);
                                    $stmt_update->execute();
                                    $stmt_update->close();
                                } else {
                                    // Nếu chưa tồn tại, chèn mới
                                    $sql_insert = "INSERT INTO kho (id_sp, sl) VALUES (?, ?)";
                                    $stmt_insert = $conn->prepare($sql_insert);
                                    $stmt_insert->bind_param("ii", $id_sp_to_update, $sl);
                                    $stmt_insert->execute();
                                    $stmt_insert->close();
                                }
                            }
                            echo "<script>alert('Số lượng đã được cập nhật hoặc thêm mới cho tất cả sản phẩm thuộc danh mục và thể loại đã chọn!');</script>";
                            echo "<script>window.location.href = 'kho_ad.php';</script>";
                            exit();
                        } else {
                            echo "<script>alert('Không có sản phẩm nào thuộc danh mục và thể loại đã chọn!');</script>";
                            echo "<script>window.location.href = 'kho_ad.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Lỗi khi truy vấn sản phẩm: " . $conn->error . "');</script>";
                    }

                    $stmt_select->close();
                } else {
                    echo "<script>alert('Vui lòng chọn danh mục, thể loại hoặc mã sản phẩm!');</script>";
                }
            }
        }

        // cập nhật
        if (isset($_GET['edit_id'])) {
            $id_sp = intval($_GET['edit_id']); // Lấy ID sản phẩm từ URL, đảm bảo định dạng số nguyên

            // Truy vấn để lấy thông tin sản phẩm, danh mục, thể loại
            $sql = "SELECT sp.id_sp, sp.ten_sp, sp.id_danh_muc, sp.id_the_loai, k.sl, dm.ten_danh_muc, tl.ten_the_loai 
                    FROM kho k
                    JOIN san_pham sp ON k.id_sp = sp.id_sp
                    JOIN danh_muc dm ON sp.id_danh_muc = dm.id_danh_muc
                    JOIN the_loai tl ON sp.id_the_loai = tl.id_the_loai
                    WHERE k.id_sp = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_sp);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Gán các giá trị vào biến để hiển thị lại trong form
                $id_sp = $row['id_sp'];
                $ten_sp = $row['ten_sp'];
                $sl = $row['sl'];
                $id_danh_muc = $row['id_danh_muc'];
                $id_the_loai = $row['id_the_loai'];
                $ten_danh_muc = $row['ten_danh_muc'];
                $ten_the_loai = $row['ten_the_loai'];
            } else {
                echo "<script>alert('Không tìm thấy sản phẩm cần chỉnh sửa!');</script>";
            }
        }

        if (isset($_POST['update_category'])) {
            // Lấy dữ liệu từ form
            $id_sp = intval($_GET['edit_id']); // Lấy ID sản phẩm từ URL
            $sl = isset($_POST['sl']) ? intval($_POST['sl']) : null; // Lấy số lượng từ form
            
            // Kiểm tra nếu số lượng nhỏ hơn 0 hoặc không hợp lệ
            if ($sl === null || $sl < 0) {
                echo "<script>alert('Số lượng phải là số nguyên dương!');</script>";
            } else {
                // Cập nhật cơ sở dữ liệu
                $sql_update = "UPDATE kho SET sl = ? WHERE id_sp = ?";
                $stmt_update = $conn->prepare($sql_update);
        
                if ($stmt_update) {
                    $stmt_update->bind_param("ii", $sl, $id_sp); // Đảm bảo kiểu dữ liệu chính xác
                    if ($stmt_update->execute()) {
                        echo "<script>alert('Số lượng đã được cập nhật thành công!');</script>";
                        echo "<script>window.location.href = 'kho_ad.php';</script>";
                    } else {
                        echo "<script>alert('Lỗi khi cập nhật: " . $stmt_update->error . "');</script>";
                    }
                    $stmt_update->close();
                } else {
                    echo "<script>alert('Lỗi khi chuẩn bị truy vấn: " . $conn->error . "');</script>";
                }
            }
        }
        
        if (isset($_GET['delete_id'])) {
            $id_sp = $_GET['delete_id']; // ID kho cần xóa
        
            // Xóa kho
            $sql_xoa_kho = "DELETE FROM kho WHERE id_sp = ?";
            $stmt_xoa_kho = $conn->prepare($sql_xoa_kho);
            $stmt_xoa_kho->bind_param("i", $id_sp);
            if ($stmt_xoa_kho->execute()) {
                echo "<script type='text/javascript'>
                    alert('Kho đã được xóa thành công.');
                    window.location.href = 'kho_ad.php';
                </script>";
            } else {
                echo "<script type='text/javascript'>
                    alert('Lỗi khi xóa kho: " . $conn->error . "');
                </script>";
            }
            $stmt_xoa_kho->close();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
            if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                $delete_ids = $_POST['delete_ids'];
                $placeholders = implode(',', array_fill(0, count($delete_ids), '?'));
                $types = str_repeat("i", count($delete_ids)); // Chuỗi kiểu dữ liệu
        
                // Xóa các kho được chọn
                $sql_xoa_kho = "DELETE FROM kho WHERE id_sp IN ($placeholders)";
                $stmt_xoa_kho = $conn->prepare($sql_xoa_kho);
                $stmt_xoa_kho->bind_param($types, ...$delete_ids);
                if ($stmt_xoa_kho->execute()) {
                    echo "<script>alert('Đã xóa các kho được chọn thành công!');</script>";
                    echo "<script>location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                } else {
                    echo "<script>alert('Lỗi khi xóa kho: {$stmt_xoa_kho->error}');</script>";
                }
                $stmt_xoa_kho->close();
            } else {
                echo "<script>alert('Vui lòng chọn ít nhất một kho để xóa!');</script>";
            }
        }
        ?>
        
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Danh sách kho</p>
                <form action="" method="POST" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm..." value="<?= isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="soluongdm"><?= $total_sp ?> sản phẩm</div>
            <form method="POST" action="">
                <div class="danhmuctraiphai">
                    <div class="danhmuctrai">
                        <table class="bang_sp">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                                    <th>MSP</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Cài đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_sanpham->num_rows > 0) {
                                    while ($row = $result_sanpham->fetch_assoc()) {
                                        echo "
                            <tr>
                                <td><input type='checkbox' class='row-checkbox' name='delete_ids[]' value='{$row['id_sp']}' onclick='highlightRow(this)'></td>
                                <td>{$row['id_sp']}</td>
                                <td>{$row['ten_sp']}</td>
                                <td>{$row['sl']}</td>
                                <td>
                                <a href='?edit_id={$row['id_sp']}'>
                                <i class='fa-solid fa-screwdriver-wrench'></i>
                                </a>
                                <a href='?delete_id={$row['id_sp']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa kho của sản phẩm này?\")'>
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
                            <label for="danh_muc">Danh mục</label>
                            <select id="danh_muc" name="id_danh_muc" onchange="this.form.submit()">
                            <option value=""><?= empty($ten_danh_muc) ? 'Chọn danh mục' : $ten_danh_muc ?></option>
                                <?php
                                // Lấy danh sách danh mục từ cơ sở dữ liệu
                                $sql_danh_muc = "SELECT id_danh_muc, ten_danh_muc FROM danh_muc";
                                $result_danh_muc = $conn->query($sql_danh_muc);
                                if ($result_danh_muc->num_rows > 0) {
                                    while ($row = $result_danh_muc->fetch_assoc()) {
                                        // Kiểm tra xem danh mục hiện tại có được chọn hay không
                                        $selected = (isset($_POST['id_danh_muc']) && $_POST['id_danh_muc'] == $row['id_danh_muc']) ? 'selected' : '';
                                        echo "<option value='{$row['id_danh_muc']}' $selected>{$row['ten_danh_muc']}</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <div class="nhom-dau-vao">
                            <label for="the_loai">Thể loại</label>
                            <select id="the_loai" name="id_the_loai" onchange="this.form.submit()">
                            <option value=""><?= empty($ten_the_loai) ? 'Chọn danh mục' : $ten_the_loai ?></option>
                                <?php
                                // Nếu danh mục được chọn, lấy danh sách thể loại tương ứng
                                if (isset($_POST['id_danh_muc']) && !empty($_POST['id_danh_muc'])) {
                                    $id_danh_muc = intval($_POST['id_danh_muc']);
                                    $sql_theloai = "SELECT id_the_loai, ten_the_loai FROM the_loai WHERE id_danh_muc = $id_danh_muc";
                                    $result_theloai = $conn->query($sql_theloai);
                                    if ($result_theloai->num_rows > 0) {
                                        while ($row = $result_theloai->fetch_assoc()) {
                                            $selected = (isset($_POST['id_the_loai']) && $_POST['id_the_loai'] == $row['id_the_loai']) ? 'selected' : '';
                                            echo "<option value='{$row['id_the_loai']}' $selected>{$row['ten_the_loai']}</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="nhom-dau-vao">
        <label for="msp">Mã sản phẩm (MSP)</label>
        <select id="msp" name="id_sp" onchange="updateProductName()">
            <option value=""><?= empty($id_sp) ? 'Chọn danh mục' : $id_sp ?></option>
            <?php
            // Lấy danh sách sản phẩm tương ứng
            $sql_sp = "SELECT id_sp, ten_sp FROM san_pham WHERE 1=1";

            if (isset($_POST['id_danh_muc']) && !empty($_POST['id_danh_muc'])) {
                $id_danh_muc = intval($_POST['id_danh_muc']);
                $sql_sp .= " AND id_danh_muc = $id_danh_muc";
            }

            if (isset($_POST['id_the_loai']) && !empty($_POST['id_the_loai'])) {
                $id_the_loai = intval($_POST['id_the_loai']);
                $sql_sp .= " AND id_the_loai = $id_the_loai";
            }

            $result_sp = $conn->query($sql_sp);
            if ($result_sp->num_rows > 0) {
                while ($row = $result_sp->fetch_assoc()) {
                    $selected = (isset($_POST['id_sp']) && $_POST['id_sp'] == $row['id_sp']) ? 'selected' : '';
                    echo "<option value='{$row['id_sp']}' data-ten-sp='{$row['ten_sp']}' $selected>{$row['ten_sp']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="nhom-dau-vao">
        <label for="tensp">Tên sản phẩm</label>
        <input type="text" id="tensp" name="ten_sp" value="<?= $ten_sp ?>" placeholder="Nhập tên sản phẩm">
    </div>

    <div class="nhom-dau-vao">
        <label for="soluong">Số lượng</label>
        <input type="text" id="soluong" name="sl" value="<?= $sl ?>" placeholder="Nhập số lượng">
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