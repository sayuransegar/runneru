<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Registration List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white text-center border-collapse border-spacing-0">
                            <thead class="border-b-2 border-gray-200">
                                <tr>
                                    <th class="py-2 px-4">No</th>
                                    <th class="py-2 px-4">Name</th>
                                    <th class="py-2 px-4">Student ID</th>
                                    <th class="py-2 px-4">Hostel</th>
                                    <th class="py-2 px-4">Reason</th>
                                    <th class="py-2 px-4">QR Code</th>
                                    <th class="py-2 px-4">Card Matric</th>
                                    <th class="py-2 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $number = 1; @endphp
                                @foreach($runnerregisters as $runnerregister)
                                    <tr>
                                        <td class="py-2 px-4">{{ $number++ }}</td>
                                        <td class="py-2 px-4">{{ $runnerregister->user->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4">{{ $runnerregister->user->studid ?? 'N/A' }}</td>
                                        <td class="py-2 px-4">{{ $runnerregister->hostel ?? 'N/A' }}</td>
                                        <td class="py-2 px-4">{{ $runnerregister->reason ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 flex justify-center items-center">
                                            @if($runnerregister->qrcode)
                                                <img src="{{ $runnerregister->qrcode }}" alt="QR Code" class="w-12 h-12">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="py-2 px-4">
                                            @if($runnerregister->cardmatric)
                                                <button id="downloadButton" class="ml-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="w-5 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Download
                                                </button>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="py-2 px-4">
                                            <a href="{{ route('runnerapproval', $runnerregister->id) ?? 'N/A' }}" class="text-indigo-600 hover:text-indigo-900">View</a>
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
    <script>
        // Download Card Matric
        function downloadCardMatric(url) {
            fetch(url, { mode: 'cors' })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'Card_Matric.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                })
                .catch(console.error);
        }

        document.getElementById('downloadButton').addEventListener('click', function (e) {
            e.preventDefault();
            const cardmatricUrl = '{{ $runnerregister ? $runnerregister->cardmatric : null }}';
            downloadCardMatric(cardmatricUrl);
        });
        
    </script>
</x-app-layout>
