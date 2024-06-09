<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phonenum" :value="__('Phone Number')" />
            <x-text-input id="phonenum" class="block mt-1 w-full" type="text" name="phonenum" :value="old('phonenum')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('phonenum')" class="mt-2" />
        </div>

        <!-- Student ID -->
        <div class="mt-4">
            <x-input-label for="studid" :value="__('Student ID')" />
            <x-text-input id="studid" class="block mt-1 w-full" type="text" name="studid" :value="old('studid')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('studid')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4 hidden">
            <x-input-label for="usertype" :value="__('Role')" />
            <select id="usertype" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="usertype" autocomplete="name">
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Block Status -->
        <div class="mt-4 hidden">
            <x-input-label for="blocked" :value="__('Email')" />
            <x-text-input id="blocked" class="block mt-1 w-full" type="text" name="blocked" :value="false" autocomplete="off" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
