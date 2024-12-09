function autoSubmitForm(inputElement, previewContainer, multiple = false) {
    const form = document.getElementById('uploadForm');
    const files = inputElement.files;

    if (!files) return;

    // Hiển thị ảnh ngay khi chọn
    if (!multiple) previewContainer.innerHTML = ''; // Xóa nội dung cũ với ảnh đơn

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            const khungAnh = document.createElement('div');
            khungAnh.className = 'khung-anh';
            khungAnh.appendChild(img);
            previewContainer.appendChild(khungAnh);
        };
        reader.readAsDataURL(file);
    });

    // Tự động gửi form
    setTimeout(() => form.submit(), 500); // Trì hoãn nhẹ để hiển thị ảnh trước
}

// Bắt sự kiện cho ảnh bìa
document.getElementById('cover').addEventListener('change', function() {
    const preview = document.getElementById('cover-preview');
    autoSubmitForm(this, preview);
});

// Bắt sự kiện cho ảnh phụ
document.getElementById('additional-images').addEventListener('change', function() {
    const preview = document.getElementById('additional-images-preview');
    autoSubmitForm(this, preview, true);
});