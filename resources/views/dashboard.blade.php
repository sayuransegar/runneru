<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600">Here you can manage your orders and view your order history.</p>
                    </div>

                    <!-- Order Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @php
                            // Count total orders made by the customer
                            $totalOrders = App\Models\Delivery::where('userid', Auth::id())->count();
                        @endphp
                        <div class="bg-blue-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Total Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $totalOrders }}</p>
                        </div>
                        @php
                            // Count completed orders made by the customer
                            $completedOrders = App\Models\Delivery::where('userid', Auth::id())->where('status', '3')->count();
                        @endphp
                        <div class="bg-green-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Completed Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $completedOrders }}</p>
                        </div>
                        @php
                            // Count pending orders made by the customer
                            $pendingOrders = App\Models\Delivery::where('userid', Auth::id())->where('status', null)->count();
                        @endphp
                        <div class="bg-yellow-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Pending Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $pendingOrders }}</p>
                        </div>
                        @php
                            // Count canceled orders made by the customer
                            $canceledOrders = App\Models\Delivery::where('userid', Auth::id())->where('status', '0')->count();
                        @endphp
                        <div class="bg-red-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Canceled Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $canceledOrders }}</p>
                        </div>
                    </div>

                    <!-- Button Group for Chart Type -->
                    <div class="mt-6 flex flex-wrap justify-center gap-4">
                        <button id="totalOrdersBtn" class="bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto">Total Orders</button>
                        <button id="completedOrdersBtn" class="bg-green-500 text-white px-4 py-2 rounded w-full sm:w-auto">Completed Orders</button>
                        <button id="pendingOrdersBtn" class="bg-yellow-500 text-white px-4 py-2 rounded w-full sm:w-auto">Pending Orders</button>
                        <button id="canceledOrdersBtn" class="bg-red-500 text-white px-4 py-2 rounded w-full sm:w-auto">Canceled Orders</button>
                    </div>

                    <canvas class="mt-4" id="orderChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('orderChart').getContext('2d');
            let chart;

            // Function to fetch and update chart data
            function fetchAndUpdateChart(route) {
                fetch(route)
                    .then(response => response.json())
                    .then(data => {
                        const months = Object.keys(data);
                        const counts = Object.values(data);

                        if (chart) {
                            chart.destroy();
                        }

                        chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Orders',
                                    data: counts,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching order statistics:', error);
                    });
            }

            // Initial fetch for total orders
            fetchAndUpdateChart('{{ route("order.statistics", ["type" => "total"]) }}');

            // Event listeners for buttons
            document.getElementById('totalOrdersBtn').addEventListener('click', function () {
                fetchAndUpdateChart('{{ route("order.statistics", ["type" => "total"]) }}');
            });

            document.getElementById('completedOrdersBtn').addEventListener('click', function () {
                fetchAndUpdateChart('{{ route("order.statistics", ["type" => "completed"]) }}');
            });

            document.getElementById('pendingOrdersBtn').addEventListener('click', function () {
                fetchAndUpdateChart('{{ route("order.statistics", ["type" => "pending"]) }}');
            });

            document.getElementById('canceledOrdersBtn').addEventListener('click', function () {
                fetchAndUpdateChart('{{ route("order.statistics", ["type" => "canceled"]) }}');
            });
        });
    </script>
</x-app-layout>
