<?php
	
	include("db.php");

	$pk=htmlspecialchars($_POST["ipeID"]);
	$long=htmlspecialchars($_POST["longitude"]);
	$lat=htmlspecialchars($_POST["latitude"]);
	
	$result=$db->prepare("update ipe_data set Longitude = :long, Latitude =:lat where ipeID = :pk)");

	$result->bindParam(':long', $long);
	$result->bindParam(':lat', $lat);
	$result->bindParam(':pk', $pk);

	$result->execute();

	

?>