<?php
require "../Home/connect.php"; // Kết nối CSDL

$id_kh = $_SESSION['id_kh']; // Lấy ID khách hàng từ session

// Truy vấn dữ liệu từ bảng binh_luan kết hợp với san_pham để lấy tên sản phẩm
$sql = "
    SELECT 
        binh_luan.danh_gia, 
        binh_luan.noi_dung_binh_luan, 
        binh_luan.ngay_tao, 
        san_pham.ten_sp -- Lấy tên sản phẩm từ bảng san_pham
    FROM 
        binh_luan
    INNER JOIN 
        san_pham ON binh_luan.id_sp = san_pham.id_sp
    WHERE 
        binh_luan.id_kh = ?"; // Lọc theo ID khách hàng

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Lỗi truy vấn: " . $conn->error);
}

$stmt->bind_param("i", $id_kh); // Gán giá trị $id_kh vào truy vấn
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra xem có dữ liệu hay không
if ($result->num_rows > 0) {
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
} else {
    // Nếu không có dữ liệu
    echo "Không tìm thấy nhận xét nào cho ID khách hàng: " . $id_kh;
    $comments = [];
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
