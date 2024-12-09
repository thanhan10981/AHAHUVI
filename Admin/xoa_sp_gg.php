<?php
require('../Home/connect.php');
if (isset($_GET['id_sp'])) {
    $id_sp = intval($_GET['id_sp']); 

    // Thực hiện câu lệnh xóa
    $stmt = $conn->prepare("DELETE FROM san_pham WHERE id_sp = ?");
    $stmt->bind_param("i", $id_sp);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href = '../Admin/giagiam_ad.php'; </script>";
        exit();
    } else {
        echo "Lỗi: Không thể xóa sản phẩm này.";
        
    }

    $stmt->close();
} else {
    echo "Lỗi: Không tìm thấy sản phẩm để xóa.";
}
$conn->close();
?>
