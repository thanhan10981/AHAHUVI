<?php
session_start();

if (isset($_POST['btn-update'])) {
    require "../Home/connect.php"; // Kết nối cơ sở dữ liệu

    // Kiểm tra xem session có tồn tại không
    if (isset($_SESSION["id_kh"])) {
        $id = $_SESSION["id_kh"];
    } else {
        echo "Bạn cần đăng nhập để thực hiện hành động này.";
        exit;
    }

    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $tinh_thanhpho = $_POST['addressCity']; // Tỉnh/Thành phố
    $quan_huyen = $_POST['district']; // Quận/Huyện
    $xa_phuong = $_POST['ward']; // Xã/Phường
    $addressDetail = $_POST['addressDetail']; // Địa chỉ chi tiết
    $fullAddress =$addressDetail . "," . $xa_phuong ."," . $quan_huyen ."," . $tinh_thanhpho;

    // Dùng prepared statements để tránh SQL injection
    $sql = "UPDATE khach_hang SET ten_kh = ?, sdt = ?, dia_chi = ? WHERE mkh = ?";
    $stmt = $conn->prepare($sql);

    // Gắn giá trị vào prepared statement
    $stmt->bind_param("ssss",   $fullname, $phone, $fullAddress, $id);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Sau khi thành công, chuyển hướng lại trang tài khoản để load lại dữ liệu
        $_SESSION['success_message'] = 'Thông tin đã được cập nhật thành công!';
        header("location:../Home/account.php?tabs=tdcm");
        exit();
    } else {
        echo "Có lỗi xảy ra, vui lòng thử lại!";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>