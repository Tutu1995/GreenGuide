<?php
			include("db.php");
			ensure_logged_in();
			header("Content-type: application/json");

			$page=$_GET["page"];

			try{

				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				  
				  
				  $s_name=$_SESSION["name"];
				  $rows=$con->query("select lng, lat, company, address, city, AVG(rating) as avg_r from review r join profile p on r.id= p.review_id where p.name='$s_name' GROUP BY lng,lat,company ");
				  $a=array();
				  foreach ($rows as $row) {
				  
						$a[]=$row;
				  } 
				  
				  $reviews=$con->query("select * from review r join profile p on r.id= p.review_id where p.name='$s_name' ");
				  $reviews_c=$con->query("select COUNT(*) from review r join profile p on r.id= p.review_id where p.name='$s_name' ");
				  
				  $all=array();
				  foreach ($reviews as $review) {
						//$p_image= array();
						$images=$con->query("select * from image where review_id=$review[0] ");
						$images_c=$con->query("select COUNT(*) from image where review_id=$review[0] ");
						//$image_count = $images_c -> fetchColumn()
						//$img_count = $images -> fetchColumn()
						/*
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}
						*/
						//$all[]=array("review"=>$review,"all_image"=>$p_image);	
						$all[]=array("review"=>$review, "img_count" => $images_c -> fetchColumn());
						//$all[]=array("review"=>$review);
				  }

				  //array_slice($all, ($page-1)*10, 10);

				  $json = array(
				  	"page" => $page,
				  	"review_count" => $reviews_c -> fetchColumn(),
				  	"data"	=> $a,		  	
				  	"all" => array_slice($all, ($page-1)*10, 10),

				  );
				  
				  
				  print json_encode($json);
				  				  
			  }
			  catch(Exception $e){
				  //die(print_r($e));
			  		die("Sorry. Error occurred. Please try again.");
			  }

?>