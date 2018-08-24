var mapSystems;

function initMap() {
    mapSystems = new google.maps.Map(document.getElementById("mapSystems"), {
      center: {lat: 48.000682, lng: 13.924621},
      zoom: 12,
	  streetViewControl: false,
    });
}

function addMarkerToMap(location) {
	var pos = {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)};
	if(pos.lat != 0 || pos.lng != 0){
		var marker = new google.maps.Marker({
			position: pos,
			map: mapSystems,
			title: location.street + " " + location.housenumber + ", " + location.postalcode,
			loc_id: location.location_id
		});
		marker.addListener("click", function () {
			var slct = document.getElementById("slctLocation");
			slct.value = this.loc_id;
			selectedLocationChanged();
		});
	}
}
