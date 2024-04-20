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
                    <!-- Hostel -->
                    <div>
                        <x-input-label for="hostel" :value="__('Hostel')" />
                        <select id="hostel" class="block mt-1 w-full" name="hostel" required autofocus autocomplete="name">
                            <option value="" disabled selected>Select Hostel</option>
                            <option value="mawardah">Mawardah</option>
                            <option value="kk5">Kolej Kediaman 5</option>
                            <option value="dhuam">Dhuam</option>
                        </select>
                    </div>

                    <!-- Reason -->
                    <div class="mt-4">
                        <x-input-label for="reason" :value="__('Reason')" />
                        <textarea id="reason" class="block mt-1 w-full" name="reason" required autocomplete="username" rows="5"></textarea>
                    </div>

                    <!-- Apply Button -->
                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Apply') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
