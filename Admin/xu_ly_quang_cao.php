<?php
require('../Home/connect.php');
$action = $_POST['action'] ?? '';
$mbanner = $_POST['mbanner'] ?? '';
$anh = $_POST['anh'] ?? ''; 
$anh_cu = $_POST['anh_cu'] ?? ''; 
$vi_tri = $_POST['vi_tri'] ?? '';
$ngay_tao = $_POST['ngay_tao'] ?? '';
$ngay_bd = $_POST['ngay_bd'] ?? '';
$ngay_kt = $_POST['ngay_kt'] ?? '';
$trang_thai = $_POST['trang_thai'] ?? '';
if($anh==""){
    $anh = $anh_cu;
}

if ($action === 'add') {

    $sql = "INSERT INTO quang_cao (id_quang_cao, ten, vi_tri, ngay_tao, ngay_bat_dau, ngay_ket_thuc) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $mbanner, $anh, $vi_tri, $ngay_tao, $ngay_bd, $ngay_kt);
    
    if ($stmt->execute()) {
        echo "<script>alert('Thêm ảnh quảng cáo thành công!.'); window.location.href = '../Admin/quang_cao.php'; </script>";
        exit();
    } else {
        echo "Lỗi khi thêm quảng cáo: " . $stmt->error;
    }
} elseif ($action === 'update') {
    $sql = "UPDATE quang_cao SET vi_tri = ?, ngay_tao = ?, ngay_bat_dau = ?, ngay_ket_thuc = ?";
    
    if (!empty($anh)) {
        $sql .= ", ten = ?";
    }
    $sql .= " WHERE id_quang_cao = ?";
    
    $stmt = $conn->prepare($sql);
    if (!empty($anh)) {
        $stmt->bind_param('ssssss', $vi_tri, $ngay_tao, $ngay_bd, $ngay_kt, $anh, $mbanner);
    } else {
        $stmt->bind_param('sssss', $vi_tri, $ngay_tao, $ngay_bd, $ngay_kt, $mbanner);
    }
    
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật quảng cáo thành công!.'); window.location.href = '../Admin/quang_cao.php'; </script>";
        exit();
    } else {
        echo "Lỗi khi cập nhật quảng cáo: " . $stmt->error;
    }


} elseif ($action === 'delete') {
    $sql = "DELETE FROM quang_cao WHERE id_quang_cao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $mbanner);
    
    if ($stmt->execute()) {
        echo "<script>alert('Xóa quảng cáo thành công!.'); window.location.href = '../Admin/quang_cao.php'; </script>";
        exit();
       
    } else {
        echo "Lỗi khi xóa quảng cáo: " . $stmt->error;
    }
} else {
    echo "Hành động không hợp lệ!";
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
