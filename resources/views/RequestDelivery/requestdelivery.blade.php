<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('requestdelivery') }}">
                        @csrf
                        
                        <!-- Runner -->
                        <div>
                            <x-input-label for="runner" :value="__('Available Runner')" />
                            <select id="runnerid" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="runnerid" required autofocus autocomplete="name">
                                <option value="" disabled selected>Select Runner</option>
                                <option value="Aiman">Aiman</option>
                                <option value="Afiq">Afiq</option>
                                <option value="Bad">Bad</option>
                            </select>
                        </div>

                        <!-- Item -->
                        <div class="mt-4">
                            <x-input-label for="item" :value="__('What would you like to do?')" />
                            <textarea id="item" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="item" required autocomplete="name" rows="5" placeholder="E.g.
Parcel:
2 parcel at PAP
Buy Instant Noodle:
1 Mee Sedap"></textarea>
                        </div>

                        <!-- addinstruct -->
                        <div class="mt-4">
                            <x-input-label for="addinstruct" :value="__('Additional instructions for Runner')" />
                            <x-text-input id="addinstruct" class="block mt-1 w-full" type="text" name="addinstruct" :value="old('addinstruct')" required autofocus autocomplete="name" placeholder="E.g. Please sent to my room door"/>
                        </div>

                        <!-- Price Range -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Price Range')" />
                            <select id="price" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="price" required autofocus autocomplete="name">
                                <option value="" disabled selected>Select Price Range</option>
                                <option value="RM0 - RM10">RM0 - RM10</option>
                                <option value="RM11-RM20">RM11-RM20</option>
                                <option value="Above RM20">Above RM20</option>
                            </select>
                        </div>

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="shoplocation" :value="__('Where to buy?')" />
                            <x-text-input id="shoplocation" class="block mt-1 w-full" type="text" name="shoplocation" :value="old('shoplocation')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4 ms-4" id="place-autocomplete-card">
                            <x-text-input id="autocompleteinput" class="block mt-1 w-full" />
                        </div>

                        <div class="mt-4 hidden">
                            <x-text-input name="shoplat" id="shoplat" class="block mt-1 w-full" />
                            <x-text-input name="shoplng" id="shoplng" class="block mt-1 w-full" />
                        </div>
                        
                        <div class="mt-4" style="width:100%;height:400px;">
                            <div id="address-input" style="width:100%;height:400px;"></div>
                        </div>

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="deliverylocation" :value="__('Deliver to')" />
                            <x-text-input id="deliverylocation" class="block mt-1 w-full" type="text" name="deliverylocation" :value="old('deliverylocation')" required autofocus autocomplete="name" />
                        </div>

                        <div class="mt-4 ms-4" id="deliveryauto">
                            <x-text-input id="autocompletedeliver" class="block mt-1 w-full" />
                        </div>

                        <div class="mt-4 hidden">
                            <x-text-input name="deliverylat" id="deliverylat" class="block mt-1 w-full" />
                            <x-text-input name="deliverylng" id="deliverylng" class="block mt-1 w-full" />
                        </div>

                        <div class="mt-4" style="width:100%;height:400px;">
                            <div id="location-input" style="width:100%;height:400px;"></div>
                        </div>

                        <!-- Submit Button -->
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/mapinput.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwIBxZagluW6TDJ6Y0bgNgmsN240X7gHM&libraries=marker,places&callback=geoLocationInit"></script>

</x-app-layout>
