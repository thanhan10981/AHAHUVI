function doiAnh(element){
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
thanhphoSelect.addEventListener("change",function(){
    quanhuyenSelect.disabled = false;
    quanhuyenSelect.innerHTML= '<option>Chọn quận/huyện</option>';
    phuongxaSelect.innerHTML = '<option>Chọn phường/xã</option>';
    phuongxaSelect.disabled = true;

    const selectedCity = this.value;
    const districts = data[selectedCity]

    for(const district in districts){
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

        // Ẩn popup thay đổi địa chỉ
        document.getElementById("thaydoidiachi").style.display = "none";
    }
});
//nhấn xem thêm để hiển thị thêm mã giảm giá
document.getElementById("xemthemkhuyenmai").addEventListener("click", function() {
    document.getElementById("uudailienquan").style.display = "flex"; // Hiển thị popup

});
//nhấn ra ngoài thfi out
document.getElementById("uudailienquan").addEventListener("click", function (e) {
    if (e.target === document.getElementById("uudailienquan")) {
        document.getElementById("uudailienquan").style.display = "none";
    }
});
// Xử lý sự kiện khi nhấn nút "Xem thêm"
document.getElementById("nutxemthem").addEventListener("click", function () {
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
document.getElementById("nutrutgon").addEventListener("click", function () {
    // Xóa các mã khuyến mãi mới (có lớp voucher-extra)
    const extraContent = document.querySelectorAll("#makhuyenmai .voucher-extra");
    extraContent.forEach(element => element.remove());

    // Hiển thị lại nút "Xem thêm" và ẩn nút "Rút gọn"
    document.getElementById("nutxemthem").style.display = "block";
    document.getElementById("nutrutgon").style.display = "none";
});
// tăng giảm số lượng
const inputsoluong = document.getElementById('soluong');
const nuttang = document.querySelector('.nut.tang');
const nutgiam = document.querySelector('.nut.giam');

nuttang.addEventListener('click', function(){
    let currentValue = parseInt(inputsoluong.value);
    if(!isNaN(currentValue)){
        inputsoluong.value = currentValue + 1;
    }
});

nutgiam.addEventListener('click', function(){
    let currentValue = parseInt(inputsoluong.value);
    if(!isNaN(currentValue) && currentValue > 1){
        inputsoluong.value = currentValue - 1;
    }
});
document.querySelector('.xemthem').addEventListener('click', function() {
    const chitietsp = document.querySelector('.chitietsp-phai1-3');
    const mota = document.querySelector('.mota');
    mota.classList.add('mo-rong');
    chitietsp.style.height = 'auto'; // Để chiều cao tự động điều chỉnh khi mở rộng
    this.style.display = 'none';
    document.querySelector('.rutgon').style.display = 'block';
});

document.querySelector('.rutgon').addEventListener('click', function() {
    const chitietsp = document.querySelector('.chitietsp-phai1-3');
    const mota = document.querySelector('.mota');
    mota.classList.remove('mo-rong');
    chitietsp.style.height = ''; // Đặt chiều cao về giá trị mặc định
    this.style.display = 'none';
    document.querySelector('.xemthem').style.display = 'block';
});


