<?php
require("../Home/connect.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ma"]) && isset($_POST["tongtien"])) {
    $discount_code = $_POST["ma"];
    $tongtien = (float)$_POST["tongtien"];

    $query = "SELECT * FROM giam_gia WHERE ma = '$discount_code' AND dieu_kien < '$tongtien'";
    $result2 = $conn->query($query);

    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        if ($row["phan_tram"] * $tongtien >= $row["gia_giam"]) {
            $new_tongtien = $tongtien - $row["gia_giam"];
        } else {
            $discount_percent = (float)$row["phan_tram"];
            $new_tongtien = $tongtien - ($tongtien * $discount_percent / 100);
        }
        $new_quantity = $row["sl"] - 1;
        $update_query = "UPDATE giam_gia SET sl = '$new_quantity' WHERE ma = '$discount_code'";
        $conn->query($update_query);

        $response = [
            "success" => true,
            "message" => "Nhập Voucher thành công. Tổng tiền mới: " . number_format($new_tongtien, 0, ',', '.') . " đ",
            "newTotal" => $new_tongtien,
            "newTotalFormatted" => number_format($new_tongtien, 0, ',', '.')
        ];
    } else {
        $response = [
            "success" => false,
            "message" => "Mã giảm giá không hợp lệ."
        ];
    }

    echo json_encode($response);
}
