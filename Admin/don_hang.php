<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/don_hang.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Đơn Hàng</title>
</head>
<?php require("../Home/connect.php"); ?>

<body>
    <div class="than">
        <?php require("../Admin/menu.php"); ?>
        <div class="than_phai">
            <div class="hienthimuc">
                <p>Danh sách đơn hàng</p>
                <form action="#" method="post" class="search_form">
                    <input type="text" name="keyword" placeholder="Tìm kiếm..." value="<?php echo isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="container">
                <table class="bang_dh">
                    <thead>
                        <tr>
                            <th>MDH</th>
                            <th>MKH</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>PTTT</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
                        $sql = "SELECT * FROM don_hang";
                        
                        if (!empty($keyword)) {
                            $sql .= " WHERE id_don_hang LIKE ? OR id_kh LIKE ? OR tong_tien LIKE ? OR trang_thai LIKE ? OR dia_chi LIKE ? OR ngay_tao LIKE ? OR pt_thanhtoan LIKE ?";
                        }

                        // Chuẩn bị truy vấn
                        $stmt = $conn->prepare($sql);

                        if (!empty($keyword)) {
                            $search_term = "%$keyword%";
                            $stmt->bind_param("sssssss", $search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
                        }

                        // Thực thi truy vấn
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                            <td>{$row['id_don_hang']}</td>
                            <td>{$row['id_kh']}</td>
                            <td>{$row['ngay_tao']}</td>
                            <td>".number_format($row['tong_tien'])." đ</td>
                            <td>{$row['pt_thanhtoan']}</td>
                            <td>{$row['trang_thai']}</td>
                            <td>
                                <button class='btn-delete' data-id='{$row['id_don_hang']}'><i class='fa-solid fa-trash'></i></button>
                                <a href='../Admin/chitietdonhang.php?id={$row['id_don_hang']}'><i class='fa-solid fa-screwdriver-wrench'></i></a>
                            </td>
                            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../Js/don_hang.js"></script>
</body>
</html>
