<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.2/echo.iife.min.js"></script>
  <script>
    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '05899e1410c811c93b21', // Your Pusher App Key
        cluster: 'ap1', // Your Pusher App Cluster
        forceTLS: true
    });

    var channel = window.Echo.channel('delivery-requests');
    channel.listen('.delivery-submitted', function(data) {
        console.log('New delivery request: ', data);
        alert('New delivery request: ' + JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>This will display an alert when a new delivery request is created.</p>
</body>
</html>
