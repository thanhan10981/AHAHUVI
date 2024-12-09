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


//API lấy tỉnh thành phố
var citis = document.getElementById("city");
var districts = document.getElementById("district");
var wards = document.getElementById("ward");

var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "application/json",
};

var promise = axios(Parameter);
promise.then(function(result) {
    renderCity(result.data);
});

function renderCity(data) {
    // Lặp qua các tỉnh và thêm vào select
    for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Name); // Thêm tên tỉnh vào select
    }

    citis.onchange = function() {
        districts.length = 1; // Reset các quận/huyện
        wards.length = 1; // Reset các xã/phường
        if (this.value != "") {
            const result = data.filter(n => n.Name === this.value); // Lọc tỉnh/thành phố đã chọn
            for (const k of result[0].Districts) {
                districts.options[districts.options.length] = new Option(k.Name, k.Name); // Thêm tên quận vào select
            }
        }
    };

    districts.onchange = function() {
        wards.length = 1; // Reset xã/phường
        const selectedDistrict = this.value;
        const cityData = data.find(x => x.Name === citis.value);
        const districtData = cityData ? Districts.find(k => k.Name === selectedDistrict);
        if (districtData) {
            for (const ward of districtData.Wards) {
                wards.options[wards.options.length] = new Option(ward.Name, ward.Name);
            }
        }
    };

}

document.getElementById("addressForm").onsubmit = function() {
    var cityName = citis.options[citis.selectedIndex].text;
    var districtName = districts.options[districts.selectedIndex].text;
    var wardName = wards.options[wards.selectedIndex].text;

    // Kiểm tra giá trị trước khi gán vào các input ẩn
    console.log("City:", cityName);
    console.log("District:", districtName);
    console.log("Ward:", wardName);

    // Gán tên vào các input ẩn trước khi gửi form
    document.getElementById("hiddenCity").value = cityName;
    document.getElementById("hiddenDistrict").value = districtName;
    document.getElementById("hiddenWard").value = wardName;
};







function copyVoucherCode(code) {
    navigator.clipboard.writeText(code)
        .then(() => {
            alert("Mã voucher đã được sao chép: " + code);
        })
        .catch(err => {
            console.error("Không thể sao chép mã voucher", err);
        });
}

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

function showNotifications(option) {
    // Ẩn tất cả các thông báo
    const contentElements = document.querySelectorAll('.notify-content');
    contentElements.forEach(function(content) {
        content.classList.remove('show'); // Ẩn tất cả các thông báo
    });

    // Ẩn gạch vàng dưới các mục
    const options = document.querySelectorAll('.notify-option');
    options.forEach(function(optionElement) {
        optionElement.classList.remove('selected'); // Ẩn gạch vàng
    });

    // Hiển thị nội dung thông báo tương ứng
    const content = document.getElementById(option + '-conten');
    if (content) {
        content.classList.add('show'); // Hiển thị thông báo cho mục đã chọn
    }

    // Thêm gạch vàng dưới mục được chọn
    const selectedOption = document.getElementById(option);
    if (selectedOption) {
        selectedOption.classList.add('selected'); // Gạch vàng dưới mục
    }
}

// Mặc định hiển thị thông báo cho mục "Tất cả" khi vào trang
document.addEventListener('DOMContentLoaded', function() {
    showNotifications('tatca'); // Hiển thị thông báo "Không có thông báo" khi vào trang
});


function showNotifications(type) {
    // Ẩn tất cả các thông báo
    const allNotifications = document.querySelectorAll('.thongbao');
    allNotifications.forEach(notification => {
        notification.classList.remove('show');
    });

    // Hiển thị thông báo tương ứng với mục đã chọn
    const selectedNotification = document.getElementById(type);
    if (selectedNotification) {
        selectedNotification.classList.add('show');
    }
}

//thongbao
function thongbao(message) {
    // Xóa màu vàng khỏi tất cả các mục
    const items = document.querySelectorAll('.notify-item p');
    items.forEach(item => item.classList.remove('selected'));

    // Thêm màu vàng cho mục được chọn
    event.target.classList.add('selected');

    if (message === 'Tất cả') {
        document.getElementById('tatca').innerHTML = "<p>Không có thông báo</p>";
    } else {
        document.getElementById('tatca').innerHTML = `<p> Không có thông báo</p>`; //$message
    }

}