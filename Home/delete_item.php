<?php
session_start();
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sp'])) {
    $id_sp = intval($_POST['id_sp']);
    $id_kh = $_SESSION["id_kh"]; // Đảm bảo có thông tin khách hàng

    // Truy vấn xóa sản phẩm trong SQL
    $sql = "DELETE FROM san_pham_gio_hang 
            WHERE id_sp = ? AND id_gio_hang = (
                SELECT id_gio_hang FROM gio_hang WHERE id_kh = ?
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_sp, $id_kh);
    $success = $stmt->execute();

    if ($success) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Xóa sản phẩm không thành công."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Yêu cầu không hợp lệ."]);
}
?>
