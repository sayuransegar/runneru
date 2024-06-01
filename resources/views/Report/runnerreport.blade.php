<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Report List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('customer-reports') }}">
                        <div class="flex items-center mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Student ID" class="form-input rounded-md shadow-sm mt-1 block w-full">
                            <x-primary-button class="ml-3">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Report List Table -->
                    <table class="table table-bordered dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="border-bottom: 2px solid #e2e8f0; margin-bottom: 10px;">
                            <tr>
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Student ID</th>
                                <th>Phone Number</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody style="margin-top: 10px;">
                            @php $number = 1; @endphp
                            @foreach($customerReportLists as $customerReportList)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ optional($customerReportList->reportedUser)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($customerReportList->reportedUser)->studid ?? 'N/A' }}</td>
                                    <td>{{ optional($customerReportList->reportedUser)->phonenum ?? 'N/A' }}</td>
                                    <td>{{ $customerReportList->reason ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
