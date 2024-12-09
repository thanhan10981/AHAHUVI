document.addEventListener('DOMContentLoaded', function() {
    var showPassIcon = document.querySelector('.toggle-password');
    var passInput = document.getElementById('password-field');

    // Ẩn mật khẩu khi trang được tải
    passInput.type = 'password';
    showPassIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';

    showPassIcon.addEventListener('click', function() {
        if (passInput.type === 'password') {
            passInput.type = 'text';
            showPassIcon.innerHTML = '<i class="fas fa-eye"></i>';
        } else {
            passInput.type = 'password';
            showPassIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
        showPassIcon.classList.toggle('active');
    });
});