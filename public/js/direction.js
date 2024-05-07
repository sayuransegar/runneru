let map, directionsService, directionsRenderer;
let sourceAutocomplete, destAutocomplete;

function initMap() {
    // Check if geolocation is supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var myLatLng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 13
            });

            // Initialize directions service and renderer
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
        }, function() {
            // Handle geolocation error
            alert("Geolocation failed. Defaulting to a standard location.");
            var defaultLatLng = { lat: 37.7749, lng: -122.4194 }; // Default to San Francisco if geolocation fails
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLatLng,
                zoom: 13
            });
        });
    } else {
        // Browser doesn't support Geolocation
        alert("Geolocation is not supported by your browser. Defaulting to a standard location.");
        var defaultLatLng = { lat: 37.7749, lng: -122.4194 }; // Default to San Francisco if geolocation isn't supported
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLatLng,
            zoom: 13
        });
    }

    // Initialize source and destination autocomplete
    sourceAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById('source')
    );
    destAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById('dest')
    );
}

function calcRoute() {
    var source = document.getElementById('source').value;
    var dest = document.getElementById('dest').value;

    console.log("Source:", source);
    console.log("Destination:", dest);

    let request = {
        origin: source,
        destination: dest,
        travelMode: 'DRIVING'
    };

    // Check if directions service is initialized
    if (directionsService) {
        directionsService.route(request, function(result, status) {
            console.log("Route Result:", result);
            console.log("Route Status:", status);
            if (status == "OK") {
                // Check if directions renderer is initialized
                if (directionsRenderer) {
                    // Display the directions on the map
                    directionsRenderer.setDirections(result);
                    
                    // Extract travel time from the route result
                    var route = result.routes[0];
                    var travelTimeInSeconds = 0;
                    route.legs.forEach(function(leg) {
                        travelTimeInSeconds += leg.duration.value;
                    });
                    
                    // Convert travel time to hours and minutes
                    var hours = Math.floor(travelTimeInSeconds / 3600);
                    var minutes = Math.round((travelTimeInSeconds % 3600) / 60);
                    
                    // Display the travel time on the page
                    var travelTimeText = "Estimated travel time: ";
                    if (hours > 0) {
                        travelTimeText += hours + " hours ";
                    }
                    travelTimeText += minutes + " minutes";
                    document.getElementById('travel-time').innerText = travelTimeText;
                } else {
                    console.error("Directions renderer is not initialized.");
                }
            } else {
                console.error("Failed to get directions. Status:", status);
            }
        });
    } else {
        console.error("Directions service is not initialized.");
    }
}
