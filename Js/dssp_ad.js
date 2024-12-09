function highlightRow(checkbox) {
    const row = checkbox.closest('tr');
    if (checkbox.checked) {
        row.classList.add('highlight');
    } else {
        row.classList.remove('highlight');
    }
}

function toggleCheckboxes(source) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
        highlightRow(checkbox); // Highlight all rows if main checkbox is checked
    });
}
function updateProductName() {
    // Lấy element của mã sản phẩm (select)
    const selectMsp = document.getElementById('msp');
    // Lấy tên sản phẩm tương ứng từ tùy chọn được chọn
    const selectedOption = selectMsp.options[selectMsp.selectedIndex];
    const productName = selectedOption.getAttribute('data-ten-sp') || '';
    // Gán giá trị vào ô nhập tên sản phẩm
    document.getElementById('tensp').value = productName;
}
document.querySelector('form').addEventListener('submit', function(event) {
    // Xác định nút được nhấn
    const submitButtonName = event.submitter.name;
    
    if (submitButtonName === 'add_category' || submitButtonName === 'update_category') {
        // Ngăn gửi form để xử lý làm mới
        event.preventDefault();

        // Gửi form qua JavaScript (nếu cần gửi sau khi làm mới)
        const form = event.target;

        // Làm mới các trường dữ liệu
        document.getElementById('danh_muc').selectedIndex = 0;
        document.getElementById('the_loai').innerHTML = '<option value="">Chọn thể loại</option>';
        document.getElementById('msp').innerHTML = '<option value="">Chọn sản phẩm</option>';
        document.getElementById('tensp').value = '';
        document.getElementById('soluong').value = '';

        // Gửi form sau khi làm mới (nếu cần thực hiện xử lý backend)
        form.submit();
    }
});
