<?php
	include("db.php");
	
	// water issue
	$WaterType = htmlspecialchars($_POST["WaterType"]);
	$WaterColor = htmlspecialchars($_POST["WaterColor"]);
	$WaterOdor = htmlspecialchars($_POST["WaterOdor"]);
	$WaterTurb = htmlspecialchars($_POST["turbRate"]);

	$checkFloat = htmlspecialchars($_POST["float"]);
	$floatType = htmlspecialchars($_POST["floatType"]);
	$DO = htmlspecialchars($_POST["DO"]);
	$pH = htmlspecialchars($_POST["pH"]);
	$Turbidity = htmlspecialchars($_POST["Turbidity"]);
	$BOD = htmlspecialchars($_POST["BOD"]);
	$COD = htmlspecialchars($_POST["COD"]);
	$TOC = htmlspecialchars($_POST["TOC"]);
	$TS = htmlspecialchars($_POST["TS"]);
	$NH4 = htmlspecialchars($_POST["NH4"]);
	$TP = htmlspecialchars($_POST["TP"]);
	$Hg = htmlspecialchars($_POST["Hg"]);
	$Pb = htmlspecialchars($_POST["Pb"]);
	$Cd = htmlspecialchars($_POST["Cd"]);
	$As = htmlspecialchars($_POST["As"]);


	// Air waste
	$Visibility = htmlspecialchars($_POST["Visibility"]);
	$AirOdor = htmlspecialchars($_POST["AirOdor"]);
	$SmokeCheck = htmlspecialchars($_POST["SmokeCheck"]);
	$SmokeColor = htmlspecialchars($_POST["SmokeColor"]);
	$Symptom = htmlspecialchars($_POST["Symptom"]);
	$symptomDescr = htmlspecialchars($_POST["symptomDescr"]);

	$PM2_5 = htmlspecialchars($_POST["PM2.5"]);
	$PM10 = htmlspecialchars($_POST["PM10"]);
	$O3 = htmlspecialchars($_POST["O3"]);
	$SOx = htmlspecialchars($_POST["SOx"]);
	$NOx = htmlspecialchars($_POST["NOx"]);
	$CO = htmlspecialchars($_POST["CO"]);
	




	// Solid waste
	$WasteType = htmlspecialchars($_POST["WasteType"]);
	$WasteAmount = htmlspecialchars($_POST["WasteAmount"]);
	$WasteOdor = htmlspecialchars($_POST["WasteOdor"]);
	$WasteMeasure = htmlspecialchars($_POST["WasteMeasure"]);
	
	try {

		// intert values solid_issue table
		$wasteData=$db->prepare("insert into solid_issue (WasteType, Amount, Odor, Measurements) values (:WasteType, :WasteAmount, :WasteOdor, :WasteMeasure)");

		$wasteData->bindParam(':WasteType', $WasteType);
		$wasteData->bindParam(':WasteAmount', $WasteAmount);
		$wasteData->bindParam(':WasteOdor', $WasteOdor);
		$wasteData->bindParam(':WasteMeasure', $WasteMeasure);

		$wasteData->execute();

		
	} catch(Exception $e) {
		die(print_r($e));
	}

	try {
		// insert values into air_issue table
		$airData=$db->prepare("insert into air_issue (Visibility, Odor, Smoke_Check, SmokeColor, Symptom, symptomDescr, PM2_5, PM10, O3, SOx, NOx, CO) values (:Visibility, :AirOdor, :SmokeCheck, :SmokeColor, :Symptom, :symptomDescr, :PM2_5, :PM10, :O3, :SOx, :NOx, :CO)");



		// $airData=$db->prepare("insert into air_issue (Visibility, Odor, Smoke_Check, SmokeColor, Symptom, symptomDescr, PM2_5, PM10, O3, SOX, NOX, CO) values (:Visibility, :AirOdor, :SmokeCheck, :SmokeColor, :Symptom, :symptomDescr, :PM2_5, :PM10, :O3, :S0x, :NOx, :CO)");

		$airData->bindParam(':Visibility', $Visibility);
		$airData->bindParam(':AirOdor', $AirOdor);
		$airData->bindParam(':SmokeCheck', $SmokeCheck);
		$airData->bindParam(':SmokeColor', $SmokeColor);
		$airData->bindParam(':Symptom', $Symptom);
		$airData->bindParam(':symptomDescr', $symptomDescr);
		$airData->bindParam(':PM2_5', $PM2_5);
		$airData->bindParam(':PM10', $PM10);
		$airData->bindParam(':O3', $O3);
		$airData->bindParam(':SOx', $SOx);
		$airData->bindParam(':NOx', $NOx);
		$airData->bindParam(':CO', $CO);
		
		print_r("pass");
		$airData->execute();

	} catch(Exception $e) {
		die(print_r($e));
	}


	try {

		// insert values into water_issue table
		$waterData=$db->prepare("insert into water_issue (WaterType, WaterColor, TurbScore, Odor, CheckFloat, Floats, DO, pH, TurbParams, BOD, COD, TOC, TS, NH4, TP, Hg, Pb, Cd, Arsenic) values (:WaterType, :WaterColor, :WaterTurb, :WaterOdor, :checkFloat, :floatType, :DO, :pH, :Turbidity, :BOD, :COD, :TOC, :TS, :NH4, :TP, :Hg, :Pb, :Cd, :As)");


		// $waterData=$db->prepare("insert into water_issue (WaterType, WaterColor, Odor, CheckFloat, Floats, DO, pH, TurbParams, BOD, COD, TOC, TS, NH4, TP, Hg, Pb, Cd, Arsenic) values (:WaterType, :WaterColor, :WaterOdor, :checkFloat, :floatType, :DO, :pH, :Turbidity, :BOD, :COD, :TOC, :TS, :NH4, :TP, :Hg, :Pb, :Cd, As)");





		$waterData->bindParam(':WaterType', $WaterType);
		$waterData->bindParam(':WaterColor', $WaterColor);

		$waterData->bindParam(':WaterTurb', $WaterTurb);

		$waterData->bindParam(':WaterOdor', $WaterOdor);
		$waterData->bindParam(':checkFloat', $checkFloat);
		$waterData->bindParam(':floatType', $floatType);
		$waterData->bindParam(':DO', $DO);
		$waterData->bindParam(':pH', $pH);
		$waterData->bindParam(':Turbidity', $Turbidity);
		$waterData->bindParam(':BOD', $BOD);
		$waterData->bindParam(':COD', $COD);
		$waterData->bindParam(':TOC', $TOC);
		$waterData->bindParam(':TS', $TS);

		$waterData->bindParam(':NH4', $NH4);
		$waterData->bindParam(':TP', $TP);
		$waterData->bindParam(':Hg', $Hg);
		$waterData->bindParam(':Pb', $Pb);
		$waterData->bindParam(':Cd', $Cd);
		$waterData->bindParam(':As', $As);
		

		
		print_r("pass");
		$waterData->execute();

	} catch(Exception $e) {
		die(print_r($e));
	}
	

?>

