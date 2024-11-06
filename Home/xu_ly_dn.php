<?php

session_start();

if(isset($_POST['login'])){
    require "../Home/connect.php"; 
       // Khởi tạo biến login_attempts nếu chưa có
       if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    // Kiểm tra xem người dùng đã vượt quá giới hạn đăng nhập chưa
    if ($_SESSION['login_attempts'] >= 5) {
        echo "Bạn đã vượt quá số lần đăng nhập cho phép. Vui lòng thử lại sau.";
        exit();
    }
    $email = $_POST["login_email"];
    $password = $_POST["login_password"];
echo $email,$password;
    $sql = "SELECT * FROM khach_hang WHERE sdt='$email' AND mk = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
       // Đăng nhập thành công
       $_SESSION['login_attempts'] = 0; // Đặt lại số lần đăng nhập sai
       header("location:../Home/index.php");
       exit();
   } else {
       // Tăng số lần đăng nhập sai
       $_SESSION['login_attempts'] += 1; 
       echo "Sai thông tin đăng nhập. Bạn còn " . (5 - $_SESSION['login_attempts']) . " lần thử.";
   }
} else {
   echo "Không có dữ liệu.";
}


    public function forgetPass()
    {
        return view('forgetPass');
    }

    public function postForgetPass(Request $req)
    {
        $req->validate([
            'email' => 'required|exists:khach_hang',
        ],[
            'email.required' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'email.exists' => 'Email này không tồn tại trong hệ thống',
        ]);

        $token = strtoupper(Str::random(10));
        $khach_hang = khach_hang::where('email', $req->email)->first();
        $khach_hang->update(['token'=> $token]);

        Mail::send('email.check_email_forget', compact('khach_hang'), function($email) use($khach_hang) {
            $email->subject('Lấy lại mật khẩu');
            $email->to($khach_hang->email,$khach_hang->name);
            return redirect()->back('login.php')->with('yes','Vui lòng check email để thực hiện thay đổi mật khẩu');
        }
    }
?>