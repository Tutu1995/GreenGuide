<?php
	
	include("db.php");

	

	// $compIds = json_decode(stripslashes($_POST['ids']));
	// $compNames = json_decode(stripslashes($_POST['names']));
	// $compLocs = json_decode(stripslashes($_POST['locations']));
	// $years = json_decode(stripslashes($_POST['years']));

	// for ($i = 0; $i < count($compIds); $i++) {
	// 	$result=$db->prepare("insert into ipe_data (CompanyID, CompanyName, CompanyLocation, Year) values(:companyID, :companyName, :companyLocation, :year)");

	// 	$result->bindParam(':companyID', $compIDs[$i]);
	// 	$result->bindParam(':companyName', $compNames[$i]);
	// 	$result->bindParam(':companyLocation', $compLocs[$i]);
	// 	$result->bindParam(':year', $years[$i]);

	// 	$result->execute();
	// }

	$compID=htmlspecialchars($_POST["compID"]);
	$compName=htmlspecialchars($_POST["compName"]);
	$compLocation=htmlspecialchars($_POST["compLocation"]);
	$year=htmlspecialchars($_POST["year"]);
	$longitude=htmlspecialchars($_POST["longitude"]);
	$latitude=htmlspecialchars($_POST["latitude"]);

	$result=$db->prepare("insert into ipe_data (CompanyID, CompanyName, CompanyLocation, Year, Longitude, Latitude) values(:companyID, :companyName, :companyLocation, :year, :longitude, :latitude)");

	$result->bindParam(':companyID', $compID);
	$result->bindParam(':companyName', $compName);
	$result->bindParam(':companyLocation', $compLocation);
	$result->bindParam(':year', $year);
	$result->bindParam(':longitude', $longitude);
	$result->bindParam(':latitude', $latitude);

	$result->execute();

	

?>
