<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Menu</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../Css/menu_ad.css">
</head>

<body>

  <div class="sidebar">
    <div class="header">
      <?php
      require("../Home/connect.php");
      $sql = "SELECT COUNT(ma_kh) AS total_kh FROM ho_tro";
      $result = $conn->query($sql);
      $sl = 0; 
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sl = $row['total_kh'];
      }
      echo'<a class="thong_bao" href="#">';
       echo' <i class="fa-regular fa-bell"></i>';
         if ($sl > 0){
         echo' <span class="dot"></span> ';
         echo'<div class="tb-form" id="tb_Form">
         <a href="#">Bạn có thông báo mới</a><br><br>
         <a href="../Admin/hotrokh.php">Hổ trợ khách hàng 🔔</a>
       </div>';
         }else{
          echo'<div class="tb-form" id="tb_Form">
          <a href="#">Chưa có thông báo</a>
        </div>';
         }
     echo' </a>';
      ?>
      <a class="account" href="#"><i class="fa-solid fa-user"></i></a>
      <div class="dropdown-form" id="accountForm">
        <a href="../Admin/thong_tin_tkad.php"><i class="fa-regular fa-user"></i> Thông tin tài khoản</a><br><br>
        <a href="../Admin/logout.php" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?');"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
      </div>
    </div>
    <div class="profile">
      <img src="../IMG/logo_admin.png" alt="User">
      <?php
      session_start();
      if (isset($_SESSION["ma_tai_khoan"])) {
        $ma_tai_khoan = $_SESSION["ma_tai_khoan"];
        $_SESSION["ma_tai_khoan"] = $ma_tai_khoan;
        echo '<h3>' . $ma_tai_khoan . '</h3>';
      } else {
        header("Location: ../Admin/dangnhapadmin.php");
        exit;
      }
      ?>
      <p>Chào mừng bạn trở lại</p>
    </div>
    <div class="menu">
      <div class="menu-item" id="as1">
        <a href="../Admin/index.php">
          <i class="icon">&#128187;</i>
          <span>Bảng điều khiển</span></a>
      </div>
      <div class="menu-item"id="as2">
        <a href="../Admin/quanly_nhanvien.php">
        <i class="icon">&#128100;</i>
        <span>Quản lý nhân viên</span></a>
      </div>

      <div class="menu-item"id="as3">
        <a href="../Admin/quan_ly_khach_hang.php">
        <i class="icon">&#128101;</i>
        <span>Quản lý khách hàng</span></a>
      </div>

      <div class="menu-item"id="as4" onclick="toggleDropdown(this)">
        <i class="icon">&#128218;</i>
        <span>Quản lý sản phẩm</span>
      </div>
      <div class="submenu">
        <a href="../Admin/dssp_ad.php" class="submenu-item">Danh sách sản phẩm</a>
        <a href="../Admin/themsp_ad.php" class="submenu-item">Thêm sản phẩm</a>
        <a href="../Admin/dstheloai.php" class="submenu-item">Danh sách thể loại</a>
        <a href="../Admin/dsdanhmuc.php" class="submenu-item">Danh sách danh mục</a>
        <a href="../Admin/ds_ncc.php" class="submenu-item">Danh sách nhà cung cấp</a>
        <a href="../Admin/kho_ad.php" class="submenu-item">Kho sản phẩm</a>
      </div>

      <div class="menu-item" id="as5" onclick="toggleDropdown(this)">
        <i class="icon">&#128221;</i>
        <span>Quản lý đơn hàng</span>
      </div>
      <div class="submenu">
      <a href="../Admin/don_hang.php" class="submenu-item">Đơn hàng</a>
        <a href="../Admin/chitietdonhang.php" class="submenu-item">Chi tiết đơn hàng</a>
      </div>

      <div class="menu-item"id="as6" onclick="toggleDropdown(this)">
        <i class="icon">&#128203;</i>
        <span>Cập nhập Website</span>
      </div>
      <div class="submenu">
        <a href="../Admin/quang_cao.php" class="submenu-item">Quảng cáo</a>
        <a href="../Admin/giagiam_ad.php" class="submenu-item">Danh sách sản phẩm giảm giá</a>
      </div>

      <div class="menu-item" id="as7">
        <a href="../Admin/giam_gia.php">
        <i class="icon">&#128178;</i>
        <span>Giảm giá</span></a>
      </div>

      <div class="menu-item" id="as8">
        <a href="../Admin/bao_cao_doanh_thu.php">
        <i class="icon">&#128200;</i>
        <span>Báo cáo doanh thu</span></a>
      </div>

      <div class="menu-item"id="as9">
        <a href="../Admin/hotrokh.php">
        <i class="icon">&#128197;</i>
        <span>Hổ trợ khách hàng</span></a>
      </div>
    
    </div>
  </div>

  <script>
    function toggleDropdown(element) {
      const submenu = element.nextElementSibling;
      if (submenu && submenu.classList.contains('submenu')) {
        submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
      }
    }

    document.querySelector('.account').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('accountForm').classList.toggle('show');
    });


    document.addEventListener('click', function(event) {
      var form = document.getElementById('accountForm');
      var icon = document.querySelector('.account');
      if (!form.contains(event.target) && !icon.contains(event.target)) {
        form.classList.remove('show');
      }
    });
    document.querySelector('.thong_bao').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('tb_Form').classList.toggle('show1');
    });


    document.addEventListener('click', function(event) {
      var form = document.getElementById('tb_Form');
      var icon = document.querySelector('.thong_bao');
      if (!form.contains(event.target) && !icon.contains(event.target)) {
        form.classList.remove('show1');
      }
    });
  </script>

</body>

</html>