function showSection(sectionId) {
    // Lấy tất cả các phần tử có class là 'section'
    const sections = document.querySelectorAll('.section, .address-section'); // Đảm bảo lấy cả .address-section nếu không nằm trong .section

    // Ẩn tất cả các phần tử
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Hiển thị phần tử có ID được chọn
    document.getElementById(sectionId).style.display = 'block';
}



document.getElementById('account-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Lấy giá trị từ các input
    const fullname = document.getElementById('fullname').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    // Cập nhật giá trị hiển thị trong phần thông tin đã lưu
    document.getElementById('saved-fullname').textContent = fullname;
    document.getElementById('saved-email').textContent = email;
    document.getElementById('saved-phone').textContent = phone;

    // Hiển thị thông tin đã lưu
    document.getElementById('info-saved').style.display = 'block';
});

    


const districtsByProvince = {
    HN: ["Quận Ba Đình", "Quận Hoàn Kiếm", "Quận Tây Hồ", "Quận Long Biên", "Quận Cầu Giấy", "Quận Thanh Xuân", "Quận Hai Bà Trưng", "Quận Đống Đa", "Quận Hà Đông", "Huyện Thanh Trì"],
    HCM: ["Quận 1", "Quận 2", "Quận 3", "Quận 4", "Quận 5", "Quận 6", "Quận 7", "Quận 8", "Quận 9", "Quận Bình Thạnh"],
    DN: ["Quận Hải Châu", "Quận Thanh Khê", "Quận Sơn Trà", "Quận Ngũ Hành Sơn", "Quận Liên Chiểu", "Quận Cẩm Lệ", "Huyện Hòa Vang", "Huyện Hoàng Sa"],
    HP: ["Quận Hồng Bàng", "Quận Lê Chân", "Quận Ngô Quyền", "Quận Kiến An", "Quận Hải An", "Quận Đồ Sơn", "Quận Dương Kinh", "Huyện Thủy Nguyên", "Huyện An Dương"],
    CT: ["Quận Ninh Kiều", "Quận Bình Thủy", "Quận Cái Răng", "Quận Ô Môn", "Huyện Thốt Nốt", "Huyện Vĩnh Thạnh", "Huyện Phong Điền", "Huyện Cờ Đỏ"],
    KH: ["TP. Nha Trang", "Thị xã Cam Ranh", "Huyện Diên Khánh", "Huyện Ninh Hòa", "Huyện Vạn Ninh", "Huyện Khánh Vĩnh", "Huyện Khánh Sơn", "Huyện Cam Lâm"],
    QN: ["TP. Hạ Long", "Thị xã Cẩm Phả", "Thị xã Uông Bí", "Thị xã Móng Cái", "Huyện Hoành Bồ", "Huyện Đông Triều", "Huyện Quảng Yên", "Huyện Đầm Hà", "Huyện Hải Hà"],
    BT: ["TP. Bến Tre", "Huyện Châu Thành", "Huyện Mỏ Cày Nam", "Huyện Mỏ Cày Bắc", "Huyện Thạnh Phú", "Huyện Ba Tri", "Huyện Giồng Trôm", "Huyện Bình Đại"],
    AG: ["TP. Long Xuyên", "Thị xã Châu Đốc", "Huyện Tân Châu", "Huyện Phú Tân", "Huyện Tịnh Biên", "Huyện Tri Tôn", "Huyện Châu Thành", "Huyện Châu Phú"],
    BD: ["TP. Thủ Dầu Một", "Thị xã Dĩ An", "Thị xã Thuận An", "Huyện Bến Cát", "Huyện Tân Uyên", "Huyện Phú Giáo", "Huyện Bắc Tân Uyên", "Huyện Dầu Tiếng"],
    LA: ["TP. Tân An", "Huyện Đức Hòa", "Huyện Bến Lức", "Huyện Cần Giuộc", "Huyện Cần Đước", "Huyện Tân Trụ", "Huyện Châu Thành", "Huyện Thủ Thừa"],
    VT: ["TP. Vũng Tàu", "Thị xã Phú Mỹ", "Huyện Châu Đức", "Huyện Đất Đỏ", "Huyện Long Điền", "Huyện Xuyên Mộc", "Huyện Tân Thành"],
    NA: ["TP. Vinh", "Huyện Nghi Lộc", "Huyện Hưng Nguyên", "Huyện Nam Đàn", "Huyện Đô Lương", "Huyện Yên Thành", "Huyện Quỳnh Lưu", "Huyện Diễn Châu"],
    TH: ["TP. Thanh Hóa", "Huyện Hoằng Hóa", "Huyện Hậu Lộc", "Huyện Nga Sơn", "Huyện Thiệu Hóa", "Huyện Triệu Sơn", "Huyện Đông Sơn", "Huyện Nông Cống"],
    QB: ["TP. Đồng Hới", "Huyện Bố Trạch", "Huyện Quảng Ninh", "Huyện Lệ Thủy", "Huyện Minh Hóa", "Huyện Tuyên Hóa", "Huyện Quảng Trạch", "Thị xã Ba Đồn"],
    BDN: ["TP. Quy Nhơn", "Huyện An Nhơn", "Huyện Tuy Phước", "Huyện Phù Cát", "Huyện Phù Mỹ", "Huyện Hoài Nhơn", "Huyện Hoài Ân", "Huyện Tây Sơn", "Huyện Vĩnh Thạnh", "Huyện Vân Canh"],
    PY: ["TP. Tuy Hòa", "Thị xã Sông Cầu", "Huyện Đồng Xuân", "Huyện Tuy An", "Huyện Sơn Hòa", "Huyện Sông Hinh", "Huyện Tây Hòa", "Huyện Phú Hòa"]
};

const citySelect = document.getElementById('addressCity');
const districtSelect = document.getElementById('addressDistrict');

citySelect.addEventListener('change', function () {
    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
    
    if (this.value) {
        districtSelect.disabled = false;
        const districts = districtsByProvince[this.value];
        
        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    } else {
        districtSelect.disabled = true;
    }
});



//saochep voucher
// function copyVoucherCode(code) {
//     navigator.clipboard.writeText(code)
//         .then(() => {
//             alert("Mã voucher đã được sao chép: " + code);
//         })
//         .catch(err => {
//             console.error("Không thể sao chép mã voucher", err);
//         });
// }

function copyVoucherCode(voucherCode) {
    const textarea = document.createElement("textarea");
    textarea.value = voucherCode; // Sử dụng mã voucher được truyền vào
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);
    
    // Thay đổi thông báo sau khi sao chép
    alert(`Đã sao chép ${voucherCode}`);
}
