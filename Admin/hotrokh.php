<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hổ trợ</title>
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="../Css/hotrokh.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hotrokh">
                <p>Hỗ trợ khách hàng</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table class="bang_ht">
                    <thead>
                        <tr>
                            <th>Mã hỗ trợ</th>
                            <th>Mã khách hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Vấn đề</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('../Home/connect.php');
                        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                        $sql = "SELECT * FROM ho_tro WHERE 1";
                        if (!empty($keyword)) {
                            $sql .= " AND (ma_ht LIKE ? OR ma_kh LIKE ? OR ten_kh LIKE ? OR sdt LIKE ? OR email LIKE ? OR noi_dung LIKE ? OR ngay_tao LIKE ? OR trang_thai LIKE ?)";
                        }
                        // Chuẩn bị câu truy vấn
                        $stmt = $conn->prepare($sql);
                        if (!empty($keyword)) {
                            $search_term = "%$keyword%";
                            $stmt->bind_param("ssssssss", $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                            <td>' . htmlspecialchars($row['ma_ht']) . '</td>
                            <td>' . htmlspecialchars($row['ma_kh']) . '</td>
                            <td>' . htmlspecialchars($row['ten_kh']) . '</td>
                            <td>' . htmlspecialchars($row['sdt']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['noi_dung']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_tao']) . '</td>
                            <td>' . htmlspecialchars($row['trang_thai']) . '</td>
                                    <td>
                            <form action="#" method="post">
                            <input type="hidden" name="id_ht" value="' . htmlspecialchars($row['ma_ht']) . '">
                            <button  class="sua"type="submit"value=""><i class="fa-solid fa-wrench"></i></button>
                            </form>
                            </td>
                            </tr>';
                        }

                        $stmt->close();
                        $conn->close();

                        ?>
                    </tbody>
                </table>
            </div>
            <?php require('../Home/connect.php');
            $id_ht = isset($_POST['id_ht']) ? $_POST['id_ht'] : '';
            $sql = "SELECT * FROM ho_tro where ma_ht ='$id_ht'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <form class="form" method="post" action="../Admin/xuly_hotro.php" onsubmit="return validateForm()">
                <input type="hidden" name="action" value="">
                <label for="ma_ht">Mã hỗ trợ:</label>
                <input type="text" id="ma_ht" name="ma_ht" value="<?php echo htmlspecialchars($row['ma_ht'] ?? ''); ?>">
                <label for="ma_kh">Mã khách hàng:</label>
                <input type="text" id="ma_kh" name="ma_kh" value="<?php echo htmlspecialchars($row['ma_kh'] ?? ''); ?>">
                <input type="hidden" id="ten_kh" name="ten_kh" value="<?php echo htmlspecialchars($row['ten_kh'] ?? ''); ?>">
                <input type="hidden" id="sdt" name="sdt" value="<?php echo htmlspecialchars($row['sdt'] ?? ''); ?>">
                <input type="hidden" id="email" name="email" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>">
                <input type="hidden" id="noi_dung" name="noi_dung" value="<?php echo htmlspecialchars($row['noi_dung'] ?? ''); ?>">
                <input type="hidden" id="ngay_tao" name="ngay_tao" value="<?php echo htmlspecialchars($row['ngay_tao'] ?? ''); ?>">

                <label for="trang_thai">Trạng thái:</label>
                <select name="trang_thai" id="trang_thai">
                    <option value="Chưa xử lý" <?php echo ($row === 'trang_thai') ? 'selected' : ''; ?>>Chưa xử lý</option>
                    <option value="Đã xử lý" <?php echo ($row === 'trang_thai') ? 'selected' : ''; ?>>Đã xử lý</option>

                </select>
        
        </form>
    </div>
        <div class="button-actions">
            <button type="button" class="btn btn-delete" onclick="submitForm('delete')"><i class="fa-solid fa-trash-can"></i></button>
            <button type="button" class="btn btn-update" onclick="submitForm('update')">Cập nhật</button>
        </div>
    </div>
    </div>
    <script>
        function submitForm(action) {
            let confirmMessage = '';

            // Tùy chỉnh thông báo xác nhận theo hành động
            if (action === 'delete') {
                confirmMessage = "Bạn có chắc muốn xóa khách hàng này không?";
            } else if (action === 'update') {
                confirmMessage = "Bạn có chắc muốn cập nhật thông tin khách hàng này không?";
            }
            // Hiển thị hộp thoại xác nhận
            if (confirm(confirmMessage)) {
                document.querySelector('input[name="action"]').value = action;

                document.querySelector('.form').submit();

                function validateForm() {
                    const inputs = document.querySelectorAll('.form input[type="text"]');
                    for (let input of inputs) {
                        if (!input.value.trim()) {
                            alert("Form chưa có dữ liệu, vui lòng điền đầy đủ thông tin!");
                            return false;
                        }
                    }
                }
                return true;
            }


        }
    </script>
</body>

</html>