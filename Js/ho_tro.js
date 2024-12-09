document.addEventListener('DOMContentLoaded', function() {
    const supportButton = document.getElementById('support-button');
    const supportForm = document.getElementById('support-form');
    const closeForm = document.getElementById('close-form');

    // Hiển thị form khi bấm vào nút hỗ trợ
    supportButton.addEventListener('click', function() {
        supportForm.classList.remove('hidden');
    });

    // Ẩn form khi bấm vào nút đóng
    closeForm.addEventListener('click', function() {
        supportForm.classList.add('hidden');
    });
});