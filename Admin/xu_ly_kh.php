<?php
require('../Home/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $makh = $_POST['makh'] ?? null;
    $tenkh = $_POST['tenkh'] ?? null;
    $gioitinh = $_POST['gioitinh'] ?? null;
    $ngaysinh = $_POST['ngaysinh'] ?? null;
    $sdt = $_POST['sdt'] ?? null;
    $email = $_POST['email'] ?? null;
    $diachi = $_POST['diachi'] ?? null;
    $action = $_POST['action'] ?? null; 

   if ($action === 'update') {
        $sql = "UPDATE khach_hang 
                SET ten_kh = ?, gioi_tinh = ?, ngay_sinh = ?, sdt = ?, email = ?, dia_chi = ? 
                WHERE mkh = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssss', $tenkh, $gioitinh, $ngaysinh, $sdt, $email, $diachi, $makh);
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhập thông tin thành công.'); window.location.href = '../Admin/quan_ly_khach_hang.php'; </script>";
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM gio_hang WHERE id_kh = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $makh);
        $stmt->execute();
        $sql = "DELETE FROM khach_hang WHERE mkh = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $makh);
        $stmt->execute();
        if ($stmt->execute()) {
            echo "<script>alert('Xóa khách hàng thành công.'); window.location.href = '../Admin/quan_ly_khach_hang.php'; </script>";
            exit(); 
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    }
}
