<?php
	
	include("db.php");

	try {
		$rows = $db->prepare("SELECT * FROM ipe_data");
		$rows->execute();
		$a = array();
		foreach($rows as $row) {
			$a[] = $row;
		}

		$data = json_encode($a);
		echo $data;
	} catch(Exception $e) {
		die(print_r($e));
	}

?>