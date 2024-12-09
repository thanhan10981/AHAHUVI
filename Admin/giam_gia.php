<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Voucher</title>
    <link rel="stylesheet" href="../Css/giam_gia.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="than">
        <?php
        require("../Admin/menu.php");
        require("../Home/connect.php");

        // Xử lý các hành động (Thêm, Cập nhật, Xóa)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            $id = isset($_POST['id_giam_gia']) ? $_POST['id_giam_gia'] : null;
            $ma = isset($_POST['ma']) ? $_POST['ma'] : '';
            $phan_tram = isset($_POST['phan_tram']) ? $_POST['phan_tram'] : '';
            $ngay_tao = isset($_POST['ngay_tao']) ? $_POST['ngay_tao'] : '';
            $sl = isset($_POST['sl']) ? $_POST['sl'] : '';
            $dieu_kien = isset($_POST['dieu_kien']) ? $_POST['dieu_kien'] : '';
            $hsd = isset($_POST['hsd']) ? $_POST['hsd'] : '';

            if ($action === 'add') {
                // Thêm voucher mới
                $sql_add = "INSERT INTO giam_gia (ma, phan_tram, ngay_tao, sl, dieu_kien, hsd) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_add);
                $stmt->bind_param("ssssss", $ma, $phan_tram, $ngay_tao, $sl, $dieu_kien, $hsd);
                $stmt->execute();
                echo "<script>alert('Thêm voucher thành công!');</script>";
            } elseif ($action === 'update' && $id !== null) {
                // Cập nhật voucher
                $sql_update = "UPDATE giam_gia SET ma = ?, phan_tram = ?, ngay_tao = ?, sl = ?, dieu_kien = ?, hsd = ? WHERE id_giam_gia = ?";
                $stmt = $conn->prepare($sql_update);
                $stmt->bind_param("ssssssi", $ma, $phan_tram, $ngay_tao, $sl, $dieu_kien, $hsd, $id);
                $stmt->execute();
                echo "<script>alert('Cập nhật voucher thành công!');</script>";
            } elseif ($action === 'delete' && $id !== null) {
                // Xóa voucher
                $sql_delete = "DELETE FROM giam_gia WHERE id_giam_gia = ?";
                $stmt = $conn->prepare($sql_delete);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                echo "<script>alert('Xóa voucher thành công!');</script>";
            }
        }

        // Xử lý tìm kiếm
        $search = isset($_POST['search']) ? trim($_POST['search']) : '';
        if ($search !== '') {
            $sql_gg = "SELECT * FROM giam_gia WHERE id_giam_gia LIKE ? OR ma LIKE ?";
            $stmt = $conn->prepare($sql_gg);
            $search_param = "%" . $search . "%";
            $stmt->bind_param("ss", $search_param, $search_param);
        } else {
            $sql_gg = "SELECT * FROM giam_gia";
            $stmt = $conn->prepare($sql_gg);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        // Dữ liệu voucher được chọn (nếu có)
        $row1 = [
            'id_giam_gia' => '',
            'ma' => '',
            'phan_tram' => '',
            'ngay_tao' => '',
            'sl' => '',
            'dieu_kien' => '',
            'hsd' => ''
        ];
        if (isset($_POST['id']) && $_POST['id'] !== '') {
            $id = $_POST['id'];
            $sql_gg1 = "SELECT * FROM giam_gia WHERE id_giam_gia = ?";
            $stmt = $conn->prepare($sql_gg1);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result1 = $stmt->get_result();
            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
            }
        }
        ?>

        <div class="than_phai">
            <div class="hienthimuc">
                <p>Mã Giảm Giá</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="search" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="container">
                <div class="left">
                    <table class="bang_gg">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã giảm</th>
                                <th>Giảm</th>
                                <th>Ngày tạo</th>
                                <th>Số lượng</th>
                                <th>Điều kiện</th>
                                <th>HSD</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_giam_gia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ma']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phan_tram']); ?>%</td>
                                    <td><?php echo htmlspecialchars($row['ngay_tao']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sl']); ?></td>
                                    <td>Đơn hàng từ <?php echo htmlspecialchars(number_format($row['dieu_kien'])); ?>đ</td>
                                    <td><?php echo htmlspecialchars($row['hsd']); ?></td>
                                    <td>
                                        <form action="#" method="post">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_giam_gia']); ?>">
                                            <button class="btn_setting" type="submit"><i class="fa-solid fa-wrench"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="right">
                    <form method="POST">
                        <label for="maVoucher">ID giảm giá:</label>
                        <input type="text" id="maVoucher" name="id_giam_gia" value="<?php echo htmlspecialchars($row1['id_giam_gia']); ?>" ><br><br>
                        <label for="ma">Mã:</label>
                        <input type="text" id="ma" name="ma" value="<?php echo htmlspecialchars($row1['ma']); ?>"><br><br>
                        <label for="giam">Giảm:</label>
                        <input type="number" id="giam" name="phan_tram" value="<?php echo htmlspecialchars($row1['phan_tram']); ?>"><br><br>
                        <label for="ngayTao">Ngày tạo:</label>
                        <input type="date" id="ngayTao" name="ngay_tao" value="<?php echo htmlspecialchars($row1['ngay_tao']); ?>"><br><br>
                        <label for="soLuong">Số lượng:</label>
                        <input type="number" id="soLuong" name="sl" value="<?php echo htmlspecialchars($row1['sl']); ?>"><br><br>
                        <label for="dieuKien">Điều kiện:</label>
                        <input type="text" id="dieuKien" name="dieu_kien" value="<?php echo htmlspecialchars($row1['dieu_kien']); ?>"><br><br>
                        <label for="hanSuDung">Hạn sử dụng:</label>
                        <input type="date" id="hanSuDung" name="hsd" value="<?php echo htmlspecialchars($row1['hsd']); ?>"><br><br>
                        <button type="submit" name="action" value="add">Thêm</button>
                        <button type="submit" name="action" value="update">Cập nhật</button>
                        <button type="submit" name="action" value="delete">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
