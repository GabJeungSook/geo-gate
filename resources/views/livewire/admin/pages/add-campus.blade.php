<div>
    <div class="p-4 bg-gray-100 space-x-2 mb-3">
        <label for="campusNameInput">Campus Name:</label>
        <input wire:model="name" type="text" id="campusNameInput" class="rounded-md" placeholder="Enter name">

        <label for="latitudeInput">Latitude:</label>
        <input wire:model="latitude" type="text" id="latitudeInput" class="rounded-md" placeholder="Enter latitude">

        <label for="longitudeInput">Longitude:</label>
        <input wire:model="longitude" type="text" id="longitudeInput" class="rounded-md" placeholder="Enter longitude">

        <label for="radiusInput">Radius (meters):</label>
        <input wire:model="radius" type="text" id="radiusInput" class="rounded-md" placeholder="Enter radius">

        <button id="markLocation" class="bg-red-500 p-2 rounded-md text-white">Mark Location</button>
    </div>
    <div id="map" style="height: 390px;"></div>

    <div class="p-3 bg-gray-100">
        <label for="radiusSlider">Radius: <span id="radiusValue">10</span> meters</label>
        <input class="hidden"
            type="range" 
            id="radiusSlider" 
            min="2" 
            max="10000" 
            step="1" 
            value="10" 
            style="width:100%; height:10px; border-radius:10px; background:linear-gradient(to right, #4caf50, #81c784);">
    </div>

    <div class="mt-10 flex justify-end space-x-3">
        <button class="bg-gray-100 p-2 px-6 rounded-md text-gray-600">Cancel</button>
        <div>
            {{ $this->saveAction }}
         
            <x-filament-actions::modals />
        </div>
    </div>
</div>
<script>
    // Google Maps initialization
    let map;
    let marker;
    let circle;

    function initMap() {
        const defaultLocation = { lat: 6.495520273051356, lng: 124.84250229535617 }; // Default location

        const defaultZoom = 20;

        // Create map
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: defaultZoom,
        });

        // Add a default marker and circle
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            title: "Default Location",
            draggable: true, // Allow the marker to be draggable
        });

        circle = new google.maps.Circle({
            map: map,
            center: defaultLocation,
            radius: parseInt(document.getElementById("radiusSlider").value),
            fillColor: "#30c",
            fillOpacity: 0.2,
            strokeColor: "blue",
            strokeWeight: 2,
        });

        // Sync circle with marker
        circle.bindTo("center", marker, "position");

        // Attach event listeners
        document.getElementById("markLocation").addEventListener("click", markLocation);
        document.getElementById("radiusSlider").addEventListener("input", updateRadiusFromSlider);
        document.getElementById("radiusInput").addEventListener("input", updateSliderFromInput);

        // Add a click event listener to the map
        map.addListener("click", (event) => {
            const position = event.latLng;

            // Update marker position
            marker.setPosition(position);

            // Update latitude and longitude inputs
            document.getElementById("latitudeInput").value = position.lat();
            document.getElementById("longitudeInput").value = position.lng();

            // Update circle center
            circle.setCenter(position);
        });

        // Update inputs when the marker is dragged
        marker.addListener("dragend", () => {
            const position = marker.getPosition();

            // Update latitude and longitude inputs
            document.getElementById("latitudeInput").value = position.lat();
            document.getElementById("longitudeInput").value = position.lng();

            // Update circle center
            circle.setCenter(position);
        });
    }

    // Function to mark a location based on input
    function markLocation() {
        const lat = parseFloat(document.getElementById("latitudeInput").value);
        const lng = parseFloat(document.getElementById("longitudeInput").value);

        // Validate inputs
        if (isNaN(lat) || isNaN(lng)) {
            alert("Please enter valid latitude and longitude values.");
            return;
        }

        const position = { lat, lng };

        // Update marker position
        marker.setPosition(position);

        // Update map center
        map.setCenter(position);
        map.setZoom(20); // Zoom in when a location is marked

        // Update circle position
        circle.setCenter(position);
    }

    // Update radius and circle when slider is moved
    function updateRadiusFromSlider() {
        const radius = parseInt(document.getElementById("radiusSlider").value);
        document.getElementById("radiusInput").value = radius;
        document.getElementById("radiusValue").innerText = radius;
        circle.setRadius(radius);
    }

    // Update slider and circle when radius input is changed
    function updateSliderFromInput() {
        const radius = parseInt(document.getElementById("radiusInput").value);
        if (!isNaN(radius)) {
            document.getElementById("radiusSlider").value = radius;
            document.getElementById("radiusValue").innerText = radius;
            circle.setRadius(radius);
        }
    }
</script>

