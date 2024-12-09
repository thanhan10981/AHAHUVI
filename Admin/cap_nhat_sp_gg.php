<?php
require("../Home/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cap_nhat'])) {
        $id_danh_muc = $_POST['id_danh_muc'] ?? '';
        $id_the_loai = $_POST['id_the_loai'] ?? '';
        $id_sp = $_POST['id_sp'] ?? '';
        $ten_sp = $_POST['ten_sp'] ?? '';
        $phan_tram = $_POST['phan_tram'] ?? '';
        if (empty($id_sp) || empty($ten_sp) || empty($phan_tram)) {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        }
        $sql = "UPDATE `san_pham` 
                SET `ten_sp` = ?, `phan_tram` = ?, `id_danh_muc` = ?, `id_the_loai` = ? 
                WHERE `id_sp` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiii", $ten_sp, $phan_tram, $id_danh_muc, $id_the_loai, $id_sp);

        if ($stmt->execute()) {
            echo "<script>alert('Cập nhập sản phẩm thành công!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        } else {
            echo "<script>alert('Lỗi khi cập nhập sản phẩm!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        }
    }
    if (isset($_POST['them'])) {
        $id_danh_muc = $_POST['id_danh_muc'] ?? '';
        $id_the_loai = $_POST['id_the_loai'] ?? '';
        $id_sp = $_POST['id_sp'] ?? '';
        $ten_sp = $_POST['ten_sp'] ?? '';
        $phan_tram = $_POST['phan_tram'] ?? '';
        if (empty($id_sp) || empty($ten_sp) || empty($phan_tram)) {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        }
        $sql ="UPDATE `san_pham` 
                SET `ten_sp` = ?, `phan_tram` = ?, `id_danh_muc` = ?, `id_the_loai` = ? 
                WHERE `id_sp` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiii", $id_sp, $ten_sp, $phan_tram, $id_danh_muc, $id_the_loai);

        if ($stmt->execute()) {
            echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        } else {
            echo "<script>alert('Lỗi khi thêm sản phẩm!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
            exit;
        }
    }
}
