<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requested Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Status Filter Dropdown -->
                    <div class="mb-4">
                        <label for="status-filter" class="block font-medium text-sm text-gray-700">Filter by Status:</label>
                        <select id="status-filter" name="status-filter" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All</option>
                            <option value="null">Pending</option>
                            <option value="1">Accepted</option>
                            <option value="2">Out For Delivery</option>
                            <option value="3">Delivered</option>
                            <option value="0">Rejected</option>
                        </select>
                    </div>
                    <!-- Requested Delivery Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-center">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200">No</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Student ID</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Phone Number</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Item</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Status</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1; @endphp
                                @foreach($listdeliveries as $listdelivery)
                                    <tr data-status="{{ $listdelivery->status ?? 'null' }}">
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $number++ }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $listdelivery->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $listdelivery->user->studid ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $listdelivery->user->phonenum ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $listdelivery->item ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            @if($listdelivery->status == null)
                                                <span class="text-orange-500">Pending</span>
                                            @elseif($listdelivery->status == '1')
                                                <span class="text-blue-500">Accepted</span>
                                            @elseif($listdelivery->status == '2')
                                                <span class="text-purple-500">Out For Delivery</span>
                                            @elseif($listdelivery->status == '3')
                                                <span class="text-green-500">Delivered</span>
                                            @elseif($listdelivery->status == '0')
                                                <span class="text-red-500">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <a href="{{ route('acceptdelivery', $listdelivery->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $('#status-filter').change(function() {
                var selectedStatus = $(this).val();
                $('tbody tr').hide(); // Hide all table rows
                if (selectedStatus === '') {
                    $('tbody tr').show(); // Show all rows if 'All' selected
                } else {
                    $('tbody tr').each(function() {
                        var status = $(this).data('status');
                        if (selectedStatus === 'null') {
                            if (status === null) {
                                $(this).show(); // Show rows with null status
                            }
                        } else if (status == selectedStatus) {
                            $(this).show(); // Show rows with matching status
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
