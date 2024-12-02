<div>
    <div id="map" style="height:390px"></div>

    <label for="latitudeInput">Latitude:</label>
    <input type="text" id="latitudeInput" placeholder="Enter latitude">

    <label for="longitudeInput">Longitude:</label>
    <input type="text" id="longitudeInput" placeholder="Enter longitude">

    <button id="markLocation">Mark Location</button>

    <label for="radiusSlider">Radius: <span id="radiusValue">1000</span> meters</label>
    <input type="range" id="radiusSlider" min="10" max="10000" step="10" value="1000" style="width:100%;">

    {{-- {{$this->table}} --}}
</div>

<script>
    // Initialize the map with a more zoomed-in level
    const map = L.map('map').setView([51.505, -0.09], 15); // Set default view to zoom level 15

    // Placeholder for circle and marker
    let circle, marker;

    // Function to update the circle on the map
    function updateCircle(lat, lng, radius) {
        if (circle) {
            map.removeLayer(circle); // Remove the old circle
        }
        circle = L.circle([lat, lng], {
            radius: radius,
            color: 'blue',
            fillColor: '#30c',
            fillOpacity: 0.2
        }).addTo(map);
    }

    // Change the map style by using a different tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        maxZoom: 20, // Set maximum zoom level
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Function to mark a location based on input
    function markLocation() {
        const lat = parseFloat(document.getElementById('latitudeInput').value);
        const lng = parseFloat(document.getElementById('longitudeInput').value);

        // Validate inputs
        if (isNaN(lat) || isNaN(lng)) {
            alert("Please enter valid latitude and longitude values.");
            return;
        }

        // Update map view
        map.setView([lat, lng], 500); // Zoom further in when marking a location

        // Remove previous marker if it exists
        if (marker) {
            map.removeLayer(marker);
        }

        // Add a marker to the entered location
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`Lat: ${lat}, Lng: ${lng}`)
            .openPopup();

        // Update circle
        updateCircle(lat, lng, document.getElementById('radiusSlider').value);
    }

    // Button click event to mark location
    document.getElementById('markLocation').addEventListener('click', markLocation);

    // Update radius when slider changes
    document.getElementById('radiusSlider').addEventListener('input', function () {
        const radius = this.value;
        document.getElementById('radiusValue').innerText = radius;

        if (marker) {
            const latLng = marker.getLatLng();
            updateCircle(latLng.lat, latLng.lng, radius);
        }
    });
</script>
