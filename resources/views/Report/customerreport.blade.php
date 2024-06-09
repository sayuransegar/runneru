<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Report List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('runner-reports') }}">
                        <div class="flex items-center mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Student ID" class="form-input rounded-md shadow-sm mt-1 block w-full">
                            <x-primary-button class="ml-3">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Report List Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-center">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200">No</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Runner Name</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Student ID</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Phone Number</th>
                                    <th class="px-6 py-3 border-b border-gray-200">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1; @endphp
                                @foreach($runnerReportLists as $runnerReportList)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $number++ }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ optional($runnerReportList->runner->user)->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ optional($runnerReportList->runner->user)->studid ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ optional($runnerReportList->runner->user)->phonenum ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $runnerReportList->reason ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
