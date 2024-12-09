document.getElementById('danh_muc').addEventListener('change', function() {
    const idDanhMuc = this.value;

    if (!idDanhMuc) {
        document.getElementById('the_loai').innerHTML = '<option value="">Chọn thể loại</option>';
        return;
    }

    fetch('../Admin/xu_ly_themsp_ad.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_danh_muc=' + encodeURIComponent(idDanhMuc)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const theLoaiDropdown = document.getElementById('the_loai'); // Fixed the ID here
            theLoaiDropdown.innerHTML = '<option value="">Chọn thể loại</option>';
            if (data.length > 0) {
                data.forEach(theLoai => {
                    theLoaiDropdown.innerHTML += `<option value="${theLoai.id_the_loai}">${theLoai.ten_the_loai}</option>`;
                });
            } else {
                console.log('Không có thể loại phù hợp');
            }
        })
        .catch(error => console.error('AJAX Error:', error));
});