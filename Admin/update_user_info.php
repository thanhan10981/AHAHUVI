<?php
require("../Home/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $matkhau = !empty($_POST['matkhau']) ? password_hash($_POST['matkhau'], PASSWORD_BCRYPT) : null;

    $ma_tai_khoan = $_SESSION["ma_tai_khoan"];

    $sql = "UPDATE tai_khoan_quan_tri SET ho_ten = ?, email = ?";
    $params = [$ho_ten, $email];

    if ($matkhau) {
        $sql .= ", matkhau = ?";
        $params[] = $matkhau;
    }

    $sql .= " WHERE ma_tai_khoan = ?";
    $params[] = $ma_tai_khoan;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = '../Admin/thong_tin_tkad.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại! Vui lòng thử lại.'); window.history.back();</script>";
    }
}
?>
