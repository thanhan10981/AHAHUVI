document.addEventListener('DOMContentLoaded', function() {
    const updateTotal = () => {
        let tongtien = 0;

        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseInt(item.getAttribute('data-price')); // Giá sản phẩm
            const quantity = parseInt(item.querySelector('input[type="number"]').value); // Số lượng

            const totalItemPrice = price * quantity; // Tổng giá của sản phẩm
            item.querySelector('.t-price').textContent = totalItemPrice.toLocaleString() + ' đ'; // Hiển thị giá

            tongtien += totalItemPrice; // Cộng vào tổng tiền
        });

        document.querySelector('#tongtien').textContent = tongtien.toLocaleString() + ' đ'; // Hiển thị tổng tiền
        document.querySelector('input[name="tongtien"]').value = tongtien; // Cập nhật giá trị tổng tiền
    };

    const updateQuantity = (id_sp, newQuantity) => {
        fetch('../Home/update_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_sp=${id_sp}&quantity=${newQuantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                }
            })
            .catch(error => console.error('Lỗi:', error));
    };

    const adjustQuantity = (button, action) => {
        const cartItem = button.closest('.cart-item');
        const id_sp = cartItem.getAttribute('data-id');
        const input = cartItem.querySelector('input[type="number"]');
        let newQuantity = parseInt(input.value);

        if (action === 'increase') {
            newQuantity++;
        } else if (action === 'decrease' && newQuantity > 1) {
            newQuantity--;
        }

        input.value = newQuantity; // Cập nhật giá trị hiển thị
        updateQuantity(id_sp, newQuantity); // Cập nhật SQL
        updateTotal(); // Cập nhật tổng tiền
    };

    const setupListeners = () => {
        // Xử lý tăng số lượng
        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function() {
                adjustQuantity(this, 'increase');
            });
        });

        // Xử lý giảm số lượng
        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', function() {
                adjustQuantity(this, 'decrease');
            });
        });

        // Xử lý thay đổi trực tiếp trong ô số lượng
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('change', function() {
                const cartItem = this.closest('.cart-item');
                const id_sp = cartItem.getAttribute('data-id');
                const newQuantity = Math.max(1, parseInt(this.value)); // Đảm bảo giá trị >= 1
                this.value = newQuantity;

                updateQuantity(id_sp, newQuantity); // Cập nhật SQL
                updateTotal(); // Cập nhật tổng tiền
            });
        });

        // Xử lý xóa sản phẩm
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                const cartItem = this.closest('.cart-item');
                const id_sp = cartItem.getAttribute('data-id');

                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    fetch('../Home/delete_item.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `id_sp=${id_sp}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                cartItem.remove(); // Xóa sản phẩm khỏi giao diện
                                updateTotal(); // Cập nhật tổng tiền
                                alert('Sản phẩm đã được xóa khỏi giỏ hàng!');
                            } else {
                                alert(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                            }
                        })
                        .catch(error => console.error('Lỗi:', error));
                }
            });
        });
    };

    setupListeners(); // Thiết lập sự kiện ban đầu
    updateTotal(); // Cập nhật tổng tiền khi tải trang
});