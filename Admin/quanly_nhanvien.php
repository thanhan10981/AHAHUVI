<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="../Css/quanly_nhanvien.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hotro">
                <p>QUẢN LÝ NHÂN VIÊN</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table class="bang_nv">
                    <thead>
                        <tr>
                            <th>Mã nhân viên</th>
                            <th>Tên nhân viên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Ngày tạo</th>
                            <th>Địa chỉ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('../Home/connect.php');
                        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                        $sql = "SELECT * FROM nhan_vien WHERE 1";
                        if (!empty($keyword)) {
                            $sql .= " AND (mnv LIKE ? OR ten_nhan_vien LIKE ? OR email LIKE ? OR sdt LIKE ? OR ngay_tao LIKE ? OR dia_chi LIKE ?)";
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
                            <td>' . htmlspecialchars($row['mnv']) . '</td>
                            <td>' . htmlspecialchars($row['ten_nhan_vien']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['sdt']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_tao']) . '</td>
                            <td>' . htmlspecialchars($row['dia_chi']) . '</td>
                         <td>
                            <form action="#" method="post">
                            <input type="hidden" name="id_nv" value="' . htmlspecialchars($row['mnv']) . '">
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
            $id_nv = isset($_POST['id_nv']) ? $_POST['id_nv'] : '';
            $sql = "SELECT * FROM nhan_vien where mnv ='$id_nv'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <form class="form" method="post" action="../Admin/xuly_nhanvien.php"onsubmit="return validateForm()">
            <input type="hidden" name="action" value="">
    <div>
        <label for="mnv">Mã nhân viên:</label>
        <input type="text" id="mnv" name="mnv" value="<?php echo htmlspecialchars($row['mnv'] ?? ''); ?>">
    </div>
    <div>
        <label for="ten_nhan_vien">Tên:</label>
        <input type="text" id="ten_nhan_vien" name="ten_nhan_vien" value="<?php echo htmlspecialchars($row['ten_nhan_vien'] ?? ''); ?>">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>">
    </div>
    <div>
        <label for="sdt">SĐT:</label>
        <input type="text" id="sdt" name="sdt" value="<?php echo htmlspecialchars($row['sdt'] ?? ''); ?>">
    </div>
    <div>
        <label for="ngay_tao">Ngày tạo:</label>
        <input type="date" id="ngay_tao" name="ngay_tao" value="<?php echo htmlspecialchars($row['ngay_tao'] ?? ''); ?>">
    </div>
    <div>
        <label for="dia_chi">Địa chỉ:</label>
        <input type="text" name="dia_chi" id="dia_chi" value="<?php echo htmlspecialchars($row['dia_chi'] ?? ''); ?>">
    </div>
    
</form>
<div class="button-actions">
        <button type="button" class="btn btn-delete" onclick="submitForm('delete')"><i class="fa-solid fa-trash-can"></i></button>
        <button type="button" class="btn btn-update" onclick="submitForm('update')">Cập nhật</button>
        <button type="submit" class="btn btn-add" onclick="submitForm('add')">Thêm</button>
    </div>

        </div>
    </div>

    <script>
    function submitForm(action) {
        let confirmMessage = '';
        
        // Tùy chỉnh thông báo xác nhận theo hành động
        if (action === 'delete') {
            confirmMessage = "Bạn có chắc muốn xóa nhân viên này không?";
        } else if (action === 'update') {
            confirmMessage = "Bạn có chắc muốn cập nhật thông tin nhân viên này không?";
        } else if (action === 'add') {
            confirmMessage = "Bạn có chắc muốn thêm nhân viên mới không?";
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
</body>

</html>