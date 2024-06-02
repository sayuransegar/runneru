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
                    <table class="table table-bordered dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="border-bottom: 2px solid #e2e8f0; margin-bottom: 10px;">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="margin-top: 10px;">
                            @php $number = 1; @endphp
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->studid }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
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
                                    <td colspan="5">{{ __('No customers found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
