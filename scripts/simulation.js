//Main Settings
var selectedLoadProfile_id;
var LoadProfileData;
var LoadProfileDataOK = false;
var selectedPVSystem_id;
var PVSystemData;
var PVSystemDataOK = false;
var pvSystemScaling;

//Additional Settings
var energyCost;
var degredation;

//Battery Settings
var chkBattery;
var batPriority;
var batSize;
var batEfficiency;
var batMaxCharge;
var batMinCharge;
var batMaxChargingCurrent;

//Boiler Settings

//Puffer Settings

//Electric Car Settings
var chkCar;
var carPriority;
var carSize;
var carMaxCharge;
var carMaxChargingCurrent;
var carLoadProfile;
var carAttendanceTimes;

//Start the Simulation
function startSimulation() {
	//get Main Settings
	selectedLoadProfile_id = document.getElementById("slctProfile").value;
	if(selectedLoadProfile_id != "none"){
		getLoadProfileData(selectedLoadProfile_id);
	}
	selectedPVSystem_id = document.getElementById("slctSystem").value;
	if(selectedPVSystem_id != "none"){
		getPVSystemData(selectedPVSystem_id);
	}
	pvSystemScaling = document.getElementById("systemScaling").value;

	//get Additional Settings
	energyCost = document.getElementById("inpEnergyCost").value;
	degradation = document.getElementById("inpDegredation").value;

	//get Battery Settings
	chkBattery = docgeti("chkBattery").value;
	batPriority = document.getElementById("batPriority").value;
	batSize = docgeti("batSize").value;
	batEfficiency = docgeti("batEfficiency").value;
	batMaxCharge = docgeti("batMaxCharge").value;
	batMinCharge = docgeti("batMinCharge").value;
	batMaxChargingCurrent = docgeti("batMaxChargingCurrent").value;

	//get Boiler Settings

	//get Puffer Settings

	//get Electric Car Settings
	chkCar = docgeti("chkCar").value;
	carPriority = docgeti("carPriority").value;
	carSize = docgeti("carSize").value;
	carMaxCharge = docgeti("carMaxCharge").value;
	carMaxChargingCurrent = docgeti("carMaxChargingCurrent").value;
	carLoadProfile = docgeti("carLoadProfile").files[0];
	carAttendanceTimes = docgeti("carAttendanceTimes").files[0];

	//check Main Settings

}

function checkIfEverythingIsReadyAndStartCalculating() {
	//check if everything is downloaded and correct
}

function getLoadProfileData(id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechanged = function () {
		if(this.readyState == 4 $$ this.status == 200){
			LoadProfileData = JSON.parse(this.responseText);
			LoadProfileDataOK = true;

			checkIfEverythingIsReadyAndStartCalculating();
		}
	}
}

function getPVSystemData(id) {

}

function checkForMinMaxError(value, min, max) {
	if(value < min){
		return min;
	}
	if(value > max){
		return max;
	}
	return value;
}

function writeErrorMessage(msg) {
	$("#simulationError").html += "\n" + msg;
}
