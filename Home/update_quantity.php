<?php
session_start();
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sp'], $_POST['quantity'])) {
    $id_sp = intval($_POST['id_sp']);
    $quantity = intval($_POST['quantity']);
    $id_kh = $_SESSION["id_kh"]; // Đảm bảo có thông tin khách hàng

    if ($quantity < 1) {
        echo json_encode(["success" => false, "message" => "Số lượng không hợp lệ!"]);
        exit();
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $sql = "UPDATE san_pham_gio_hang 
            SET sl = ? 
            WHERE id_sp = ? AND id_gio_hang = (
                SELECT id_gio_hang FROM gio_hang WHERE id_kh = ?
            )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $id_sp, $id_kh);
    $success = $stmt->execute();

    if ($success) {
        echo json_encode(["success" => true, "new_quantity" => $quantity]);
    } else {
        echo json_encode(["success" => false, "message" => "Cập nhật số lượng không thành công."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Yêu cầu không hợp lệ."]);
}
?>
