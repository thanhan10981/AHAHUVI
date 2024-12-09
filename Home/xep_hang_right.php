<?php
require('../Home/connect.php');

$id_sp = $_POST['id_sp'];

// Fetch product details by id_sp
$sql = "SELECT id_sp, ten_sp, gia, gia_giam, anh_bia, tac_gia, nha_xb, mo_ta FROM san_pham WHERE id_sp = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_sp);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Format prices using number_format to add thousands separator
    $row['gia'] = number_format($row['gia'], 0, ',', '.') ;
    $row['gia_giam'] = !empty($row['gia_giam']) ? number_format($row['gia_giam'], 0, ',', '.')  : null;

    // Send JSON response
    echo json_encode($row);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
