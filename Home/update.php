<?php
session_start();

if (isset($_POST['btn-up'])) {
    require "../Home/connect.php"; // Kết nối cơ sở dữ liệu

    // Kiểm tra xem session có tồn tại không
    if (isset($_SESSION["id_kh"])) {
        $id = $_SESSION["id_kh"];
    } else {
        echo "Bạn cần đăng nhập để thực hiện hành động này.";
        exit;
    }

    // Lấy dữ liệu từ form
    $ten_kh = $_POST['fullname'];
    $email = $_POST['email'];
    $gioi_tinh = $_POST['gt'];
    $ngay_sinh = $_POST['birthday'];
    $sdt = $_POST['phone'];

    // Dùng prepared statements để tránh SQL injection
    $sql = "UPDATE khach_hang SET ten_kh = ?, gioi_tinh = ?, email = ?, sdt = ?, ngay_sinh = ? WHERE mkh = ?";
    $stmt = $conn->prepare($sql);

    // Gắn giá trị vào prepared statement
    $stmt->bind_param("ssssss", $ten_kh, $gioi_tinh, $email, $sdt, $ngay_sinh, $id);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        // Sau khi thành công, chuyển hướng lại trang tài khoản để load lại dữ liệu
        $_SESSION['success_message'] = 'Thông tin đã được cập nhật thành công!';
        header("location:../Home/account.php?tabs=hscn");
        exit();
    } else {
        echo "Có lỗi xảy ra, vui lòng thử lại!";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>