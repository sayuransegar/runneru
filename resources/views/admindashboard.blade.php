<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Dashboard Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="p-4 bg-green-100 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold text-green-700">Total Users</h3>
                            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold text-blue-700">Active Users</h3>
                            <p class="text-3xl font-bold">{{ $activeUsers }}</p>
                        </div>
                        <div class="p-4 bg-red-100 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold text-red-700">Blocked Users</h3>
                            <p class="text-3xl font-bold">{{ $blockedUsers }}</p>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-4">User Management</h3>
                        <div class="overflow-hidden border rounded-lg shadow-md">
                            <table class="min-w-full bg-white text-center">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">No</th>
                                        <th class="py-2 px-4 border-b">Name</th>
                                        <th class="py-2 px-4 border-b">Student ID</th>
                                        <th class="py-2 px-4 border-b">Email</th>
                                        <th class="py-2 px-4 border-b">Blocked</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $number = 1; @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $number++ }}</td>
                                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $user->studid }}</td>
                                        <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                        <td class="py-2 px-4 border-b">{{ $user->blocked ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @if($user->blocked)
                                                <form method="POST" action="{{ route('unblockcustomer', $user->id) }}">
                                                    @csrf
                                                    <x-primary-button type="submit" class="ml-3">
                                                        {{ __('Unblock') }}
                                                    </x-primary-button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('blockcustomer', $user->id) }}">
                                                    @csrf
                                                    <x-danger-button type="submit" class="ml-3">
                                                        {{ __('Block') }}
                                                    </x-danger-button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
