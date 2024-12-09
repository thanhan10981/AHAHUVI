<?php
require("../Home/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_danh_muc'])) {
    $id_danh_muc = intval($_POST['id_danh_muc']);
    $sql = "SELECT `id_the_loai`, `ten_the_loai` FROM `the_loai` WHERE `id_danh_muc` = $id_danh_muc";
    $result = $conn->query($sql);

    $theLoais = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $theLoais[] = $row;
        }
    }
    echo json_encode($theLoais);
}
?>
