<?php
	include("db.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
	</style>

   
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>

	<title>地址解析</title>
</head>
<body>
	<div id="allmap"></div>
	<div>
		<input id="lng" type="hidden" name="lng">
	    <input id="lat" type="hidden" name="lat"> 
	</div>
</body>
</html>

<?php
	try {
		$locs = $db->query("select CompanyLocation from ipe_data");
		$cities = array();
		foreach ($locs as $loc) {
			$cities[] = $loc;
		}

		$ipeids = $db->query("select ipeID from ipe_data");
		$ids = array();
		foreach ($ipeids as $ipeid) {
			$ids[] = $ipeid;
		}
	} catch(Exception $e){
	//die(print_r($e));
		die("Sorry, error occured. Please try again.");
	}
	
?>

<script type="text/javascript">
	var coordinate = [];
	var ajax = new XMLHttpRequest();
	ajax.onload = getLngLat;
	ajax.open("GET", "http://api.map.baidu.com/geocoder/v2/?callback=renderOption&output=json&address=北京市海淀区上地10街10号&city=北京市&ak=AVpUxExAZfNTcMV8Wn1uccLu", true);
	ajax.send();
	

	function getLngLat() {
		alert("start");
		if (this.status == 200) {
			var coord = [];
			var jason = JSON.parse(this.responseText);
			alert(jason);
			alert(jason.result.location.lng);
			coord.push(jason.result.location.lng);
			coord.push(jason.result.location.lat);
			coordinate.push(coord);
		}
	}
	alert("test");
	alert(coordinate[0]);



	// var ajax = new XMLHttpRequest();
 // 	ajax.open("GET", "http://api.map.baidu.com/geocoder/v2/?callback=renderOption&output=json&address=北京市海淀区上地10街10号&city=北京市&ak=AVpUxExAZfNTcMV8Wn1uccLu", true);
 // 	ajax.send();

	// function sendGet(pk, long, lat) {
	// 	var ajax = new XMLHttpRequest();
	// 	var params = new FormData();
	// 	params.append("ipeID", pk);
	// 	params.append("longitude", long);
	// 	params.append("latitude", lat);
	//  	ajax.open("POST", "http://www.lovegreenguide.com/saveLngLat.php", true);
	//  	ajax.send(params);
	// }

	// var map = new BMap.Map("allmap");
	// var point = new BMap.Point(116.331398,39.897445);
	// map.centerAndZoom(point,12);

	var locations = <?php echo json_encode($cities) ?>;
	var pks = <?php echo json_encode($ids) ?>;
	// var coordinate = []; 
	// for (i = 0; i < 3; i++) {
	// 	var myGeo = new BMap.Geocoder();
	// 	myGeo.getPoint(locations[i].CompanyLocation, function(point){
	// 		if (point) {
	// 			document.getElementById("lng").value = point.lng;
	// 			document.getElementById("lat").value = point.lat;
	// 		}
	// 	});
	// 	var coord = [];
	// 	alert(document.getElementById("lng").value);
	// 	coord.push(document.getElementById("lng").value);
	// 	coord.push(document.getElementById("lng").value);
	// 	coordinate.push[coord];
	// }
	// alert(document.getElementById("lng").value);

	// var len = pks.length;
	// for (i = 0; i < len; i++) {
	// 	sendGet(pks[i].ipeID, coordinate[i][0], coordinate[i][1]);
	// }

</script>