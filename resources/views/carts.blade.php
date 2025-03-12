@extends('layouts.main')

@section('content')
    <style>
        .cart-table th,
        .cart-table td {
            vertical-align: middle;
        }

        .cart-table img {
            max-width: 80px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
        }

        .quantity-control button {
            width: 30px;
            height: 30px;
            padding: 0;
        }

        .quantity-control input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            padding: 0;
            font-size: 16px;
        }

        .quantity-control input:focus {
            outline: none;
        }

        .total-section {
            padding-top: 20px;
        }
    </style>
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Giỏ Hàng Của Bạn</h2>

        <!-- Bảng giỏ hàng -->
        <div class="table-responsive">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sản Phẩm</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Đơn Giá</th>
                        <th scope="col">Số Lượng</th>
                        <th scope="col">Tổng</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                </thead>
                <tbody id="cartItems">
                    <!-- Sản phẩm mẫu 1 -->
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                alt="Keycap Artisan Natra">
                        </td>
                        <td>KEYCAP ARTISAN NF NATRA</td>
                        <td data-price="250000">250.000₫</td>
                        <td>
                            <div class="quantity-control">
                                <button class="btn btn-outline-secondary" onclick="changeQuantity(this, -1)">-</button>
                                <input type="number" class="quantity-input" value="1" min="1" readonly>
                                <button class="btn btn-outline-secondary" onclick="changeQuantity(this, 1)">+</button>
                            </div>
                        </td>
                        <td class="subtotal">250.000₫</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeItem(this)">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    <!-- Sản phẩm mẫu 2 -->
                    <tr>
                        <td>2</td>
                        <td>
                            <img src="https://bizweb.dktcdn.net/thumb/large/100/436/596/products/2-1740367782202.png?v=1740367788347"
                                alt="Laptop ABC">
                        </td>
                        <td>Laptop ABC</td>
                        <td data-price="15000000">15.000.000₫</td>
                        <td>
                            <div class="quantity-control">
                                <button class="btn btn-outline-secondary" onclick="changeQuantity(this, -1)">-</button>
                                <input type="number" class="quantity-input" value="1" min="1" readonly>
                                <button class="btn btn-outline-secondary" onclick="changeQuantity(this, 1)">+</button>
                            </div>
                        </td>
                        <td class="subtotal">15.000.000₫</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeItem(this)">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tổng tiền và nút thanh toán -->
        <div class="row total-section">
            <div class="col-md-4 offset-md-8">
                <h4>Tổng Tiền: <span id="cartTotal">15.250.000₫</span></h4>
                <a href="/checkout" class="btn btn-success w-100 mt-3">Thanh Toán</a>
                <a href="/products" class="btn btn-outline-dark w-100 mt-2">Tiếp Tục Mua Sắm</a>
            </div>
        </div>
    </div>

    <script>
        function updateTotal() {
            const items = document.querySelectorAll('#cartItems tr');
            let total = 0;

            items.forEach(item => {
                const price = parseInt(item.querySelector('td:nth-child(3)').getAttribute('data-price'));
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                const subtotal = price * quantity;

                item.querySelector('.subtotal').textContent = new Intl.NumberFormat('vi-VN').format(subtotal) + '₫';
                total += subtotal;
            });

            document.getElementById('cartTotal').textContent = new Intl.NumberFormat('vi-VN').format(total) + '₫';
        }

        function changeQuantity(button, change) {
            const input = button.parentElement.querySelector('.quantity-input');
            let quantity = parseInt(input.value) || 1;
            quantity += change;

            if (quantity < 1) quantity = 1;
            input.value = quantity;
            updateTotal();
        }

        function removeItem(button) {
            button.closest('tr').remove();
            updateTotal();
        }

        document.addEventListener('DOMContentLoaded', updateTotal);
    </script>
@endsection
