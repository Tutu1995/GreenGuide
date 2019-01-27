<?php
			
			header("Content-type: application/json");

			$id=htmlspecialchars($_POST["id"]);

			try{
					
				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				  
				  
				 
						$p_image= array();

						//$images=$con->query("select * from image where review_id= '$id' ");
						$images=$con->prepare("select * from image where review_id=:id ");
			            $images->bindParam(':id', $id);
			            $images->execute();
						
						if($images){ 
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}
						
						//$all[]=array("review"=>$review,"all_image"=>$p_image);	
						
				  
				
				  
				  $json = array(
				  		  	
				  	"all_image"=>$p_image,
				  	"id"=>$id,

				  );
				  
				  
				  print json_encode($json);
				  				  
			  }
			  catch(Exception $e){
				  //die(print_r($e));
			  		die("Sorry. Error occurred. Please try again.");
			  }

?>