// Hiện tất cả mục khi nhấn "Xem thêm" cho Thể Loại
document.querySelector('.nutxemthem').addEventListener('click', function() {
    const items = document.querySelectorAll('.theloai-list li');
    items.forEach(item => item.style.display = 'list-item'); // Hiển thị tất cả các mục

    this.style.display = 'none'; // Ẩn nút "Xem thêm"
    document.querySelector('.rutgon').style.display = 'block'; // Hiển thị nút "Rút gọn"
});

// Rút gọn lại khi nhấn "Rút gọn" cho Thể Loại
document.querySelector('.rutgon').addEventListener('click', function() {
    const items = document.querySelectorAll('.theloai-list li');
    items.forEach((item, index) => {
        if (index >= 8) {
            item.style.display = 'none'; // Ẩn các mục sau mục thứ 8
        }
    });

    document.querySelector('.nutxemthem').style.display = 'block'; // Hiển thị lại nút "Xem thêm"
    this.style.display = 'none'; // Ẩn nút "Rút gọn"
});

// Hiện tất cả mục khi nhấn "Xem thêm" cho Nhà Cung Cấp
document.querySelector('.nutxemthem-ncc').addEventListener('click', function() {
    const items = document.querySelectorAll('.ncc-list li');
    items.forEach(item => item.style.display = 'list-item'); // Hiển thị tất cả các mục

    this.style.display = 'none'; // Ẩn nút "Xem thêm"
    document.querySelector('.rutgon-ncc').style.display = 'block'; // Hiển thị nút "Rút gọn"
});

// Rút gọn lại khi nhấn "Rút gọn" cho Nhà Cung Cấp
document.querySelector('.rutgon-ncc').addEventListener('click', function() {
    const items = document.querySelectorAll('.ncc-list li');
    items.forEach((item, index) => {
        if (index >= 8) {
            item.style.display = 'none'; // Ẩn các mục sau mục thứ 8
        }
    });

    document.querySelector('.nutxemthem-ncc').style.display = 'block'; // Hiển thị lại nút "Xem thêm"
    this.style.display = 'none'; // Ẩn nút "Rút gọn"
});

function filterByPrice(min, max) {
    let url = new URL(window.location.href);
    url.searchParams.set('gia', min + '-' + (max === null ? 'null' : max));
    window.location.href = url.toString();
}

function clearPriceFilter() {
    // Xóa giá trị của bộ lọc giá trong URL
    const url = new URL(window.location.href);
    url.searchParams.delete('gia'); // Xóa tham số 'gia'

    // Chuyển hướng đến URL đã cập nhật
    window.location.href = url.toString();
}

function selectSupplier(supplierName, supplierId) {
    let url = new URL(window.location.href);
    url.searchParams.set('nhacungcap', supplierName);
    url.searchParams.set('id_nhacungcap', supplierId);
    window.location.href = url.toString();
}


function clearSupplierFilter() {
    // Xóa tham số 'nhacungcap' khỏi URL
    var url = new URL(window.location.href);
    url.searchParams.delete('nhacungcap');
    window.location.href = url.toString();
}

function filterBySupplier(supplier) {
    const url = new URL(window.location.href);
    url.searchParams.set('nhacungcap', supplier); // Thêm hoặc cập nhật nhà cung cấp
    window.location.href = url.toString(); // Tải lại trang với URL mới
}