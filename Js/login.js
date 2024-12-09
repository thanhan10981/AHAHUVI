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

//maOTP

function sendOtp() {
    const phoneNumber = document.getElementById('phone-number').value;
    if (phoneNumber) {
        // Tạo mã OTP ngẫu nhiên 6 ký tự
        const otp = Math.floor(100000 + Math.random() * 900000);
        
        // Hiển thị mã OTP hoặc có thể gửi qua API trong thực tế
        document.getElementById('otp-message').textContent = `Mã OTP của bạn là: ${otp}`;
        
        // Đặt thời gian hiển thị OTP (tùy chọn)
        setTimeout(() => {
            document.getElementById('otp-message').textContent = ''; // Xóa OTP sau 30 giây
        }, 30000);
    } else {
        alert("Vui lòng nhập số điện thoại.");
    }
}


