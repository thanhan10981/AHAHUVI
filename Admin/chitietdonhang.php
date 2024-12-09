<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="../Css/chitietdonhang.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="than">
        <?php
        require("../Home/connect.php"); // Kết nối đến cơ sở dữ liệu
        require("../Admin/menu.php");
        
        // Kiểm tra nếu có tham số tìm kiếm
        $id_don_hang = isset($_GET['id']) ? $_GET['id'] : '';
        if(isset($_POST['search_keyword'])){
            $id_don_hang = $_POST['search_keyword'];
        }

        if(empty($id_don_hang)){
            echo '<p>Không tìm thấy ID đơn hàng.</p>';
            exit();
        }
        ?>
        <div class="than_phai">
            <div class="hienthimuc">
                <p>Đơn hàng</p>
                <!-- Form tìm kiếm đơn hàng -->
                <form action="#" method="post" class="search_form">
                    <input type="text" name="search_keyword" placeholder="Tìm kiếm...(mã đơn hàng)" value="<?php echo htmlspecialchars($id_don_hang); ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="container">
                <!-- Phần thông tin giao hàng -->
                <div class="left">
                    <?php
                    $tongtien = 0;
                    // Cập nhật truy vấn SQL với điều kiện id_don_hang
                    $sql_dh = "SELECT don_hang.id_don_hang, khach_hang.mkh, khach_hang.ten_kh, don_hang.pt_thanhtoan, don_hang.trang_thai, don_hang.dia_chi, khach_hang.sdt 
                               FROM don_hang 
                               JOIN khach_hang ON don_hang.id_kh = khach_hang.mkh 
                               WHERE don_hang.id_don_hang = '$id_don_hang'";
                    $result = $conn->query($sql_dh);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <h2>Chi Tiết Đơn Hàng: ' . $row['id_don_hang'] . '</h2>
                            <h3>Thông tin giao hàng</h3>
                            <p>MKH: ' . $row['mkh'] . '</p>
                            <p>Tên khách hàng: ' . $row['ten_kh'] . '</p>
                            <p>Địa chỉ: ' . $row['dia_chi'] . '</p>
                            <p>SDT: ' . $row['sdt'] . '</p>
                            <p>PTTT: ' . $row['pt_thanhtoan'] . '</p>
                            <label for="trang_thai">Trạng thái: ' . $row['trang_thai'] . '</label>';
                        }
                    } else {
                        echo '<p>Không tìm thấy thông tin đơn hàng.</p>';
                    }
                    ?>
                </div>
                <!-- Phần chi tiết sản phẩm -->
                <div class="right">
                    <?php
                    $sql_ctdh = "SELECT san_pham.id_sp, san_pham.ten_sp, san_pham.gia, san_pham_dat_mua.sl, san_pham_dat_mua.thanh_tien 
                                 FROM san_pham_dat_mua 
                                 JOIN san_pham ON san_pham.id_sp = san_pham_dat_mua.id_sp 
                                 WHERE san_pham_dat_mua.id_don_hang = '$id_don_hang'";
                    $result = $conn->query($sql_ctdh);

                    if ($result->num_rows > 0) {
                        echo '
                        <table class="bang_sp">
                            <thead>
                                <tr>
                                    <th>MSP</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá tiền</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>';
                        while ($row1 = $result->fetch_assoc()) {
                            $tongtien += $row1['thanh_tien'];
                            echo '
                                <tr>
                                    <td>' . $row1['id_sp'] . '</td>
                                    <td>' . $row1['ten_sp'] . '</td>
                                    <td>' . $row1['sl'] . '</td>
                                    <td>' . number_format($row1['gia'], 0, ',', '.') . ' VND</td>
                                    <td>' . number_format($row1['thanh_tien'], 0, ',', '.') . ' VND</td>
                                </tr>';
                        }
                        echo '
                            </tbody>
                        </table>';
                    } else {
                        echo '<p>Không có sản phẩm nào trong đơn hàng.</p>';
                    }
                    echo'<p class="total-price">Thành tiền: <span id="tongtien">' . number_format($tongtien) . '</span></p>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
