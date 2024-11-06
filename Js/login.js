document.addEventListener('DOMContentLoaded', function() {
    const loginLink = document.querySelector('.login');
    const registerLink = document.querySelector('.register');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    loginLink.addEventListener('click', function() {
        loginForm.classList.add('active');
        registerForm.classList.remove('active');
        loginLink.classList.add('active');
        registerLink.classList.remove('active');
    });

    registerLink.addEventListener('click', function() {
        registerForm.classList.add('active');
        loginForm.classList.remove('active');
        registerLink.classList.add('active');
        loginLink.classList.remove('active');
    });
});


function checkInput() {
    var username = document.getElementById("login_email").value;
    var password = document.getElementById("login_password").value;
    var submitBtn = document.getElementById("login");

    // Kiểm tra nếu tài khoản và mật khẩu không trống
    if (login_email !== "" && login_password !== "") {
        login.disabled = false;  // Mở khóa nút
        login.classList.add("enabled"); // Thêm lớp CSS "enabled"
    } else {
        login.disabled = true;  // Khóa nút nếu chưa nhập đủ thông tin
        login.classList.remove("enabled"); // Xóa lớp CSS "enabled"
    }
}



document.addEventListener("DOMContentLoaded", function() {
    const loginLink = document.querySelector('.nav-links .login');
    const registerLink = document.querySelector('.nav-links .register');

    loginLink.addEventListener('click', function(e) {
        e.preventDefault();
        loginLink.classList.add('active');
        registerLink.classList.remove('active');
        showLoginForm();
    });

    registerLink.addEventListener('click', function(e) {
        e.preventDefault();
        registerLink.classList.add('active');
        loginLink.classList.remove('active');
        showRegisterForm();
    });

    function showLoginForm() {
        const registerForm = document.querySelector('.form-container.register');
        const loginForm = document.querySelector('.form-container.login');
        if (registerForm) registerForm.classList.remove('active');
        if (loginForm) loginForm.classList.add('active');
    }

    function showRegisterForm() {
        const registerForm = document.querySelector('.form-container.register');
        const loginForm = document.querySelector('.form-container.login');
        if (loginForm) loginForm.classList.remove('active');
        if (registerForm) registerForm.classList.add('active');
    }
});


