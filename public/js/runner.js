function initMap() {

    const shopLat = parseFloat(deliveryDetails.shoplat);
    const shopLng = parseFloat(deliveryDetails.shoplng);
    const deliveryLat = parseFloat(deliveryDetails.deliverylat);
    const deliveryLng = parseFloat(deliveryDetails.deliverylng);

    console.log('shopLat:', shopLat);
    console.log('shopLng:', shopLng);
    console.log('deliveryLat:', deliveryLat);
    console.log('deliveryLng:', deliveryLng);

    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: { lat: shopLat, lng: shopLng }
    });
    

    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    const request = {
        origin: { lat: shopLat, lng: shopLng },
        destination: { lat: deliveryLat, lng: deliveryLng },
        travelMode: 'DRIVING'
    };

    directionsService.route(request, (result, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(result);
            const route = result.routes[0].legs[0];
            document.getElementById('travel-time').value = route.duration.text;
        } else {
            alert('Directions request failed due to ' + status);
        }
    });
}

window.initMap = initMap;

