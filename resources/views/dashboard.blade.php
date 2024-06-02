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
                            $totalOrders = App\Models\delivery::where('userid', Auth::id())->count();
                        @endphp
                        <div class="bg-blue-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Total Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $totalOrders }}</p>
                        </div>
                        @php
                            // Count completed orders made by the customer
                            $completedOrders = App\Models\delivery::where('userid', Auth::id())->where('status', '3')->count();
                        @endphp
                        <div class="bg-green-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Completed Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $completedOrders }}</p>
                        </div>
                        @php
                            // Count pending orders made by the customer
                            $pendingOrders = App\Models\delivery::where('userid', Auth::id())->where('status', null)->count();
                        @endphp
                        <div class="bg-yellow-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Pending Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $pendingOrders }}</p>
                        </div>
                        @php
                            // Count canceled orders made by the customer
                            $canceledOrders = App\Models\delivery::where('userid', Auth::id())->where('status', '0')->count();
                        @endphp
                        <div class="bg-red-100 p-6 rounded-lg shadow">
                            <h4 class="text-xl font-semibold mb-2">Canceled Orders</h4>
                            <p class="text-gray-700 text-2xl font-bold">{{ $canceledOrders }}</p>
                        </div>
                    </div>
                    <!-- Add more content as needed -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
