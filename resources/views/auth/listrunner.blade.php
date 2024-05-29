<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-bordered dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="border-bottom: 2px solid #e2e8f0; margin-bottom: 10px;">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Hostel</th>
                                <th>Reason</th>
                                <th>QR Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="margin-top: 10px;">
                            @php $number = 1; @endphp
                            @foreach($listrunners as $listrunner)
                                <tr>
                                    <td>{{ $number++ }}</td>
                                    <td>{{ $listrunner->user->name }}</td>
                                    <td>{{ $listrunner->user->studid }}</td>
                                    <td>{{ $listrunner->hostel }}</td>
                                    <td>{{ $listrunner->reason }}</td>
                                    <td style="display: flex; justify-content: center; align-items: center;"><img src="{{ $listrunner->qrcode }}" alt="QR Code" style="width: 50px; height: 50px;"></td>
                                    <td>
                                        <a href="{{ route('approvedrunner', $listrunner->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
