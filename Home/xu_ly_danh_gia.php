<?php
session_start();
include 'connect.php'; 
if (isset($_POST['id_don_hang'], $_POST['id_sp'], $_POST['danh_gia'], $_POST['noi_dung_binh_luan'])) {
    $id_kh = $_SESSION['id_kh']; 
    $id_don_hang = $_POST['id_don_hang'];
    $id_sp = $_POST['id_sp'];
    $danh_gia = $_POST['danh_gia'];
    $noi_dung_binh_luan = $_POST['noi_dung_binh_luan'];
    $ngay_tao = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO binh_luan (id_kh, id_sp, danh_gia, noi_dung_binh_luan, ngay_tao)
                   VALUES ('$id_kh', '$id_sp', '$danh_gia', '$noi_dung_binh_luan', '$ngay_tao')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Đánh giá của bạn đã được gửi.";
        header("Location: ../Home/account.php?tabs=review"); 
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Dữ liệu không đầy đủ.";
    exit();
}
?>
