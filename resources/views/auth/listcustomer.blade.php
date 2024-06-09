<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('listcustomer') }}">
                        <div class="flex items-center mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Student ID" class="form-input rounded-md shadow-sm mt-1 block w-full">
                            <x-primary-button class="ml-3">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-center border-collapse border-spacing-0">
                            <thead class="border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-2 px-4">No</th>
                                    <th class="py-2 px-4">Name</th>
                                    <th class="py-2 px-4">Student ID</th>
                                    <th class="py-2 px-4">Email</th>
                                    <th class="py-2 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $number = 1; @endphp
                                @forelse($customers as $customer)
                                    <tr>
                                        <td class="py-2 px-4">{{ $number++ }}</td>
                                        <td class="py-2 px-4">{{ $customer->name }}</td>
                                        <td class="py-2 px-4">{{ $customer->studid }}</td>
                                        <td class="py-2 px-4">{{ $customer->email }}</td>
                                        <td class="py-2 px-4">
                                            @if($customer->blocked)
                                                <form method="POST" action="{{ route('unblockcustomer', $customer->id) }}">
                                                    @csrf
                                                    <x-primary-button type="submit" class="ml-3">
                                                        {{ __('Unblock') }}
                                                    </x-primary-button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('blockcustomer', $customer->id) }}">
                                                    @csrf
                                                    <x-danger-button type="submit" class="ml-3">
                                                        {{ __('Block') }}
                                                    </x-danger-button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-2 px-4">{{ __('No customers found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
