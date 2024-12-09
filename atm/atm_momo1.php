<?php
header('Content-type: text/html; charset=utf-8');
session_start();
require("../Home/connect.php");
if (isset($_SESSION["id_kh"])) {
    $id_kh = $_SESSION["id_kh"];
}

// Thiết lập múi giờ TP.HCM
date_default_timezone_set("Asia/Ho_Chi_Minh");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tong_tien = (float)$_POST['tongtien'];
    $dia_chi = $_POST['diachi'];
    $pttt = $_POST['pttt'];
    $id_sp = $_POST['id_sp'];

    // 1. Lấy thời gian hiện tại theo TP.HCM
    $thoi_gian_hien_tai = date("Y-m-d H:i:s");

    // 2. Tạo hóa đơn mới
    $insert_hoa_don = "INSERT INTO don_hang (id_kh, tong_tien, pt_thanhtoan, dia_chi, ngay_tao) 
                       VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_hoa_don);
    $stmt->bind_param("idsss", $id_kh, $tong_tien, $pttt, $dia_chi, $thoi_gian_hien_tai);
    $stmt->execute();
    $id_hoa_don = $conn->insert_id;

    // 3. Lấy thông tin sản phẩm
    $select_gio_hang = "SELECT id_sp, ten_sp, gia FROM san_pham WHERE id_sp = ?";
    $stmt = $conn->prepare($select_gio_hang);
    $stmt->bind_param("i", $id_sp);
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. Chuyển sản phẩm sang bảng `san_pham_dat_mua`
    $insert_san_pham = "INSERT INTO san_pham_dat_mua (id_don_hang, id_sp, ten_sp, sl, gia, thanh_tien) 
                        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($insert_san_pham);

    while ($row = $result->fetch_assoc()) {
        $ten_sp = $row['ten_sp'];
        $gia = $row['gia'];
        $so_luong = 1; // Giả sử số lượng là 1
        $tong_tien_sp = $so_luong * $gia;

        // Thêm sản phẩm vào bảng `san_pham_dat_mua`
        $stmt_insert->bind_param("iisidd", $id_hoa_don, $id_sp, $ten_sp, $so_luong, $gia, $tong_tien_sp);
        $stmt_insert->execute();

        // 4.1. Trừ số lượng sản phẩm trong kho
        $update_kho = "UPDATE kho SET sl = sl - ? WHERE id_sp = ?";
        $stmt_update_kho = $conn->prepare($update_kho);
        $stmt_update_kho->bind_param("ii", $so_luong, $id_sp);
        $stmt_update_kho->execute();
    }

    // 5. Thêm thông báo với thời gian chính xác
    $noi_dung = "Bạn vừa đặt thành công đơn hàng lúc $thoi_gian_hien_tai";
    $insert_thong_bao = "INSERT INTO thong_bao (id_kh, noi_dung) VALUES (?, ?)";
    $stmt_thong_bao = $conn->prepare($insert_thong_bao);
    $stmt_thong_bao->bind_param("is", $id_kh, $noi_dung);
    $stmt_thong_bao->execute();
}

// 6. Xử lý phương thức thanh toán
if (isset($_POST['pttt'])) {
    $pttt = $_POST["pttt"];
    if ($pttt === "cash") {
        echo "<script>alert('Đặt hàng thành công!!!');</script>";
        echo "<script>window.location.href = '../Home/index.php';</script>";
        exit();
    }
}

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo";
$amount = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["tongtien"];
}
if (isset($_SESSION["gia"])) {
    $amount = $_SESSION["gia"];
}
$orderId = time() . "";
$redirectUrl = "http://127.0.0.1:5500/Home/Index.php";
$ipnUrl = "http://127.0.0.1:5500/Home/Index.php";
$extraData = "";
$partnerCode = $partnerCode;
$accessKey = $accessKey;
$secretkey = $secretKey;
$orderId = $orderId;
$orderInfo = $orderInfo;
$amount = $amount;
$ipnUrl = $ipnUrl;
$redirectUrl = $redirectUrl;
$extraData = $extraData;

$requestId = time() . "";
$requestType = "payWithATM";
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretkey);
$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);
header('Location: ' . $jsonResult['payUrl']);
