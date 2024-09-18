document.addEventListener("DOMContentLoaded", function() {
    let viTriHienTai = 0;
    const hinhAnh = document.querySelectorAll('.image-container img');
    const cacCham = document.querySelectorAll('.dot');

    function hienThiAnh(viTri) {
        //hiển thị ảnh phần tự chuyển ảnh
        hinhAnh.forEach(img => img.classList.remove('active'));
        hinhAnh[viTri].classList.add('active');
        //hiển thị ảnh phần bấm nút chuyển ảnh bằng nút dot
        cacCham.forEach(dot => dot.classList.remove('active'));
        cacCham[viTri].classList.add('active');
    }

    function chuyenAnh(viTriMoi) {
        viTriHienTai = viTriMoi;
        hienThiAnh(viTriHienTai);
    }

    function chuyenAnhTruoc() {
        viTriHienTai = (viTriHienTai - 1 + hinhAnh.length) % hinhAnh.length;
        hienThiAnh(viTriHienTai);
    }

    function chuyenAnhSau() {
        viTriHienTai = (viTriHienTai + 1) % hinhAnh.length;
        hienThiAnh(viTriHienTai);
    }
    const nutAnhTruoc = document.querySelector('.prev');
    const nutAnhSau = document.querySelector('.next');
    //khi click vào nút chuyển thi sẽ chuyển ảnh
    nutAnhTruoc.addEventListener('click', chuyenAnhTruoc);
    nutAnhSau.addEventListener('click', chuyenAnhSau);
    //lấy vị trí ảnh để chuyển ảnh
    cacCham.forEach(function(dot, index) {
        dot.addEventListener('click', function() {
            chuyenAnh(index);
        });
    });

    // Xử lý sự kiện hiện/ẩn các nút khi rê chuột vào/ra
    function showControls() {
        document.querySelectorAll('.prev, .next').forEach(btn => btn.style.opacity = '1');
    }

    function hideControls() {
        document.querySelectorAll('.prev, .next').forEach(btn => btn.style.opacity = '0');
    }

    setInterval(chuyenAnhSau, 5000); // Tự động chuyển ảnh sau mỗi 5 giây
});