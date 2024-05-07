<x-app-layout onload="initMap()">
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delivery') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="form-control block w-full" id="travel-time"></div>
                        <div class="mt-4" id="map" style="height: 500px; width: 100%;"></div>
                        <form action="{{ route('canceldelivery') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-center justify-center mt-4">
                                <x-danger-button class="ms-4">
                                    {{ __('Cancel Delivery') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/direction.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwIBxZagluW6TDJ6Y0bgNgmsN240X7gHM&libraries=places&callback=initMap"></script>
</x-app-layout>
