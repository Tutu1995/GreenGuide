<?php
	
	
	
	
	try {

		// intert values solid_issue table
		$wasteData=$db->prepare("insert into solid_issue (WasteType, Amount, Odor, Measurements, review_id) values (:WasteType, :WasteAmount, :WasteOdor, :WasteMeasure, :reviewID)");

		$wasteData->bindParam(':WasteType', $WasteType);
		$wasteData->bindParam(':WasteAmount', $WasteAmount);
		$wasteData->bindParam(':WasteOdor', $WasteOdor);
		$wasteData->bindParam(':WasteMeasure', $WasteMeasure);
		$wasteData->bindParam(':reviewID', $last_id);

		$wasteData->execute();

		
	} catch(Exception $e) {
		die(print_r($e));
	}

	try {
		// insert values into air_issue table
		$airData=$db->prepare("insert into air_issue (Visibility, Odor, Smoke_Check, SmokeColor, Symptom, symptomDescr, PM2_5, PM10, O3, SOx, NOx, CO, review_id) values (:Visibility, :AirOdor, :SmokeCheck, :SmokeColor, :Symptom, :symptomDescr, :PM2_5, :PM10, :O3, :SOx, :NOx, :CO, :reviewID)");



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
		$airData->bindParam(':reviewID', $last_id);
		
		print_r("pass");
		$airData->execute();

	} catch(Exception $e) {
		die(print_r($e));
	}


	try {

		// insert values into water_issue table
		$waterData=$db->prepare("insert into water_issue (WaterType, WaterColor, TurbScore, Odor, CheckFloat, Floats, DO, pH, TurbParams, BOD, COD, TOC, TS, NH4, TP, Hg, Pb, Cd, Arsenic, review_id) values (:WaterType, :WaterColor, :WaterTurb, :WaterOdor, :checkFloat, :floatType, :DO, :pH, :Turbidity, :BOD, :COD, :TOC, :TS, :NH4, :TP, :Hg, :Pb, :Cd, :As, :reviewID)");


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
		$waterData->bindParam(':reviewID', $last_id);
		

		
		print_r("passtest");
		$waterData->execute();

	} catch(Exception $e) {
		die(print_r($e));
	}
	

?>

