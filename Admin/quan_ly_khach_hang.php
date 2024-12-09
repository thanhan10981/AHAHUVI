<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="../Css/quan_ly_khach_hang.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>QUẢN LÝ KHÁCH HÀNG</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table class="bang_sp">
                    <thead>
                        <tr>
                            <th>MKH</th>
                            <th>Tên</th>
                            <th>Giới Tính</th>
                            <th>Ngày Sinh</th>
                            <th>SDT</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('../Home/connect.php');
                        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                        $sql = "SELECT * FROM khach_hang WHERE 1";
                        if (!empty($keyword)) {
                            $sql .= " AND (mkh LIKE ? OR ten_kh LIKE ? OR gioi_tinh LIKE ? OR email LIKE ? OR sdt LIKE ? OR dia_chi LIKE ?)";
                        }
                        // Chuẩn bị câu truy vấn
                        $stmt = $conn->prepare($sql);
                        if (!empty($keyword)) {
                            $search_term = "%$keyword%";
                            $stmt->bind_param("ssssss", $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                            <td>' . htmlspecialchars($row['mkh']) . '</td>
                            <td>' . htmlspecialchars($row['ten_kh']) . '</td>
                            <td>' . htmlspecialchars($row['gioi_tinh']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_sinh']) . '</td>
                            <td>' . htmlspecialchars($row['sdt']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['dia_chi']) . '</td>
                            <td>
                            <form action="#" method="post">
                            <input type="hidden" name="id_kh" value="' . htmlspecialchars($row['mkh']) . '">
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
            $id_kh = isset($_POST['id_kh']) ? $_POST['id_kh'] : '';
            $sql = "SELECT * FROM khach_hang where mkh ='$id_kh'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <form class="form" method="post" action="../Admin/xu_ly_kh.php" onsubmit="return validateForm()">
                <input type="hidden" name="action" value="">

                <label>Mã Khách Hàng:</label>
                <input type="text" name="makh" value="<?php echo htmlspecialchars($row['mkh'] ?? ''); ?>">

                <label>Tên:</label>
                <input type="text" name="tenkh" value="<?php echo htmlspecialchars($row['ten_kh'] ?? ''); ?>">

                <label>Giới Tính:</label>
                <input type="text" name="gioitinh" value="<?php echo htmlspecialchars($row['gioi_tinh'] ?? ''); ?>">

                <label>Ngày Sinh:</label>
                <input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($row['ngay_sinh'] ?? ''); ?>">

                <label>SDT:</label>
                <input type="text" name="sdt" value="<?php echo htmlspecialchars($row['sdt'] ?? ''); ?>">

                <label>Email:</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>">

                <label>Địa Chỉ:</label>
                <input type="text" name="diachi" value="<?php echo htmlspecialchars($row['dia_chi'] ?? ''); ?>">
            </form>

            <div class="section">
                <div class="section-header">
                    <h2><i class="fa-solid fa-dolly"></i> Đơn Hàng Đã Đặt</h2>
                </div>
                <table class="table">
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                    <?php require('../Home/connect.php');
                    $id_kh = isset($_POST['id_kh']) ? $_POST['id_kh'] : '';
                    $sql = "SELECT * FROM don_hang where id_kh ='$id_kh'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo ' <tr>
                        <td>' . htmlspecialchars($row['id_don_hang']) . '</td>
                        <td>' .number_format(htmlspecialchars($row['tong_tien'])). 'đ</td>
                         <td>' . htmlspecialchars($row['trang_thai']) . '</td>
                        </tr>';
                        $i++;
                    }

                    echo ' </table>
                <div class="total">Tổng Tất Cả Đơn Hàng: ' . $i . '</div> '; ?>
            </div>
            <div class="buttons">
                <button type="button" class="btn-delete" onclick="submitForm('delete')">
                    <i class="fa-solid fa-trash-can"></i> Xóa
                </button>
                <button type="button" class="btn" onclick="submitForm('update')">Cập nhật</button>

            </div>

            <script>
                function submitForm(action) {
                    let confirmMessage = '';

                    // Tùy chỉnh thông báo xác nhận theo hành động
                    if (action === 'delete') {
                        confirmMessage = "Bạn có chắc chắn muốn xóa khách hàng này không?";
                    } else if (action === 'update') {
                        confirmMessage = "Bạn có chắc chắn muốn cập nhật thông tin khách hàng không?";
                    }

                    // Hiển thị hộp thoại xác nhận
                    if (confirm(confirmMessage)) {

                        document.querySelector('input[name="action"]').value = action;
                        if (validateForm()) {
                            document.querySelector('.form').submit();
                        }
                    }

                    function validateForm() {
                        const inputs = document.querySelectorAll('.form input[type="text"], .form input[type="email"], .form input[type="date"]');
                        for (let input of inputs) {
                            if (!input.value.trim()) {
                                alert("Form chưa có dữ liệu, vui lòng điền đầy đủ thông tin!");
                                return false;
                            }
                        }
                        return true;
                    }
                }
            </script>

        </div>
    </div>
</body>

</html>