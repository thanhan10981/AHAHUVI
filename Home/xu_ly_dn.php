<?php
session_start();
if (isset($_POST['login'])) {
    require "../Home/connect.php";
    $sodt = $_POST["so_dt"];
    $password = $_POST["password"];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM khach_hang WHERE sdt = ? AND mk = ?");
    $stmt->bind_param("ss", $sodt, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $id_kh = "";
        $sql_check = "SELECT mkh FROM khach_hang WHERE sdt ='$sodt'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $id_kh = $row["mkh"];
        }
        $_SESSION["id_kh"] = $id_kh;
        echo "<script>
        alert('Đăng nhập thành công!');window.location.href = '../Home/account.php?tabs=hscn';</script>";
    exit();
        
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "No data received.";
}
