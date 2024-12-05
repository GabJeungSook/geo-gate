<div>
    <div class="py-4 text-2xl roboto-bold text-gray-700 space-y-2">
        <h1>{{$event->event_description}}</h1>
        <p class="text-xl roboto-medium text-gray-600">{{$event->campus->name}}</p>
        <p class="text-xl roboto-medium text-gray-600">{{Carbon\Carbon::parse($eventSchedule->schedule_date)->format('F d, Y')}} 
        <p class="text-xl roboto-medium text-gray-600">{{Carbon\Carbon::parse($eventSchedule->start_time)->format('h:i A')}} 
                - 
            {{Carbon\Carbon::parse($eventSchedule->end_time)->format('h:i A')}}</p>
    </div>
    <h1></h1>
    <div id="map" style="height: 390px;"></div>

    <div class="pt-6 text-xl text-gray-600 roboto-medium">
        Currently present: {{$users->count()}}
    </div>
    <div class="border-t border-gray-400 border-dashed py-2 text-4xl roboto-medium text-gray-700 space-y-2 mt-4">
        <h1 class="mb-4">Students</h1>
        <div>
            {{$this->table}}
        </div>
    </div>
</div>

<script>
    let map;
    let eventMarker;
    let eventCircle;
    const userMarkers = []; // To store user markers for management

    function initMap() {
        const eventLocation = {
            lat: parseFloat(@json($event->campus->latitude)),
            lng: parseFloat(@json($event->campus->longitude))
        }; // Event location from backend
        const eventRadius = parseInt(@json($event->campus->radius)); // Radius in meters

        // Initialize the map
        map = new google.maps.Map(document.getElementById("map"), {
            center: eventLocation,
            zoom: 20,
        });

        // Add the event marker
        eventMarker = new google.maps.Marker({
            position: eventLocation,
            map: map,
            title: "Event Location",
            icon: {
        path: google.maps.SymbolPath.CIRCLE, // Use a built-in circle shape
        fillColor: "#FF0000", // Red color for the marker
        fillOpacity: 1,
        strokeColor: "#FF0000", // Stroke color
        strokeWeight: 1,
        scale: 5, // Size of the marker
    },
        });

        // Add the event circle
        eventCircle = new google.maps.Circle({
            map: map,
            center: eventLocation,
            radius: eventRadius,
            fillColor: "#30c",
            fillOpacity: 0.2,
            strokeColor: "blue",
            strokeWeight: 2,
        });

        // Load user markers
        loadUserMarkers(eventLocation, eventRadius);
    }

    function loadUserMarkers(eventLocation, eventRadius) {
        const users = @json($users); // Users data from backend

        users.forEach(user => {
            const userLocation = {
                lat: parseFloat(user.latitude),
                lng: parseFloat(user.longitude)
            };

            // Check if the user is within the event radius
            if (isWithinRadius(userLocation, eventLocation, eventRadius)) {
                const marker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    title: `${user.name} (${user.time_in ? "Time In" : "Time Out"})`,
                });

                userMarkers.push(marker); // Store marker for management
            }
        });
    }

    function isWithinRadius(userLocation, eventLocation, radius) {
        const earthRadius = 6371000; // Earth's radius in meters

        const lat1 = toRadians(eventLocation.lat);
        const lon1 = toRadians(eventLocation.lng);
        const lat2 = toRadians(userLocation.lat);
        const lon2 = toRadians(userLocation.lng);

        const dLat = lat2 - lat1;
        const dLon = lon2 - lon1;

        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1) * Math.cos(lat2) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = earthRadius * c; // Distance in meters

        return distance <= radius;
    }

    function toRadians(degrees) {
        return degrees * (Math.PI / 180);
    }
</script>
