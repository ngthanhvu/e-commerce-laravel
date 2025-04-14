@extends('layouts.admin')

@section('content')
    <h3 class="tw-text-2xl tw-font-bold tw-mb-6">Trang chủ admin</h3>

    <!-- Stats Cards -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-5 tw-gap-4 tw-mb-6">
        <!-- Card 1: Tổng người dùng -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Tổng người dùng</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-blue-600">{{ $totalUsers }} người</p>
            </div>
        </div>
        <!-- Card 2: Tổng doanh thu -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Tổng doanh thu</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-green-600">
                    {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
            </div>
        </div>
        <!-- Card 3: Doanh thu thực tế -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Doanh thu thực tế</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-teal-600">
                    {{ number_format($actualRevenue, 0, ',', '.') }} VNĐ</p>
            </div>
        </div>
        <!-- Card 4: Tổng đơn hàng -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Số đơn hàng</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-purple-600">{{ $totalOrders }} đơn</p>
            </div>
        </div>
        <!-- Card 5: Tổng tồn kho -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold">Tổng tồn kho</h5>
                <p class="card-text tw-text-3xl tw-font-bold tw-text-orange-600">{{ $totalStock }} sản phẩm</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4 tw-mb-6">
        <!-- Biểu đồ đường -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold tw-mb-4">Doanh thu hàng tháng</h5>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
        <!-- Biểu đồ cột -->
        <div class="card tw-shadow-md">
            <div class="card-body">
                <h5 class="card-title tw-text-lg tw-font-semibold tw-mb-4">Đơn hàng, Sản phẩm, Người dùng</h5>
                <canvas id="usersChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Bảng sản phẩm bán chạy -->
    <div class="tw-mb-6">
        <h3 class="tw-text-xl tw-font-semibold tw-mb-3">Sản phẩm bán chạy</h3>
        <table class="table table-striped table-hover text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                @foreach ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $product->product->mainImage->sub_image) }}"
                                alt="{{ $product->product->name }}" class="tw-w-16 tw-h-16 tw-object-cover">
                        </td>
                        <td>{{ $product->product->name }}</td>
                        <td>{{ $product->total_quantity }}</td>
                        <td>{{ number_format($product->total_revenue, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Biểu đồ doanh thu (Biểu đồ đường)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($monthlyRevenue as $data)
                        '{{ 'Tháng ' . $data->month }}',
                    @endforeach
                ],
                datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: [
                            @foreach ($monthlyRevenue as $data)
                                {{ $data->revenue }},
                            @endforeach
                        ],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Doanh thu thực tế (VNĐ)',
                        data: [
                            @foreach ($monthlyRevenue as $data)
                                @php
                                    $actual = $monthlyActualRevenue->firstWhere('month', $data->month);
                                @endphp
                                {{ $actual ? $actual->actual_revenue : 0 }},
                            @endforeach
                        ],
                        borderColor: 'rgba(255, 159, 64, 1)', // Màu cam cho doanh thu thực tế
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Biểu đồ người dùng (Biểu đồ cột)
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                    'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
                datasets: [{
                        label: 'Đơn hàng',
                        data: [@json($orderData)],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Màu xanh dương
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sản phẩm bán ra',
                        data: [@json($productData)],
                        backgroundColor: 'rgba(255, 99, 132, 0.6)', // Màu đỏ
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Người dùng mới',
                        data: [@json($userData)],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)', // Màu tím
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
@endsection
