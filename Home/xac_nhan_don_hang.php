<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_don_hang = $_POST['id_dh'];
    require("../Home/connect.php");
    $sql = "UPDATE don_hang SET trang_thai='thành công' WHERE id_don_hang=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_don_hang);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>
        alert('Xác nhận đơn hàng thành công!');window.location.href = '../Home/account.php?tabs=notify';</script>";
    } else {
        echo "<script>
        alert('Xảy ra vấn đề lỗi vui lòng thử lại!');window.location.href = '../Home/account.php?tabs=notify';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
