var myLatLng;
var map;
var marker;
var map2;
var marker2;
var autocomplete;
var autodeliver;
var infoWindow;
var infoWindow2;

function geoLocationInit() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, fail);
    } else {
        alert("Browser not supported");
    }
}

function success(position) {
    console.log(position);
    var latval = position.coords.latitude;
    var lngval = position.coords.longitude;
    myLatLng = new google.maps.LatLng(latval, lngval);
    initialize(myLatLng);
}

function fail() {
    alert("it fails");
}

async function initialize(myLatLng) {
    const [{ Map }, { AdvancedMarkerElement }] = await Promise.all([
        google.maps.importLibrary("marker"),
        google.maps.importLibrary("places"),
        google.maps.importLibrary("maps"),
    ]);

    map = new google.maps.Map(document.getElementById('address-input'), {
        center: myLatLng,
        gestureHandling: "greedy",
        zoom: 16,
        mapTypeControl: false,
        mapId: "DEMO_MAP_ID"
    });

    map2 = new google.maps.Map(document.getElementById('location-input'), {
        center: myLatLng,
        gestureHandling: "greedy",
        zoom: 16,
        mapTypeControl: false,
        mapId: "DEMO_MAP_ID"
    });

    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP // Add animation to the marker (DROP or BOUNCE)
    });

    marker2 = new google.maps.Marker({
        position: myLatLng,
        map: map2,
        draggable: true,
        animation: google.maps.Animation.DROP // Add animation to the marker (DROP or BOUNCE)
    });

    map.addListener("click", (e) => {
        placeMarkerAndPanTo(e.latLng, map, marker);
    });

    map2.addListener("click", (e) => {
        placeMarkerAndPanTo(e.latLng, map2, marker2);
    });

    const card = document.getElementById("place-autocomplete-card");
    const card2 = document.getElementById("deliveryauto");

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);
    map2.controls[google.maps.ControlPosition.TOP_LEFT].push(card2);

    infoWindow = new google.maps.InfoWindow({});

    // Create the Autocomplete input field
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('autocompleteinput'),
        { types: ['geocode'] }
    );

    autodeliver = new google.maps.places.Autocomplete(
        document.getElementById('autocompletedeliver'),
        { types: ['geocode'] }
    );

    // Event listener for place changed
    autocomplete.addListener("place_changed", function() {
        var place = autocomplete.getPlace();

        if (place.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        var content = '<div id="infowindow-content">' +
            '<span id="place-displayname" class="title">' +
            place.name +
            "</span><br />" +
            '<span id="place-address">' +
            place.formatted_address +
            "</span>" +
            "</div>";

        updateInfoWindow(content, place.geometry.location);
        marker.setPosition(place.geometry.location);
    });

    google.maps.event.addListener(marker, 'position_changed',
    function(){
        let shoplat = marker.position.lat()
        let shoplng = marker.position.lng()
        $('#shoplat').val(shoplat)
        $('#shoplng').val(shoplng)
    });

    autodeliver.addListener("place_changed", function() {
        var place2 = autodeliver.getPlace();

        if (place2.viewport) {
            map2.fitBounds(place2.geometry.viewport);
        } else {
            map2.setCenter(place2.geometry.location);
            map2.setZoom(17);
        }

        var content2 = '<div id="infowindow-content">' +
            '<span id="place-displayname" class="title">' +
            place2.name +
            "</span><br />" +
            '<span id="place-address">' +
            place2.formatted_address +
            "</span>" +
            "</div>";

        updateInfoWindow2(content2, place2.geometry.location);
        marker2.setPosition(place2.geometry.location);
    });

    google.maps.event.addListener(marker2, 'position_changed',
    function(){
        let deliverylat = marker2.position.lat()
        let deliverylng = marker2.position.lng()
        $('#deliverylat').val(deliverylat)
        $('#deliverylng').val(deliverylng)
    });

    // Initialize infoWindow2
    infoWindow2 = new google.maps.InfoWindow({}); // Add this line
}

function placeMarkerAndPanTo(latLng, mapInstance, markerInstance) {
    markerInstance.setPosition(latLng);
    mapInstance.panTo(latLng);
}

// Helper function to create an info window.
function updateInfoWindow(content, center) {
    infoWindow.setContent(content);
    infoWindow.setPosition(center);
    infoWindow.open({
        map,
        anchor: marker,
        shouldFocus: false,
    });
}

function updateInfoWindow2(content2, center2) {
    infoWindow2.setContent(content2);
    infoWindow2.setPosition(center2);
    infoWindow2.open({
        map: map2, // Specify map2 instead of map
        anchor: marker2,
        shouldFocus: false,
    });
}

geoLocationInit(); // Call the initialization function
