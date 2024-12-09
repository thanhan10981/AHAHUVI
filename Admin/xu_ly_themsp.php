<?php
session_start();
require("../Home/connect.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['add_product'])) {
    $id_sp = isset($_POST['id_sp']) && !empty($_POST['id_sp']) ? $_POST['id_sp'] : null;
    $ten_sp = isset($_POST['product-name']) ? $_POST['product-name'] : null;
    $gia = isset($_POST['price']) ? $_POST['price'] : null;
    $tac_gia = isset($_POST['author']) ? $_POST['author'] : null;
    $nxb = isset($_POST['nxb']) ? $_POST['nxb'] : null;
    $nsx = isset($_POST['nha_xb']) ? $_POST['nha_xb'] : null;
    $mo_ta = isset($_POST['description']) ? $_POST['description'] : null;
    $selected_danh_muc = isset($_POST['danh_muc']) ? $_POST['danh_muc'] : null;
    $selected_the_loai = isset($_POST['the_loai']) ? $_POST['the_loai'] : null;
    $selected_ncc = isset($_POST['nha_cung_cap']) ? $_POST['nha_cung_cap'] : null;
    $anh_bia = isset($_POST['cover']) ? $_POST['cover'] : null;
    $anh_phu = isset($_POST['additional_images[]']) ? $_POST['additional_images[]'] : null;
  
   

    // Kiểm tra nếu có trường nào còn trống
    if (empty($ten_sp) || empty($selected_danh_muc) || empty($selected_the_loai) || empty($gia) || empty($tac_gia) || empty($nxb) || empty($nsx) || empty($mo_ta) || empty($selected_ncc)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin sản phẩm (trừ mã sản phẩm).');</script>";
    }
    if ($id_sp) {
        // Kiểm tra ID sản phẩm có tồn tại
        $sql_check = "SELECT id_sp FROM san_pham WHERE id_sp = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id_sp);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "<script>alert('ID sản phẩm đã tồn tại. Vui lòng nhập ID khác hoặc để trống.');</script>";
            exit;
        }
        $stmt_check->close();
    }

    // Tạo câu lệnh SQL
    $sql_insert = "INSERT INTO san_pham 
    (id_sp, ten_sp, id_danh_muc, id_the_loai, gia, anh_bia, anh_phu, tac_gia, nxb, nha_xb, mo_ta, id_ncc) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
    } else {
        // Nếu không có ID, gán ID bằng null
        $id_sp_for_bind = $id_sp ? $id_sp : null;

        // Tiến hành bind_param() với các tham số là biến
        $stmt->bind_param("isiiidsssssi", $id_sp_for_bind, $ten_sp, $selected_danh_muc, $selected_the_loai, $gia, $anh_bia, $anh_phu, $tac_gia, $nxb, $nsx, $mo_ta, $selected_ncc);
    }

    // Thực thi và phản hồi kết quả
    if ($stmt->execute()) {
        $generated_id = $id_sp ? $id_sp : $conn->insert_id; // Lấy ID tự động nếu người dùng không nhập
        echo "<script>alert('Thêm sản phẩm thành công! Mã sản phẩm: $generated_id');</script>";
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit;
    } else {
        echo "<script>alert('Thêm sản phẩm thất bại: " . $conn->error . "');</script>";
    }
}
?>