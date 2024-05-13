<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('runnerregistration') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Hostel -->
                        <div>
                            <x-input-label for="hostel" :value="__('Hostel')" />
                            <select id="hostel" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="hostel" required autofocus autocomplete="name">
                                <option value="" disabled selected>Select Hostel</option>
                                <option value="mawardah">Mawardah</option>
                                <option value="kk5">Kolej Kediaman 5</option>
                                <option value="dhuam">Dhuam</option>
                            </select>
                        </div>

                        <!-- Reason -->
                        <div class="mt-4">
                            <x-input-label for="reason" :value="__('Reason')" />
                            <textarea id="reason" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="reason" required autocomplete="username" rows="5"></textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="qrcode" :value="__('Upload QR Code')" />
                            <x-text-input type="file" name="qrcode" id="qrcode" class="block mt-1 w-full" />
                        </div>

                        <!-- Apply Button -->
                        <div class="flex items-center justify-center mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
