$( document ).ready(function() {
	//Fill Form from Database via Ajax
	getLocations();
	getLoadProfiles();
});

//Regular Options---------------------------------------------------------------
var locations;

function getLocations() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200) {
			//Fill Locations Combobox
			locations = JSON.parse(this.responseText);

			var slctLocation = document.getElementById("slctLocation");
			slctLocation.innerHTML = "";
			var lastLocation = -1;
			for (var i = 0; i < locations.length; i++) {
				if(lastLocation == -1 || lastLocation < locations[i].location_id) {
					var option = document.createElement("option");
					option.value = locations[i].location_id;
					option.innerHTML = locations[i].street + " " + locations[i].housenumber + ", " + locations[i].postalcode;
					slctLocation.appendChild(option);

					addMarkerToMap(locations[i]);

					lastLocation = locations[i].location_id;
				}
			}
			selectedLocationChanged();
		}
	};
	xmlhttp.open("GET", "../scripts/getLocations.php", true);
	xmlhttp.send();
}

function getLoadProfiles() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("slctProfile").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "../scripts/getLoadProfiles.php?userid=" + userid, true);
	xmlhttp.send();
}

function selectedLocationChanged() {
	var slctSystem = document.getElementById("slctSystem");
	slctSystem.innerHTML = "";
	var currentLocation = document.getElementById("slctLocation").value;

	for (var i = 0; i < locations.length; i++) {
		if(locations[i].location_id == currentLocation){
			var option = document.createElement("option");
			option.value = locations[i].photovoltaicsystem_id;
			option.innerHTML = locations[i].pvname + " - " + locations[i].alignment + " (" + Math.round(locations[i].size) + "kWp)";
			slctSystem.appendChild(option);
		}
	}
}

//Visual Changes

function uploadNewProfile() {
	var frm = document.getElementById("frmUploadProfile");
	if(frm.style.display == "none"){
		frm.setAttribute("style", "display: block");
	}
	else {
		frm.setAttribute("style", "display: none");
	}
}

//Advanced Options--------------------------------------------------------------

function showAdvancedOptions() {
	var div = document.getElementById("divAdvancedOptions");
	if(div.style.display == "none"){
		div.setAttribute("style", "display:block");
	}
	else {
		div.setAttribute("style", "display:none");
	}
}

function showStorageSettings(clazz) {
	$("."+clazz).each(function () {
		if($(this).is(":visible")){
			$(this).hide();
		}
		else {
			$(this).show();
		}
	});
}
