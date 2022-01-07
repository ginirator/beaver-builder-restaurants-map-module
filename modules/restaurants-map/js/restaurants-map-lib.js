/**
 * This is an example of an additional script that can be
 * enqueued using the add_js module method. The files settings.js
 * and frontend.js don't need to be enqueued and will be included
 * for you automatically.
 */

/**
 * This file should contain frontend logic for
 * all module instances.
 */

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

function initMap(lat = 0, lng = 0) {
	var myLatLng = {
		lat,
		lng
	};

	// var mapLocation = new google.maps.LatLng(43.7184038,-79.5181399);

	map = new google.maps.Map(document.getElementById('map'), {
		center: myLatLng,
		zoom: 14,
		mapTypeId: 'roadmap'
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
	var markers_number = localized_number_of_map_markers_field;
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
