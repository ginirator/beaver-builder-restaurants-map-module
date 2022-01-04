<?php
/**
 * This file should be used to render each module instance.
 */
?>
<script>
    var map;
    var service;
    var infowindow;

    navigator.geolocation.getCurrentPosition(
        function (position) {
            initMap(position.coords.latitude, position.coords.longitude)
        },
        function errorCallback(error) {
            console.log(error)
        }
    );

    function initMap(lat, lng) {
        var myLatLng = {
            lat,
            lng
        };

        var mapLocation = new google.maps.LatLng(43.7184038,-79.5181399);

        map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 14
        });

        var request = {
            location: myLatLng,
            radius: '1000',
            types: ['restaurant']
        };

        service = new google.maps.places.PlacesService(map);
        service.nearbySearch(request, callback);
    }

    function callback(results, status) {
        var markers_number = <?php echo $settings->number_of_map_markers_field; ?>;
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < markers_number; i++) {
                var place = results[i];
                createMarker(results[i]);
            }
        }
    }

    function createMarker(place) {
        if (!place.geometry || !place.geometry.location) return;

        const marker = new google.maps.Marker({
            map,
            position: place.geometry.location,
        });

        infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, "click", () => {
            const content = document.createElement("div");

            const nameElement = document.createElement("h5");
            nameElement.textContent = place.name;
            content.appendChild(nameElement);

            const vicinityElement = document.createElement("p");
            vicinityElement.textContent = place.vicinity;
            content.appendChild(vicinityElement);

            const placeAddressElement = document.createElement("p");
            placeAddressElement.textContent = place.formatted_address;
            content.appendChild(placeAddressElement);

            const placeStatusElement = document.createElement("p");
            var business_status = place.business_status.toLowerCase();
            placeStatusElement.textContent = 'Status: ' + business_status.charAt(0).toUpperCase() + business_status.slice(1);
            content.appendChild(placeStatusElement);

            infowindow.setContent(content);
            infowindow.open(map, marker);
        });
    }
</script>

<!--The div element for the map heading text -->
<?php
    $heading = $settings->heading ?? '';
    if ($heading) {
?>
    <div class="map-heading-text">
        <<?php echo $settings->tag; ?> class="fl-heading">
            <span class="fl-heading-text"><?php echo $heading; ?></span>
        </<?php echo $settings->tag; ?>>
    </div>
<?php } else { echo 'no heading found'; } ?>

<!--The div element for the map -->
<div id="map"></div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings->google_maps_api_key_field; ?>&libraries=places&callback=initMap&v=weekly"
    async defer type="text/javascript"></script>
