<?php
require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/Exception.php";
require_once "../PHPMailer/src/POP3.php";
require_once "../PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Tạo mã xác nhận
        $confirmationCode = mt_rand(100000, 999999);
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['code'] = $confirmationCode;
        // Gửi email xác nhận
        $mail = new PHPMailer(true);
        try {
            // Cấu hình mailer
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com;';
            $mail->SMTPAuth = true;
            $mail->Username = 'hanhan3316@gmail.com'; // Thay thế bằng địa chỉ email của bạn
            $mail->Password = 'mxfh uazf bhim lmgp'; // Thay thế bằng mật khẩu của bạn
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Thiết lập thông tin người gửi và người nhận
            $mail->setFrom('hanhan3316@gmail.com', 'Ahahuvi');
            $mail->addAddress($email);
            $mail->isHTML(true);

            // Thiết lập tiêu đề và nội dung email
            $mail->Subject = 'Password recovery confirmation code';
            $mail->Body = 'Your confirmation code is: ' . $confirmationCode;

            // Gửi email
            $mail->send();

            // Chuyển hướng người dùng đến trang nhập mã xác nhận
            header('Location: ../Home/xacnhan_mail.php?email=' . $email);
            exit();
        } catch (Exception $e) {
            // Xử lý khi gửi email thất bại
            echo 'Không thể gửi tin nhắn. Lỗi gửi thư: ', $mail->ErrorInfo;
        }
    } else {
        // Trường email không được gửi từ form
        echo "Không nhận được địa chỉ email từ form";
    }
}
?>
