$(document).ready(() => windowLoaded());
function windowLoaded()
{
	var currentSite = window.location.href;
	var simulationLink = "";
	var profileLink = "";
	var logoutLink = "";

	if(!currentSite.includes("index"))
	{
		simulationLink = "../Simulation/simulation.php";
		profileLink = "../Profil/profil.php";
		logoutLink = "../Login/login.php?logout=1";
	}
	else
	{
		simulationLink = "Simulation/simulation.php";
		profileLink = "Profil/profil.php";
		logoutLink = "Login/login.php?logout=1";
	}
	if(userid != null && userid != "")
	{
		var a = document.createElement("a");
		a.innerHTML = "Simulation";
		a.href = simulationLink;
		$(".topnav").append(a);

		var a2 = document.createElement("a");
		a2.innerHTML = "Profil";
		a2.href = profileLink;
		$(".topnav").append(a2);

		$("#loginLogout")[0].innerHTML = "Logout";
		$("#loginLogout")[0].href = logoutLink;
	}
	else
	{
		console.log($(".topnav a").not("[id]"));
		$(".topnav a").not("[id]").remove();

		$("#loginLogout")[0].innerHTML = "Login";
		$("#loginLogout")[0].href = "Login/login.php";
	}
}
