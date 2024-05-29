<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Runner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$approvedrunner->user->name" readonly />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$approvedrunner->user->email" readonly />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input-label for="phonenum" :value="__('Phone Number')" />
                        <x-text-input id="phonenum" class="block mt-1 w-full" type="text" name="phonenum" :value="$approvedrunner->user->phonenum" readonly />
                        <x-input-error :messages="$errors->get('phonenum')" class="mt-2" />
                    </div>

                    <!-- Student ID -->
                    <div class="mt-4">
                        <x-input-label for="studid" :value="__('Student ID')" />
                        <x-text-input id="studid" class="block mt-1 w-full" type="text" name="studid" :value="$approvedrunner->user->studid" readonly />
                        <x-input-error :messages="$errors->get('studid')" class="mt-2" />
                    </div>

                    <!-- Hostel -->
                    <div class="mt-4">
                        <x-input-label for="hostel" :value="__('Hostel')" />
                        <x-text-input id="hostel" class="block mt-1 w-full" type="text" name="hostel" :value="$approvedrunner->hostel" readonly />
                        <x-input-error :messages="$errors->get('hostel')" class="mt-2" />
                    </div>

                    <!-- Reason -->
                    <div class="mt-4">
                        <x-input-label for="reason" :value="__('Reason')" />
                        <textarea id="reason" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="reason" required autocomplete="username" rows="5" readonly>{{ $approvedrunner->reason }}</textarea>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    <!-- QR Code -->
                    <div class="mt-4">
                        <x-input-label for="qrcode" :value="__('QR Code')" />
                        <div class="flex justify-center">
                            <img src="{{ $approvedrunner->qrcode }}" alt="QR Code" class="w-32 h-32">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
