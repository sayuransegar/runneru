<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="form-group">
                            <input id="source" class="form-control" type="text" placeholder="Source">
                        </div>
                        <div class="form-group">
                            <input id="dest" class="form-control" type="text" placeholder="Destination">
                        </div>
                        <button class="btn btn-primary" onclick="calcRoute()">Get Directions</button>
                        <br><br>
                        <div id="map" style="height: 500px; width: 100%;"></div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/direction.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8RKNo8CfJ0Q1NUMdQKvVdBPW1EZOuHkA&libraries=places&callback=geoLocationInit"></script>
</x-app-layout>
