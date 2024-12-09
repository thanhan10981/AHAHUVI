<?php
require("../Home/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_danh_muc'])) {
    $id_danh_muc = intval($_POST['id_danh_muc']);  // Sanitize input

    // Prevent SQL injection
    if ($id_danh_muc <= 0) {
        echo json_encode([]);
        exit;
    }

    // Query to get the types (Thể loại) based on selected category (Danh mục)
    $stmt = $conn->prepare("SELECT `id_the_loai`, `ten_the_loai` FROM `the_loai` WHERE `id_danh_muc` = ?");
    $stmt->bind_param("i", $id_danh_muc);
    $stmt->execute();
    $result = $stmt->get_result();

    $theLoais = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $theLoais[] = $row;
        }
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($theLoais);
}

?>
