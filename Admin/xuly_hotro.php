<?php
require('../Home/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $ma_ht = $_POST['ma_ht'] ?? null ;
    $trang_thai = $_POST['trang_thai'] ?? null;
    $action = $_POST['action']?? null ; // Xác định hành động


   if ($action === 'update') {
        // Cập nhật thông tin khách hàng
        $sql = "UPDATE ho_tro SET  trang_thai = ? WHERE ma_ht = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',  $trang_thai, $ma_ht);
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhập thông tin thành công.'); window.location.href = '../Admin/hotrokh.php'; </script>";
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } elseif ($action === 'delete') {    
        $sql = "DELETE FROM ho_tro WHERE ma_ht = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $ma_ht);
        $stmt->execute();
        if ($stmt->execute()) {
            echo "<script>alert('Xóa khách hàng thành công.'); window.location.href = '../Admin/hotrokh.php'; </script>";
            exit(); 
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    }
}
?>