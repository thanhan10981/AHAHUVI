<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/themsp_ad.css">
    <link rel="icon" href="../IMG/logo_admin.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thêm sản phẩm</title>
</head>

<body>
    <div class="than_admin">
        <?php require("../Admin/menu.php") ?>
        <div class="than_admin_phai">
            <div class="hienthimuc">
                <p>Thêm Sản Phẩm</p>
            </div>
            <?php

            require("../Home/connect.php");


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id_sp = isset($_POST['id_sp']) ? htmlspecialchars($_POST['id_sp']) : null;
                $product_name = isset($_POST['product-name']) ? htmlspecialchars($_POST['product-name']) : '';
                $danh_muc = isset($_POST['danh_muc']) ? intval($_POST['danh_muc']) : 0;
                $the_loai = isset($_POST['the_loai']) ? intval($_POST['the_loai']) : 0;
                $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
                $author = isset($_POST['author']) ? htmlspecialchars($_POST['author']) : '';
                $nxb = isset($_POST['nxb']) ? htmlspecialchars($_POST['nxb']) : '';
                $nha_xb = isset($_POST['nha_xb']) ? htmlspecialchars($_POST['nha_xb']) : '';
                $nha_cung_cap = isset($_POST['nha_cung_cap']) ? intval($_POST['nha_cung_cap']) : 0;
                $mo_ta = isset($_POST['mo_ta']) ? htmlspecialchars($_POST['mo_ta']) : '';
                $cover = isset($_FILES['cover']) ? $_FILES['cover'] : null;
                $additional_images = isset($_FILES['additional_images']) ? $_FILES['additional_images'] : null;


                $cover_path = '';
                if ($cover && $cover['error'] === 0) {
                    $cover_path = basename($cover['name']);
                    move_uploaded_file($cover['tmp_name'], '../uploads/' . $cover_path);
                }
                $bien_anh = '';  // Khởi tạo biến $bien_anh
                $allowedImages = [];
                $maxImages = 3;
                
                // Kiểm tra nếu có ảnh được tải lên
                if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'])) {
                    $totalImages = count($_FILES['additional_images']['name']);
                    
                    if ($totalImages > $maxImages) {
                        // Nếu có quá 3 ảnh, chỉ lấy 3 ảnh đầu tiên
                        echo 'Vui lòng chọn tối đa 3 ảnh!';
                    } else {
                        // Lặp qua từng ảnh được tải lên
                        for ($i = 0; $i < $totalImages; $i++) {
                            if ($_FILES['additional_images']['error'][$i] === 0) {
                                $imageName = basename($_FILES['additional_images']['name'][$i]);
                                $imageTmpName = $_FILES['additional_images']['tmp_name'][$i];
                                $imagePath = '../uploads/' . $imageName;
                                
                                // Kiểm tra loại ảnh và kích thước ảnh trước khi lưu
                                if (in_array(strtolower(pathinfo($imageName, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
                                    if (move_uploaded_file($imageTmpName, $imagePath)) {
                                        $allowedImages[] = $imageName;  // Lưu tên ảnh vào mảng
                                    } else {
                                        echo 'Không thể tải ảnh ' . $imageName . ' lên.';
                                    }
                                } else {
                                    echo 'Chỉ chấp nhận các định dạng ảnh: jpg, jpeg, png, gif.';
                                }
                            } else {
                                echo 'Lỗi khi tải ảnh lên. Vui lòng thử lại.';
                            }
                        }
                    }
                }
                
                // Chuyển mảng thành chuỗi phân tách bằng dấu phẩy
                $bien_anh = implode(',', $allowedImages);
                
                
                if ($id_sp) {
                    $gia_giam = "";
                    $phan_tram = "";
                    $stmt = $conn->prepare("UPDATE `san_pham` SET `ten_sp`= ?, `id_the_loai`= ?, `id_danh_muc`= ?, `gia`= ?, `gia_giam`= ?, `phan_tram`= ?, `anh_bia`= ?, `anh_phu`= ?, `tac_gia`= ?, `nxb`= ?, `nha_xb`= ?, `mo_ta`= ?, `id_ncc`= ? WHERE `id_sp` = ?");
                    $stmt->bind_param("ssssssssssssss", $product_name, $the_loai, $danh_muc, $price, $gia_giam, $phan_tram, $cover_path, $bien_anh, $author, $nxb, $nha_xb, $mo_ta, $nha_cung_cap, $id_sp);
                } else {
                    $gia_giam = "";
                    $phan_tram = "";
                    $stmt = $conn->prepare("INSERT INTO `san_pham` (`ten_sp`, `id_the_loai`, `id_danh_muc`, `gia`, `gia_giam`, `phan_tram`, `anh_bia`, `anh_phu`, `tac_gia`, `nxb`, `nha_xb`, `mo_ta`, `id_ncc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
                    $stmt->bind_param("sssssssssssss", $product_name, $the_loai, $danh_muc, $price, $gia_giam, $phan_tram, $cover_path, $bien_anh, $author, $nxb, $nha_xb, $mo_ta, $nha_cung_cap);
                }

                if ($stmt->execute()) {
                    echo "<script>alert('Cập nhật/hoặc thêm sản phẩm thành công!.'); </script>";
                } else {
                    echo "<script>alert('Cập nhật/hoặc thêm sản phẩm thất bại thành công!.'); </script>";
                }

                $stmt->close();
            }
            ?>
            <?php require('../Home/connect.php');
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $sql = "SELECT * FROM san_pham where id_sp ='$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $danhmuc_id = htmlspecialchars($row['id_danh_muc'] ?? '');
            $the_loai_id = htmlspecialchars($row['id_the_loai'] ?? '');
            $ncc_id = htmlspecialchars($row['id_ncc'] ?? '');
            $anh_bia = htmlspecialchars($row['anh_bia'] ?? '');
            $anh_phu = htmlspecialchars($row['anh_phu'] ?? '');
            ?>
           <form method="POST" enctype="multipart/form-data">
                <div class="nhom-dau-vao">
                    <label for="msp">Mã sản phẩm (MSP)</label>
                    <input type="text" id="msp" name="id_sp" placeholder="Nhập mã sản phẩm(hoặc để trống)" value="<?php echo htmlspecialchars($row['id_sp'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="product-name">Tên sản phẩm</label>
                    <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" value="<?php echo htmlspecialchars($row['ten_sp'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="category">Danh mục</label>
                    <select id="danh_muc" name="danh_muc">
                        <?php
                        if ($danhmuc_id) {
                            $stmt = $conn->prepare("SELECT `ten_danh_muc` FROM `danh_muc` WHERE `id_danh_muc` = ?");
                            $stmt->bind_param("i", $danhmuc_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $currentCategory = $result->fetch_assoc();
                                echo '<option value="' . $danhmuc_id . '" selected>' . htmlspecialchars($currentCategory['ten_danh_muc']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Chọn danh mục</option>';
                        }
                        $stmt = $conn->prepare("SELECT `id_danh_muc`, `ten_danh_muc` FROM `danh_muc`");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($currentCategory = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($currentCategory['id_danh_muc']) . '">' . htmlspecialchars($currentCategory['ten_danh_muc']) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="nhom-dau-vao">
                    <label for="type">Thể loại</label>
                    <select id="the_loai" name="the_loai">
                        <?php
                        if ($danhmuc_id) {
                            $stmt = $conn->prepare("SELECT `id_the_loai`, `ten_the_loai` FROM `the_loai` WHERE `id_danh_muc` = ?");
                            $stmt->bind_param("i", $danhmuc_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($currentType = $result->fetch_assoc()) {

                                    $selected = ($the_loai_id == $currentType['id_the_loai']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($currentType['id_the_loai']) . '" ' . $selected . '>' . htmlspecialchars($currentType['ten_the_loai']) . '</option>';
                                }
                            } else {
                                echo '<option value="">Chưa có thể loại</option>';
                            }
                        } else {
                            echo '<option value="">Chọn thể loại</option>';
                            echo '<select id="theloai" name="id_the_loai">
                            </select>';
                        }
                        ?>
                    </select>
                </div>

                <div class="nhom-dau-vao">
                    <label for="price">Giá</label>
                    <input type="text" id="price" name="price" placeholder="Nhập giá sản phẩm"
                        value="<?php echo isset($row['gia']) ? number_format(htmlspecialchars($row['gia'])) : ''; ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="author">Tác giả</label>
                    <input type="text" id="author" name="author" placeholder="Nhập tên tác giả"
                        value="<?php echo htmlspecialchars($row['tac_gia'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="nxb">Năm xuất bản (NXB)</label>
                    <input type="text" id="nxb" name="nxb" placeholder="Nhập năm xuất bản"
                        value="<?php echo htmlspecialchars($row['nxb'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="nsx">Nhà xuất bản (NXB)</label>
                    <input type="text" id="nha_xb" name="nha_xb" placeholder="Nhập nhà xuất bản" value="<?php echo htmlspecialchars($row['nha_xb'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="supplier">Nhà cung cấp (NCC)</label>
                    <select id="nha_cung_cap" name="nha_cung_cap">
                        <?php
                        if ($ncc_id) {
                            $stmt = $conn->prepare("SELECT `id_nhacungcap`, `ten_nhacungcap` FROM `nha_cung_cap` WHERE `id_nhacungcap` = ?");
                            $stmt->bind_param("i", $ncc_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $currentCategory = $result->fetch_assoc();
                                echo '<option value="' . htmlspecialchars($currentCategory['id_nhacungcap']) . '" selected>' . htmlspecialchars($currentCategory['ten_nhacungcap']) . '</option>';
                            }
                        } else {

                            echo '<option value="">Chọn nhà cung cấp</option>';
                        }
                        $stmt = $conn->prepare("SELECT `id_nhacungcap`, `ten_nhacungcap` FROM `nha_cung_cap`");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($currentCategory = $result->fetch_assoc()) {
                                if ($ncc_id != $currentCategory['id_nhacungcap']) {
                                    echo '<option value="' . htmlspecialchars($currentCategory['id_nhacungcap']) . '">' . htmlspecialchars($currentCategory['ten_nhacungcap']) . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="nhom-dau-vao">
                    <label for="supplier">Mô tả</label>
                    <input type="text" id="mo_ta" name="mo_ta" placeholder="Nhập mô tả" value="<?php echo htmlspecialchars($row['mo_ta'] ?? ''); ?>">
                </div>
                <div class="nhom-dau-vao">
                    <label for="cover">Bìa sách</label>
                    <input type="file" id="cover" name="cover" accept="image/*">
                    <div class="hien-thi-anh" id="cover-preview">
                        <?php if ($anh_bia) {
                            echo '<div class="khung-anh">
                            <img src="../IMG/' . htmlspecialchars($anh_bia) . '" alt="Bìa sách">
                             </div>';
                        } else {
                        }
                        ?>
                    </div>
                </div>
                <div class="nhom-dau-vao">
                    <label for="additional-images">Ảnh phụ</label>
                    <input type="file" id="additional-images" name="additional_images[]" accept="image/*" multiple>

                    <div class="hien-thi-anh-nhieu" id="additional-images-preview">
                        <?php
                        if ($anh_phu) {
                            $ds_anh = explode(',', $anh_phu);
                            foreach ($ds_anh as $imagePath) {
                                if (!empty(trim($imagePath))) {
                                    echo '<div class="khung-anh">
                                            <img src="../' . htmlspecialchars(trim($imagePath)) . '" alt="Ảnh phụ">
                                            </div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="nut-bieu-mau">
                    <button type="submit" name="add_product">CẬP NHẬT</button>
                    <button type="submit" name="add_product">THÊM</button>
                </div>
            </form>
        </div>
    </div>

</body>
<script src="../Js/xu_ly_them_sp_ad.js"></script>
<script>
    document.getElementById('additional-images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('additional-images-preview');
        const files = event.target.files;

        if (files.length > 0) {
            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('khung-anh');

                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.alt = 'Ảnh phụ';

                    imgContainer.appendChild(imgElement);
                    previewContainer.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    function previewImage() {
    const fileInput = document.getElementById('cover');
    const file = fileInput.files[0]; 
    const previewDiv = document.getElementById('cover-preview');

    if (file) {
        const reader = new FileReader(); 
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result; 
            img.alt = 'Bìa sách';
            previewDiv.innerHTML = '';
            previewDiv.appendChild(img);
        };
        reader.readAsDataURL(file);
    } else {
        previewDiv.innerHTML = '';
    }
}

</script>

</html>