<div id="support-button">
    <img src="../IMG/ho_tro.png" alt="Support Icon" />
</div>

<!-- Form hỗ trợ trực tuyến -->
<div id="support-form" class="hidden">
    <div class="header">
        <h2>Hỗ trợ trực tuyến</h2>
        <p>Sẵn lòng giải đáp mọi thắc mắc</p>
        <button id="close-form">&times;</button>
    </div>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Nhập tên của bạn*" required />
        <input type="email" name="email" placeholder="Nhập email của bạn" />
        <input type="text" name="phone" placeholder="Nhập số điện thoại của bạn *" required />
        <select name="service">
            <option value="">--- Chọn 1 dịch vụ hỗ trợ ---</option>
            <option value="Tu-van-online">Tư vấn online</option>
            <option value="Cham-soc-khach-hang">Chăm sóc khách hàng</option>
        </select>
        <textarea name="message" placeholder="Nhập tin nhắn..."></textarea>
        <button type="submit">Bắt đầu trò chuyện</button>
    </form>
</div>
<?php
$name = isset($_POST['name']) ? $_POST['name'] : "";

// Kiểm tra nếu form được gửi (POST) và chưa xử lý trong session
if ($name && !isset($_SESSION['form_submitted'])) {
    if (isset($_SESSION["id_kh"])) {
        $id_kh = $_SESSION["id_kh"];
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $service = htmlspecialchars($_POST['service']);
        $message = htmlspecialchars($_POST['message']);

        // Kiểm tra dữ liệu bắt buộc
        if (empty($name) || empty($phone)) {
            echo "Tên và số điện thoại là bắt buộc.";
            exit;
        }

        $email = empty($email) ? null : $email;
        $message = empty($message) ? null : $message;
        $ngay_tao = date("Y-m-d H:i:s");
        $trang_thai = "Chờ xử lý";
        require("../Home/connect.php");
        $sql = "INSERT INTO ho_tro (ma_kh, ten_kh, sdt, email, dich_vu, noi_dung, ngay_tao, trang_thai)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $id_kh, $name, $phone, $email, $service, $message, $ngay_tao, $trang_thai);

        if ($stmt->execute()) {
            echo "<script>alert('Yêu cầu được gửi thành công!.');</script>";
            $_SESSION['form_submitted'] = true; // Đánh dấu đã xử lý form
            header("Location: " . $_SERVER['PHP_SELF']); // Chuyển hướng để làm mới trạng thái
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Bạn cần đăng nhập để gửi yêu cầu hỗ trợ!.');</script>";
    }
}

// Xóa cờ sau khi chuyển hướng hoặc qua lần truy cập mới
if (isset($_SESSION['form_submitted']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    unset($_SESSION['form_submitted']);
}
?>
