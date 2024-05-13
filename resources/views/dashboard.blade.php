<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Card 1: Today's Deliveries -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Today's Deliveries</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">You have  deliveries scheduled for today.</p>
                        <a href="" class="text-blue-600 hover:underline">View Details</a>
                    </div>
                </div>
                <!-- Card 2: Completed Deliveries -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Completed Deliveries</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">You have completed  deliveries so far.</p>
                        <a href="" class="text-blue-600 hover:underline">View Details</a>
                    </div>
                </div>
                <!-- Card 3: Pending Payments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Pending Payments</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">You have  pending payments.</p>
                        <a href="" class="text-blue-600 hover:underline">View Details</a>
                    </div>
                </div>
                <!-- Card 4: Feedback -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Feedback</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">You have received  new feedback.</p>
                        <a href="" class="text-blue-600 hover:underline">View Details</a>
                    </div>
                </div>
                <!-- Card 5: Order History -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Order History</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">View your order history and track previous deliveries.</p>
                        <a href="" class="text-blue-600 hover:underline">View History</a>
                    </div>
                </div>
                <!-- Card 6: Profile -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Profile</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">Manage your profile settings and preferences.</p>
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
