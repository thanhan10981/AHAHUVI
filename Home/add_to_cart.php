<?php
session_start();
require("../Home/connect.php");
if (isset($_SESSION["id_kh"])) {
    $id_kh = $_SESSION["id_kh"];
    $_SESSION["id_kh"] = $id_kh;
}
if (isset($_POST['id_sp']) && isset($_POST['gia'])  && isset($_POST['soluong'])) {
        $id_sp = $_POST['id_sp'];
        $gia = $_POST['gia'];
        $soluong = $_POST['soluong'];
        $id_kh = $_SESSION["id_kh"];


        // Bước 1: Kiểm tra nếu khách hàng đã có giỏ hàng
        $sql = "SELECT id_gio_hang FROM gio_hang WHERE id_kh = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_kh);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Giỏ hàng đã tồn tại
            $id_gio_hang = $row['id_gio_hang'];
        } else {
            // Nếu chưa có giỏ hàng thì tạo mới
            $sql_tao_gio_hang = "INSERT INTO gio_hang (id_kh) VALUES (?)";
            $stmt_tao = $conn->prepare($sql_tao_gio_hang);
            $stmt_tao->bind_param("i", $id_kh);
            $stmt_tao->execute();

            // Lấy id giỏ hàng vừa tạo
            $id_gio_hang = $conn->insert_id;
        }
        $sql_sp = "SELECT ten_sp, gia FROM san_pham WHERE id_sp = ?";
        $stmt_sp = $conn->prepare($sql_sp);
        $stmt_sp->bind_param("i", $id_sp);
        $stmt_sp->execute();
        $result_sp = $stmt_sp->get_result();
        $row_sp = $result_sp->fetch_assoc();

        $ten_sp = $row_sp['ten_sp'];
        $gia_sp = $row_sp['gia'];
        // Bước 2: Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $sql_kiem_tra_sp = "SELECT sl FROM san_pham_gio_hang WHERE id_gio_hang = ? AND id_sp = ?";
        $stmt_kiem_tra_sp = $conn->prepare($sql_kiem_tra_sp);
        $stmt_kiem_tra_sp->bind_param("ii", $id_gio_hang, $id_sp);
        $stmt_kiem_tra_sp->execute();
        $result_sp = $stmt_kiem_tra_sp->get_result();
        $row_sp = $result_sp->fetch_assoc();

        if ($row_sp) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $sl_moi = $row_sp['sl'] + $soluong;
            $sql_cap_nhat_sl = "UPDATE san_pham_gio_hang SET sl = ? WHERE id_gio_hang = ? AND id_sp = ?";
            $stmt_cap_nhat = $conn->prepare($sql_cap_nhat_sl);
            $stmt_cap_nhat->bind_param("iii", $sl_moi, $id_gio_hang, $id_sp);
            $stmt_cap_nhat->execute();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới sản phẩm vào giỏ hàng
            $sql_them_sp = "INSERT INTO san_pham_gio_hang (id_gio_hang, id_sp, ten_sp, sl, gia) VALUES (?, ?, ?, ?, ?)";
            $stmt_them_sp = $conn->prepare($sql_them_sp);
            $sl_ban_dau = $soluong;
            $stmt_them_sp->bind_param("iisid", $id_gio_hang, $id_sp, $ten_sp, $sl_ban_dau, $gia_sp);
            $stmt_them_sp->execute();
        }
        if (isset($_SESSION['id_kh']) && isset($_POST['id_sp']) && isset($_POST['gia'])  && isset($_POST['soluong'])) {
            $id_sp = $_POST['id_sp'];
            $gia = $_POST['gia'];
            $soluong = $_POST['soluong'];
            $id_kh = $_SESSION['id_kh'];
        } else {
            die("Thiếu thông tin sản phẩm hoặc người dùng chưa đăng nhập.");
        }
    }
?>