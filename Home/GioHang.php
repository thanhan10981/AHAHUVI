<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="icon" href="../IMG/logo_icon.png">
    <link rel="stylesheet" href="../Css/GioHang.css">
    <link rel="stylesheet" href="../Css/header.css">
    <link rel="stylesheet" href="../Css/ho_tro.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
        <?php
        require("../Home/header.php");
        require("../Home/connect.php");
        ?>
    <?php
    if (!isset($_SESSION["id_kh"])) {
        echo '<div id="empty-cart-alert">
            Vui lòng đăng nhập!!!
        </div>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "../Home/login.php";
            }, 3000);
        </script>';
        exit();;
    }
    if (isset($_SESSION["id_kh"])) {
        $id_kh = $_SESSION["id_kh"];
        $sql = "SELECT khach_hang.mkh, san_pham_gio_hang.id_sp, san_pham.ten_sp, san_pham.anh_bia, san_pham.gia, san_pham_gio_hang.sl
            FROM gio_hang 
            JOIN khach_hang ON gio_hang.id_kh = khach_hang.mkh
            JOIN san_pham_gio_hang ON gio_hang.id_gio_hang = san_pham_gio_hang.id_gio_hang
            JOIN san_pham ON san_pham_gio_hang.id_sp = san_pham.id_sp
            WHERE gio_hang.id_kh = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_kh);
        $stmt->execute();
        $result = $stmt->get_result();
       
    }
    if ($result->num_rows === 0) {
        echo '<div id="empty-cart-alert">
            giỏ hàng của bạn đang trống!. Vui lòng chọn sản phẩm để vào giỏ hàng!
        </div>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "../Home/index.php";
            }, 3000);
        </script>';
        exit();
    }
    $tongtien = 0;
    if ($result && $result->num_rows > 0) {
        echo '<form id="cart-form" action="ThanhToan.php" method="POST">
        <h1 class="cart-container-1">Giỏ Hàng ('.$result->num_rows.' sản phẩm)</h1>';
       echo'<span class="soluong"> Số lượng</span> <span class="thanhtien"> Thành tiền</span>';
        while ($row = $result->fetch_assoc()) {
            $itemTotal = $row['gia'] * $row['sl'];
            $tongtien += $itemTotal;
            $tensp_list[] = $row['ten_sp'];
            echo '
            <div class="cart-container">
                <div class="cart-item" data-id="' . $row['id_sp'] . '" data-price="' . $row['gia'] . '">
                    <img src="../IMG/' . $row['anh_bia'] . '" alt="' . $row['ten_sp'] . '">
                    <input type="hidden" name="ds" value="'.$row['ten_sp'].'">
                    <div class="item-info">
                        <p>' . $row['ten_sp'] . '</p>
                        <p class="price">' . number_format($row['gia']) . 'đ</p>
                    </div>
                    <div class="quantity">
                        <button type="button" class="decrease">-</button>
                        <input type="number" name="quantities[' . $row['id_sp'] . ']" value="' . $row['sl'] . '" min="1">
                        <button type="button" class="increase">+</button>
                    </div>
                    <p class="t-price">' . number_format($itemTotal) . ' đ</p>
                    <button type="button" class="delete"> <i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>';
        }
        $tensp_string = implode(", ", $tensp_list);
        echo '
        <input type="hidden" name="ds_sp" value="' .$tensp_string. '">
        <input type="hidden" name="tongtien" value="' . $tongtien . '">
        <div class="checkout">
            <p class="total-price">Thành tiền: <span id="tongtien">' . number_format($tongtien) . '</span></p><br>
            <button type="submit" name="checkout" class="btn-checkout">THANH TOÁN</button>
        </div>';
        echo '</form>';
    } else {
        echo '<h1 class="cart-container">Giỏ Hàng</h1>';
    }
    ?>
    <script src="../Js/gio_hang.js"></script>
    <script src="../js/ho_tro.js"></script>
    <?php require("../Home/ho_tro.php") ?>
    <div class="mau_body"></div>
    <?php require("../Home/footer.php") ?>
</body>
</html>