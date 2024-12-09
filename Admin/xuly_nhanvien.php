<?php
require('../Home/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $manv = $_POST['mnv'] ?? null ;
    $tennv = $_POST['ten_nhan_vien'] ?? null ;
    $email = $_POST['email'] ?? null ;
    $sdt = $_POST['sdt'] ?? null;
    $ngaytao = $_POST['ngay_tao'] ?? null;
    $diachi = $_POST['dia_chi'] ?? null;
    $action = $_POST['action']?? null ; // Xác định hành động

    // Xử lý các hành động
    if ($action === 'add') {
        // Thêm khách hàng
        $sql = "INSERT INTO nhan_vien (mnv, ten_nhan_vien, email, sdt, ngay_tao, dia_chi) 
                VALUES (?, ?, ?, ?, ?,  ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $manv, $tennv, $email, $sdt, $ngaytao, $diachi);
        if ($stmt->execute()) {
            echo "<script>alert('Thêm nhân viên thành công!.'); window.location.href = '../Admin/quanly_nhanvien.php'; </script>";
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } elseif ($action === 'update') {
        // Cập nhật thông tin khách hàng
        $sql = "UPDATE nhan_vien 
                SET ten_nhan_vien= ?, email = ?, sdt = ?, ngay_tao =?, dia_chi = ? 
                WHERE mnv = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss',  $tennv, $email, $sdt, $ngaytao, $diachi, $manv);
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhập thông tin thành công.'); window.location.href = '../Admin/quanly_nhanvien.php'; </script>";
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } elseif ($action === 'delete') {    
        $sql = "DELETE FROM nhan_vien WHERE mnv = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $manv);
        $stmt->execute();
        if ($stmt->execute()) {
            echo "<script>alert('Xóa nhân viên thành công.'); window.location.href = '../Admin/quanly_nhanvien.php'; </script>";
            exit(); 
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    }
}
