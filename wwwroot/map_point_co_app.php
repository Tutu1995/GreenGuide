<?php  
  		  include("db.php");
  		  //session_start();
		  //$company=$_GET["company"];
          
		  $lng=htmlspecialchars($_GET["lng"]);
		  $lat=htmlspecialchars($_GET["lat"]);
		  //the map show should deal with the history of the location 
		  //$company=htmlspecialchars($_GET["company"]);
		  
		  
		  try{
				  //$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 
				  //$rows=$con->query("select * from review where lng='$lng' and lat='$lat' and status=1 order by id DESC LIMIT 10 OFFSET 0 ");

				  //$rows = $db->prepare("select * from review where lng=:lng and lat=:lat and company=:company and status=1 order by id DESC LIMIT 10 OFFSET 0 ");
		  		  $rows = $db->prepare("select * from review where lng=:lng and lat=:lat and status=1 order by id DESC LIMIT 10 OFFSET 0 ");
				  $rows->bindParam(':lng', $lng);
				  $rows->bindParam(':lat', $lat);
				  //$rows->bindParam(':company', $company);
				  $rows->execute();

				  //$r_count=$con->query("select COUNT(id) from review where lng='$lng' and lat='$lat' and status=1");

				  //$r_count = $db->prepare("select COUNT(id) from review where lng=:lng and lat=:lat and company=:company and status=1 ");
				  $r_count = $db->prepare("select COUNT(id) from review where lng=:lng and lat=:lat and status=1 ");
				  $r_count->bindParam(':lng', $lng);
				  $r_count->bindParam(':lat', $lat);
				  //$r_count->bindParam(':company', $company);
				  $r_count->execute();

				  $review_count=$r_count -> fetchColumn();
				  
				  $all=array();
				  foreach ($rows as $row) {
				  		
						//$p_image= array();
						//$images=$con->query("select id from image where review_id=$row[0] ");
						$images_c=$db->query("select COUNT(id) from image where review_id=$row[0] ");

						$i_water;
						$waters=$db->query("select * from water_issue where review_id=$row[0] ");
						if($waters){	
							  foreach($waters as $water)	
							  {
								  $i_water=$water;
								 
							  }
						}
						//print_r("pass3");
						$i_air;
						$airs=$db->query("select * from air_issue where review_id=$row[0] ");
						if($airs){	
							  foreach($airs as $air)	
							  {
								  $i_air=$air;
								 
							  }
						}
						//print_r("pass4");
						$i_solid;
						$solids=$db->query("select * from solid_issue where review_id=$row[0] ");
						if($solids){	
							  foreach($solids as $solid)	
							  {
								  $i_solid=$solid;
								 
							  }
						}
						/*
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}*/
						$all[]=array("review"=>$row, "img_count" => $images_c -> fetchColumn(), "water"=> $i_water, "air"=>$i_air, "solid"=> $i_solid);	
				  } 

				  //$all[]=array_slice($all, (($rows_c -> fetchColumn())-(1*10))-1, 10)
				  
				  /*
				  $p_map=$db->query("select lng, lat, company, address, city, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=1 GROUP BY lng,lat,company ");
				  $a=array();
				  foreach ($p_map as $p) {				 
						$a[]=$p;
				  }
				  */	
				  /*
				  //$rows = $db->prepare("select rating from review where lng=:lng and lat=:lat and company=:company and status=1 order by id");
				  $rows = $db->prepare("select rating from review where lng=:lng and lat=:lat and status=1 order by id");
				  $rows->bindParam(':lng', $lng);
				  $rows->bindParam(':lat', $lat);
				  //$rows->bindParam(':company', $company);
				  $rows->execute();

				  $all_ratings=array();
				  foreach($rows as $row){
					    $all_ratings[] = $row;
				  }
				*/
				  
				  //$data = json_encode($a);
				  $all = json_encode($all);
				  //$lng = json_encode($lng);
				  //$lat = json_encode($lat);
				  //$rc = json_encode($review_count);

				  echo $all;
				  //echo $lng;
				  //echo $lat;
				  //echo $rc;
				  //echo $all_ratings;
				  
			  }
		  catch(Exception $e){
			  //die(print_r($e));
		  		die("Sorry. Error occurred. Please try again.");
		  }
				  
?>		  