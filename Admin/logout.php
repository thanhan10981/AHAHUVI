<?php
session_start();
unset($_SESSION['ma_tai_khoan']);
session_destroy(); 
header("Location: ../Admin/dangnhapadmin.php"); 
exit();
?>