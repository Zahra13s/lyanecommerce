@extends('admin.layout.master')

@section('main')
    <div class="main">
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

                <div class="row">
                    <div class="col-xl-6 col-xxl-5 d-flex">
                        <div class="w-100">
                            <div class="row">
                                <!-- Sales -->
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Sales</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="stat text-primary">
                                                        <i class="align-middle" data-feather="truck"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h1 class="mt-1 mb-3">{{ $currentWeekSales }}</h1>
                                            <div class="mb-0">
                                                <span class="{{ $salesChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                    <i
                                                        class="mdi mdi-arrow-{{ $salesChange >= 0 ? 'top-right' : 'bottom-right' }}"></i>
                                                    {{ number_format($salesChange, 2) }}%
                                                </span>
                                                <span class="text-muted">Since last week</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Visitors -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Visitors</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="stat text-primary">
                                                        <i class="align-middle" data-feather="users"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h1 class="mt-1 mb-3">{{ $currentWeekVisitors }}</h1>
                                            <div class="mb-0">
                                                <span class="{{ $visitorsChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                    <i
                                                        class="mdi mdi-arrow-{{ $visitorsChange >= 0 ? 'top-right' : 'bottom-right' }}"></i>
                                                    {{ number_format($visitorsChange, 2) }}%
                                                </span>
                                                <span class="text-muted">Since last week</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Earnings -->
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Earnings</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="stat text-primary">
                                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h1 class="mt-1 mb-3">${{ number_format($currentWeekEarnings, 2) }}</h1>
                                            <div class="mb-0">
                                                <span class="{{ $earningsChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                    <i
                                                        class="mdi mdi-arrow-{{ $earningsChange >= 0 ? 'top-right' : 'bottom-right' }}"></i>
                                                    {{ number_format($earningsChange, 2) }}%
                                                </span>
                                                <span class="text-muted">Since last week</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Orders -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col mt-0">
                                                    <h5 class="card-title">Orders</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="stat text-primary">
                                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h1 class="mt-1 mb-3">{{ $currentWeekOrders }}</h1>
                                            <div class="mb-0">
                                                <span class="{{ $ordersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                    <i
                                                        class="mdi mdi-arrow-{{ $ordersChange >= 0 ? 'top-right' : 'bottom-right' }}"></i>
                                                    {{ number_format($ordersChange, 2) }}%
                                                </span>
                                                <span class="text-muted">Since last week</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-xxl-7">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Movement</h5>
                            </div>
                            <div class="card-body py-3">
                                <canvas id="recentMovementChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const ctx = document.getElementById('recentMovementChart').getContext('2d');
                            const chart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: @json($dates),
                                    datasets: [{
                                        label: 'Orders',
                                        data: @json($orderCounts),
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: { beginAtZero: true }
                                    }
                                }
                            });
                        });

                    </script>
                </div>



            </div>
        </main>
    </div>
@endsection
