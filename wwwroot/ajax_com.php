<?php  
          header("Content-type: application/json");
		  
		  $lng=$_GET["lng"];
          $lat=$_GET["lat"];
		  $page=$_GET["page"];
		  $company=$_GET["company"];
          
          try{
             
			  
			  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  
			  $reviews=$con->query("select * from review where company='$company' and lng='$lng' and lat='$lat' ");
			  $reviews_c=$con->query("select COUNT(*) from review where company='$company' and lng='$lng' and lat='$lat' ");
			  
			  $all= array();
			  if(reviews){
					foreach($reviews as $review)
					{					 
						
						//$p_image= array();
						$images=$con->query("select * from image where review_id=$review[0] ");
						$images_c=$con->query("select COUNT(*) from image where review_id=$review[0] ");
						/*
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
								  
							  }
						}
						$all[]=array("review"=>$review,"all_image"=>$p_image);	
						*/
						$all[]=array("review"=>$review, "img_count" => $images_c -> fetchColumn());				  
					}
			  
			  $json = array(
			  		"company"=>	$company,		  	    
				    "lng"=> $lng,
				    "lat" => $lat,
				    "page" => $page,
				  	"review_count" => $reviews_c -> fetchColumn(),	  	
				  	"all" => array_slice($all, ($page-1)*10, 10),
			  );
			  
			  
			  print json_encode($json);
			  }
					 
			
          }
          catch(Exception $e){
              //die(print_r($e));
          		die("Sorry. Error occurred. Please try again.");
          }
                   
  ?>
