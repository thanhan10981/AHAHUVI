function loadProductDetails(id_sp) {
    // Send an AJAX request to fetch product details
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "xep_hang_right.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const product = JSON.parse(xhr.responseText);
            const formatVND = (value) => value.toLocaleString('vi-VN', { style: 'decimal', maximumFractionDigits: 0 }) + 'đ';
            document.getElementById('product-image').src = "../IMG/" + product.anh_bia;
            document.getElementById('product-name').textContent = product.ten_sp;
            document.getElementById('product-price').textContent = formatVND(product.gia);
            document.getElementById('product-author').textContent = 'Tác giả: ' + (product.tac_gia || 'N/A');
            document.getElementById('product-publisher').textContent = 'Nhà xuất bản: ' + (product.nha_xb || 'N/A');
            if (product.gia_giam) {
                document.getElementById('original-price').textContent = formatVND(product.gia_giam);
                const discount = Math.round((1 - product.gia / product.gia_giam) * 100);
                document.getElementById('discount').textContent = `${discount}%`;
            } else {
                document.getElementById('original-price').textContent = '';
                document.getElementById('discount').textContent = '';
            }

            document.getElementById('product-description').innerHTML = product.mo_ta || 'No description available.';
        }
    };
    xhr.send("id_sp=" + id_sp);
}