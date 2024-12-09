<?php
session_start();
unset($_SESSION['id_kh']);
session_destroy(); 
header("Location: ../Home/login.php"); 
exit();
?>