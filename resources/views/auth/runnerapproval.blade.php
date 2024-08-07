<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Registration Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$runnerRegistration->user->name" readonly />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$runnerRegistration->user->email" readonly />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input-label for="phonenum" :value="__('Phone Number')" />
                        <x-text-input id="phonenum" class="block mt-1 w-full" type="text" name="phonenum" :value="$runnerRegistration->user->phonenum" readonly />
                        <x-input-error :messages="$errors->get('phonenum')" class="mt-2" />
                    </div>

                    <!-- Student ID -->
                    <div class="mt-4">
                        <x-input-label for="studid" :value="__('Student ID')" />
                        <x-text-input id="studid" class="block mt-1 w-full" type="text" name="studid" :value="$runnerRegistration->user->studid" readonly />
                        <x-input-error :messages="$errors->get('studid')" class="mt-2" />
                    </div>

                    <!-- Hostel -->
                    <div class="mt-4">
                        <x-input-label for="hostel" :value="__('Hostel')" />
                        <x-text-input id="hostel" class="block mt-1 w-full" type="text" name="hostel" :value="$runnerRegistration->hostel" readonly />
                        <x-input-error :messages="$errors->get('hostel')" class="mt-2" />
                    </div>

                    <!-- Reason -->
                    <div class="mt-4">
                        <x-input-label for="reason" :value="__('Reason')" />
                        <textarea id="reason" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="reason" required autocomplete="username" rows="5" readonly>{{ $runnerRegistration->reason }}</textarea>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <!-- QR Code -->
                    <div class="mt-4">
                        <x-input-label for="qrcode" :value="__('QR Code')" />
                        <div class="flex justify-center">
                            <img src="{{ $runnerRegistration->qrcode }}" alt="QR Code" class="w-32 h-32">
                        </div>
                    </div>

                    <!-- Card Matric -->
                    <div class="mt-4">
                        <x-input-label for="qrcode" :value="__('Card Matric')" />
                        @if($runnerRegistration->cardmatric)
                            <button id="downloadButton" class="mt-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-5 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                                </svg>
                                Download
                            </button>
                        @else
                            N/A
                        @endif
                    </div>
                    
                    <!-- Approve or Reject Buttons -->
                    <form action="{{ route('runnerapprovalupdate', $runnerRegistration->id) }}" method="POST" class="mt-6">
                        @csrf
                        <div class="flex justify-center">
                            <x-primary-button name="approval" value="1" class="bg-green-500 hover:bg-green-700">
                                {{ __('Approve') }}
                            </x-primary-button>
                            <x-danger-button name="approval" value="0" class="bg-red-500 hover:bg-red-700 ms-4">
                                {{ __('Reject') }}
                            </x-danger-button>
                        </div>
                    </form>
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
            const cardmatricUrl = '{{ $runnerRegistration ? $runnerRegistration->cardmatric : null }}';
            downloadCardMatric(cardmatricUrl);
        });
        
    </script>
</x-app-layout>
