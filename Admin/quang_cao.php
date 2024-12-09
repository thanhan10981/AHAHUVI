<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="../Css/quang_cao_ad.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Quản lý quảng cáo</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>DANH SÁCH ẢNH QUẢNG CÁO</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="table-container">
                <table class="bang_sp">
                    <thead>
                        <tr>
                            <th>MBanner</th>
                            <th>Ảnh</th>
                            <th>Vị Trí</th>
                            <th>Ngày Tạo</th>
                            <th>Ngày BĐ</th>
                            <th>Ngày KT</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('../Home/connect.php');
                        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                        $sql = "SELECT * FROM quang_cao WHERE 1";
                        if (!empty($keyword)) {
                            $sql .= " AND (id_quang_cao LIKE ? OR ten LIKE ? OR vi_tri LIKE ? OR ngay_tao LIKE ? OR ngay_bat_dau LIKE ? OR ngay_ket_thuc LIKE ?)";
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
                            <td>' . htmlspecialchars($row['id_quang_cao']) . '</td>
                            <td class="anh"><img src="../IMG/' . htmlspecialchars($row['ten']) . '" alt="ảnh"></td>
                            <td>' . htmlspecialchars($row['vi_tri']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_tao']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_bat_dau']) . '</td>
                            <td>' . htmlspecialchars($row['ngay_ket_thuc']) . '</td>
                            <td>
                            <form action="#" method="post">
                            <input type="hidden" name="id" value="' . htmlspecialchars($row['id_quang_cao']) . '">
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
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $sql = "SELECT * FROM quang_cao where id_quang_cao ='$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <form class="form" method="post" action="../Admin/xu_ly_quang_cao.php"onsubmit="return validateForm()">
                <div class="form-row">
                <input type="hidden" name="action" value="">
                    <label for="mbanner">MBanner</label>
                    <input type="text" id="mbanner" name="mbanner" value="<?php echo htmlspecialchars($row['id_quang_cao'] ?? ''); ?>">
                </div>

                <div class="form-row">
                    <label for="anh">Ảnh</label>
                    <input type="file" id="anh" name="anh">
                    <input type="hidden" name="anh_cu" value="<?php echo htmlspecialchars($row['id_quang_cao'] ?? ''); ?>">
                </div>
                <div class="form-row">
                    <label for="vi_tri">Vị Trí</label>
                    <select id="vi_tri" name="vi_tri">
                        <?php if ($row['vi_tri'] == "") {
                            echo '<option>Chọn vị trí</option>';
                            echo '<option>anh-quang_cao-chinh</option>';
                            echo '<option>anh-quang_cao-giam_gia1</option>';
                            echo '<option>anh-quang_cao-giam_gia2</option>';
                            echo '<option>header</option>';
                        } else {
                            echo '<option>' . $row['vi_tri'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="ngay_tao">Ngày Tạo</label>
                    <input type="date" id="ngay_tao" name="ngay_tao" value="<?php echo htmlspecialchars($row['ngay_tao'] ?? ''); ?>">
                </div>
                <div class="form-row">
                    <label for="ngay_bd">Ngày BĐ</label>
                    <input type="date" id="ngay_bd" name="ngay_bd" value="<?php echo htmlspecialchars($row['ngay_bat_dau'] ?? ''); ?>">
                </div>
                <div class="form-row">
                    <label for="ngay_kt">Ngày KT</label>
                    <input type="date" id="ngay_kt" name="ngay_kt" value="<?php echo htmlspecialchars($row['ngay_ket_thuc'] ?? ''); ?>">
                </div>
                <div class="form-row">
                    <label for="trang_thai">Trạng Thái</label>
                    <select id="trang_thai" name="trang_thai">
                        <?php
                       date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $today = date('Y-m-d');
                        $ngayKetThuc = $row['ngay_ket_thuc'] ?? '';
                        if (!empty($ngayKetThuc) && $ngayKetThuc < $today) {
                            echo '<option value="hien_thi">Hiển Thị</option>';
                            echo '<option value="da_ket_thuc" selected>Đã Kết Thúc</option>';
                        } else {
                            echo '<option value="hien_thi" selected>Hiển Thị</option>';
                            echo '<option value="da_ket_thuc">Đã Kết Thúc</option>';
                        }
                        ?>
                    </select>
                </div>
            </form>

            <div class="buttons">
                <button type="button" class="btn-delete"onclick="submitForm('delete')">
                    <i class="fa-solid fa-trash-can"></i> Xóa
                </button>
                <button type="button" class="btn-update"onclick="submitForm('update')">Cập Nhật</button>
                <button type="button" class="btn-add"onclick="submitForm('add')">Thêm</button>
            </div>
        </div>
    </div>
    <script>
    function submitForm(action) {
        let confirmMessage = '';
        
    
        if (action === 'delete') {
            confirmMessage = "Bạn có chắc chắn muốn xóa ảnh này không?";
        } else if (action === 'update') {
            confirmMessage = "Bạn có chắc chắn muốn cập nhật ảnh không?";
        } else if (action === 'add') {
            confirmMessage = "Bạn có chắc chắn muốn thêm ảnh mới không?";
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