<?php
require_once 'connect.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sp = (int)$_POST['id_sp'];
    $soluong = (int)$_POST['soluong'];

    $query = "SELECT sl FROM kho WHERE id_sp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_sp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['sl'] >= $soluong) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Số lượng không đủ trong kho.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.']);
    }
}
?>
