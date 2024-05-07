let map, directionsService, directionsRenderer;

function initMap() {
    // Initialize the map with a fixed center for San Francisco
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 37.7749, lng: -122.4194 }, // San Francisco coordinates
        zoom: 13,
        gestureHandling: "greedy",
        zoom: 16,
        mapTypeControl: false,
    });

    // Initialize directions service and renderer
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Fetch shop and delivery coordinates from the server
    fetchCoordinatesAndDisplayDirections();
}

function fetchCoordinatesAndDisplayDirections() {
    // Fetch the shop and delivery coordinates from the server using an API
    // Example: Fetching coordinates using AJAX (you may need to adjust this based on your backend)
    $.ajax({
        url: '/fetch-coordinates', // Update to match your route
        method: 'GET',
        success: function(response) {
            try {
                // Check if the response contains an error
                if (response.error) {
                    console.error('Error:', response.error);
                    return;
                }

                // Parse the response and update the map
                const shopLat = response.shopLat;
                const shopLng = response.shopLng;
                const deliveryLat = response.deliveryLat;
                const deliveryLng = response.deliveryLng;

                // Create the request object for directions service
                const request = {
                    origin: { lat: parseFloat(shopLat), lng: parseFloat(shopLng) },
                    destination: { lat: parseFloat(deliveryLat), lng: parseFloat(deliveryLng) },
                    travelMode: 'DRIVING'
                };

                // Call the directions service to get the route
                directionsService.route(request, function(result, status) {
                    if (status === 'OK') {
                        // Display the route on the map
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
                        var travelTimeText = "Estimated delivery time: ";
                        if (hours > 0) {
                            travelTimeText += hours + " hours ";
                        }
                        travelTimeText += minutes + " minutes";
                        document.getElementById('travel-time').innerText = travelTimeText;
                    } else {
                        console.error('Failed to get directions:', status);
                    }
                });
            } catch (error) {
                console.error('Error handling response:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch coordinates:', error);
        }
    });
}