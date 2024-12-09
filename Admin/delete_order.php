<?php
require("../Home/connect.php");

// Đảm bảo nhận được dữ liệu
$data = json_decode(file_get_contents("php://input"), true);
$orderId = $data['id'] ?? null;

if ($orderId) {
    // Xóa đơn hàng
    $sql = "DELETE FROM don_hang WHERE id_don_hang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close();
?>
