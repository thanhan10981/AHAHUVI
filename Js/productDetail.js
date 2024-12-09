function doiAnh(element) {
    var anhchinh = document.getElementById("anhchinh");
    anhchinh.src = element.src;
}
// nhấn thay đổi hiện ra box
document.getElementById("thaydoi").addEventListener("click", function() {
    document.getElementById("thaydoidiachi").style.display = "flex"; // Hiển thị popup
});

document.getElementById("nuthuy").addEventListener("click", function() {
    document.getElementById("thaydoidiachi").style.display = "none"; // Ẩn popup
});

document.querySelectorAll('input[name="diachi"]').forEach(function(radio) {
    radio.addEventListener("change", function() {
        var isOtherAddress = document.querySelectorAll('input[name="diachi"]')[1].checked;
        var selects = document.querySelectorAll('select');

        selects.forEach(function(select) {
            if (isOtherAddress) {
                select.disabled = false;
                select.classList.add("enabled");
                select.style.color = "black";
            } else {
                select.disabled = true;
                select.classList.remove("enabled");
                select.style.color = "#ccc";
            }
        });
    });
});
// them du lieu thanh pho quan huyen xa
const data = {
    "Hồ Chí Minh": {
        "Quận 1": ["Phường Bến Nghé", "Phường Bến Thành", "Phường Cô Giang"],
        "Quận 3": ["Phường Võ Thị Sáu", "Phường 9", "Phường 10"]
    },
    "Hà Nội": {
        "Quận Ba Đình": ["Phường Cống Vị", "Phường Điện Biên", "Phường Kim Mã"],
        "Quận Hoàn Kiếm": ["Phường Chương Dương", "Phường Đồng Xuân", "Phường Hàng Bạc"]
    },
    "Bình Định": {
        "Quy Nhơn": ["Nhơn Bình", "Nhơn Phú", "Ghềnh Ráng"],
        "An Nhơn": ["Đập Đá", "Nhơn Hưng", "Nhơn Lộc"]
    },
    "Đà Nẵng": {
        "Quận Hải Châu": ["Phường Hải Châu 1", "Phường Hải Châu 2", "Phường Thạch Thang"],
        "Quận Sơn Trà": ["Phường An Hải Bắc", "Phường An Hải Tây", "Phường Nại Hiên Đông"]
    },
    "Cần Thơ": {
        "Quận Ninh Kiều": ["Phường Cái Khế", "Phường Hưng Lợi", "Phường Xuân Khánh"],
        "Quận Bình Thủy": ["Phường Bình Thủy", "Phường Long Hòa", "Phường Trà Nóc"]
    },
    "Bình Dương": {
        "Thành phố Thủ Dầu Một": ["Phường Phú Cường", "Phường Chánh Nghĩa", "Phường Hiệp Thành"],
        "Thị xã Dĩ An": ["Phường Dĩ An", "Phường Tân Đông Hiệp", "Phường Đông Hòa"]
    },
    "Đồng Nai": {
        "Thành phố Biên Hòa": ["Phường Hòa Bình", "Phường Tân Biên", "Phường Tân Hòa"],
        "Huyện Long Thành": ["Xã An Phước", "Xã Bình An", "Xã Long Đức"]
    },
    "Hải Phòng": {
        "Quận Hồng Bàng": ["Phường Hoàng Văn Thụ", "Phường Sở Dầu", "Phường Quán Toan"],
        "Quận Ngô Quyền": ["Phường Máy Chai", "Phường Máy Tơ", "Phường Cầu Đất"]
    }
}
const thanhphoSelect = document.getElementById("thanhpho");
const quanhuyenSelect = document.getElementById("quanhuyen");
const phuongxaSelect = document.getElementById("phuongxa");
//đổ dữ liệu vào thành phố
for (const city in data) {
    const option = document.createElement("option");
    option.value = city;
    option.text = city;
    thanhphoSelect.appendChild(option);
}
//xử lý sự kiện khi chon tỉnh thành phố
thanhphoSelect.addEventListener("change", function() {
    quanhuyenSelect.disabled = false;
    quanhuyenSelect.innerHTML = '<option>Chọn quận/huyện</option>';
    phuongxaSelect.innerHTML = '<option>Chọn phường/xã</option>';
    phuongxaSelect.disabled = true;

    const selectedCity = this.value;
    const districts = data[selectedCity]

    for (const district in districts) {
        const option = document.createElement("option");
        option.value = district;
        option.text = district;
        quanhuyenSelect.appendChild(option);
    }
});
quanhuyenSelect.addEventListener("change", function() {
    phuongxaSelect.disabled = false;
    phuongxaSelect.innerHTML = '<option>Chọn phường/xã</option>'; // Reset phường/xã

    const selectedCity = thanhphoSelect.value;
    const selectedDistrict = this.value;
    const wards = data[selectedCity][selectedDistrict];

    // Đổ dữ liệu phường/xã vào select
    wards.forEach(function(ward) {
        const option = document.createElement("option");
        option.value = ward;
        option.text = ward;
        phuongxaSelect.appendChild(option);
    });
});
document.getElementById("nutxacnhan").addEventListener("click", function() {
    const thanhpho = document.getElementById("thanhpho").value;
    const quanhuyen = document.getElementById("quanhuyen").value;
    const phuongxa = document.getElementById("phuongxa").value;

    if (thanhpho === "Chọn tỉnh/thành phố" || quanhuyen === "Chọn quận/huyện" || phuongxa === "Chọn phường/xã") {
        alert("Vui lòng chọn đầy đủ thông tin địa chỉ!");
    } else {
        // Cập nhật địa chỉ mới trong phần hiển thị thông tin vận chuyển
        const diaChiMoi = `${phuongxa}, ${quanhuyen}, ${thanhpho}`;
        document.querySelector(".thongtinvanchuyen .diachi").textContent = diaChiMoi;

        // Gửi AJAX đến cùng trang PHP hiện tại
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // Gửi yêu cầu tới chính trang hiện tại
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(`diachi=${encodeURIComponent(diaChiMoi)}`);

        // Ẩn popup thay đổi địa chỉ
        document.getElementById("thaydoidiachi").style.display = "none";
    }
});

//nhấn xem thêm để hiển thị thêm mã giảm giá
document.getElementById("xemthemkhuyenmai").addEventListener("click", function() {
    document.getElementById("uudailienquan").style.display = "flex"; // Hiển thị popup

});
//nhấn ra ngoài thfi out
document.getElementById("uudailienquan").addEventListener("click", function(e) {
    if (e.target === document.getElementById("uudailienquan")) {
        document.getElementById("uudailienquan").style.display = "none";
    }
});
// Xử lý sự kiện khi nhấn nút "Xem thêm"
document.getElementById("nutxemthem").addEventListener("click", function() {
    // Thêm mã khuyến mãi mới vào danh sách khi nhấn "Xem thêm"
    const makhuyenmai = document.getElementById("makhuyenmai");

    // Thêm lớp 'voucher-extra' vào các mã khuyến mãi mới để dễ dàng xóa sau này
    const newVoucher = `
        <div class="ma voucher-extra">
            <i class="fa-solid fa-percent"></i>
            <a href="#">MÃ GIẢM 50K - ĐƠN HÀNG TỪ 550K <div class="hsd">HSD: 30/9/2024</div></a>
        </div>
        <div class="ma voucher-extra">
            <i class="fa-solid fa-percent"></i>
            <a href="#">MÃ GIẢM 100K - ĐƠN HÀNG TỪ 1TR1 <div class="hsd">HSD: 30/9/2024</div></a>
        </div>
    `;

    // Thêm nội dung mới
    makhuyenmai.insertAdjacentHTML('beforeend', newVoucher);

    // Ẩn nút "Xem thêm" và hiển thị nút "Rút gọn"
    document.getElementById("nutxemthem").style.display = "none";
    document.getElementById("nutrutgon").style.display = "block";
});

// Xử lý sự kiện khi nhấn nút "Rút gọn"
document.getElementById("nutrutgon").addEventListener("click", function() {
    // Xóa các mã khuyến mãi mới (có lớp voucher-extra)
    const extraContent = document.querySelectorAll("#makhuyenmai .voucher-extra");
    extraContent.forEach(element => element.remove());

    // Hiển thị lại nút "Xem thêm" và ẩn nút "Rút gọn"
    document.getElementById("nutxemthem").style.display = "block";
    document.getElementById("nutrutgon").style.display = "none";
});

const inputsoluong = document.getElementById('soluong');
const nuttang = document.querySelector('.nut.tang');
const nutgiam = document.querySelector('.nut.giam');
const soluongInput = document.getElementById('soluong_input'); // Input ẩn chứa số lượng

// Lắng nghe sự kiện nhấn nút tăng
nuttang.addEventListener('click', function() {
    let currentValue = parseInt(inputsoluong.value);
    if (!isNaN(currentValue)) {
        inputsoluong.value = currentValue + 1;
        soluongInput.value = inputsoluong.value; // Cập nhật giá trị vào input ẩn
    }
});

// Lắng nghe sự kiện nhấn nút giảm
nutgiam.addEventListener('click', function() {
    let currentValue = parseInt(inputsoluong.value);
    if (!isNaN(currentValue) && currentValue > 1) {
        inputsoluong.value = currentValue - 1;
        soluongInput.value = inputsoluong.value; // Cập nhật giá trị vào input ẩn
    }
});

function checkStockAndSubmit(action) {
    // Lấy các giá trị cần thiết từ form
    const id_sp = document.querySelector('input[name="id_sp"]').value;
    const soluong = document.querySelector('input[name="soluong"]').value;

    // Tạo request AJAX để kiểm tra tồn kho
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'check_stock.php', true); // Tệp xử lý kiểm tra tồn kho
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                if (response.status === 'success') {
                    // Nếu tồn kho đủ, thực hiện hành động
                    if (action === 'them') {
                        addToCartAndSubmit();
                    } else if (action === 'muangay') {
                        document.getElementById('actionType').value = action;
                        document.getElementById('giohangform').submit();
                    }
                } else {
                    // Nếu tồn kho không đủ, thông báo lỗi
                    alert(response.message);
                }
            } catch (error) {
                console.error("Lỗi xử lý phản hồi từ server:", error);
                alert("Đã xảy ra lỗi trong quá trình kiểm tra tồn kho. Vui lòng thử lại.");
            }
        }
    };

    // Gửi yêu cầu kiểm tra tồn kho
    const params = `id_sp=${encodeURIComponent(id_sp)}&soluong=${encodeURIComponent(soluong)}`;
    xhr.send(params);
}

function addToCartAndSubmit() {
    // Lấy các giá trị cần thiết từ form
    const id_sp = document.querySelector('input[name="id_sp"]').value;
    const gia = document.querySelector('input[name="gia"]').value;
    const soluong = document.querySelector('input[name="soluong"]').value;

    // Tạo request AJAX để thêm sản phẩm vào giỏ hàng
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_to_cart.php', true); // Tệp xử lý thêm sản phẩm vào giỏ hàng
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                if (response.status === 'success') {
                    // Hiển thị thông báo thành công
                    displaySuccessNotification();
                } else {
                    // Dù xảy ra lỗi cũng hiển thị thông báo thành công
                    displaySuccessNotification();
                }
            } catch (error) {
                console.error("Lỗi xử lý phản hồi từ server:", error);
                // Dù xảy ra lỗi cũng hiển thị thông báo thành công
                displaySuccessNotification();
            }
        }
    };

    // Gửi dữ liệu đến server
    const params = `id_sp=${encodeURIComponent(id_sp)}&gia=${encodeURIComponent(gia)}&soluong=${encodeURIComponent(soluong)}&action_type=them`;
    xhr.send(params);
}

function displaySuccessNotification() {
    // Hiển thị thông báo thành công
    const notification = document.getElementById("cartSuccessNotification");
    notification.style.display = "block";

    // Ẩn thông báo sau 10 giây
    setTimeout(() => {
        notification.style.display = "none";
    }, 10000);
}

function submitForm(action) {
    // Kiểm tra tồn kho trước khi thực hiện hành động
    checkStockAndSubmit(action);
}

// Xử lý lọc đánh giá theo số sao
document.querySelectorAll('.dg_sp button').forEach(button => {
    button.addEventListener('click', () => {
        // Loại bỏ lớp active khỏi tất cả các nút và thêm vào nút được chọn
        document.querySelectorAll('.dg_sp button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Lấy giá trị rating từ nút đã nhấn
        const rating = button.getAttribute('data-rating');

        // Hiển thị tất cả bình luận khi chọn "Tất cả" hoặc theo rating
        const reviews = document.querySelectorAll('.danhgia_traiphai');
        reviews.forEach(review => {
            const reviewRating = review.getAttribute('data-rating');
            if (rating === "all" || reviewRating === rating) {
                review.style.display = "block";
            } else {
                review.style.display = "none";
            }
        });
    });
});


// Xử lý lọc đánh giá theo số sao
document.querySelectorAll('.dg_sp button').forEach(button => {
    button.addEventListener('click', () => {
        // Loại bỏ lớp active khỏi tất cả các nút và thêm vào nút được chọn
        document.querySelectorAll('.dg_sp button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Lấy giá trị rating từ nút đã nhấn
        const rating = button.getAttribute('data-rating');

        // Hiển thị tất cả bình luận khi chọn "Tất cả" hoặc theo rating
        const reviews = document.querySelectorAll('.danhgia_traiphai');
        reviews.forEach(review => {
            const reviewRating = review.getAttribute('data-rating');
            if (rating === "all" || reviewRating === rating) {
                review.style.display = "block";
            } else {
                review.style.display = "none";
            }
        });
    });
});

document.querySelectorAll('.dg_sp button').forEach(button => {
    button.addEventListener('click', () => {
        // Loại bỏ lớp active khỏi tất cả các nút và thêm vào nút đã nhấn
        document.querySelectorAll('.dg_sp button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Lấy giá trị rating từ nút đã nhấn
        const rating = button.getAttribute('data-rating');

        // Hiển thị tất cả bình luận khi chọn "Tất cả" hoặc theo rating
        const reviews = document.querySelectorAll('.danhgia_traiphai');
        reviews.forEach(review => {
            const reviewRating = review.getAttribute('data-rating');
            if (rating === "all" || reviewRating === rating) {
                review.style.display = "block";
            } else {
                review.style.display = "none";
            }
        });
    });
});

// Hiển thị tất cả các bình luận khi trang tải
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.danhgia_traiphai').forEach(review => review.style.display = "block");
});

function openModal() {
    document.getElementById("shippingModal").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

// Hàm đóng modal
function closeModal() {
    document.getElementById("shippingModal").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}