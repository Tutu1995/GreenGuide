<?php
		  include("db.php");
  		  ensure_logged_in();

		  $id=htmlspecialchars($_POST["id"]);
          $review=htmlspecialchars($_POST["review"]);
		  
		  $rating=htmlspecialchars($_POST["rating"]);
          
		  $water=pType("Water", $_POST["water"]);
          $air=pType("Air", $_POST["air"]);
          $waste=pType("Waste", $_POST["waste"]);
          $land=pType("Land", $_POST["land"]);
          $living=pType("Living", $_POST["living"]);
          $other=pType("Other", $_POST["other"]);


          $other_item=htmlspecialchars($_POST["other_item"]);
        
		  
		  function pType ($p_name, $p_type){
			  if  (isset($p_type))
			  {				  
				  return $p_name;
			  }
			  else{
				  return htmlspecialchars($p_type);
			  }
		  }

		  if  (isset($other_item))
		  {				  
				$other=$other_item;
		  }
		  		  
		  $news=htmlspecialchars($_POST["news"]);

		  $industry=htmlspecialchars($_POST["industry"]);
          $product=htmlspecialchars($_POST["product"]);
		  $epa=htmlspecialchars($_POST["epa"]);
		  $measure=htmlspecialchars($_POST["measure"]);	

		
		  $s_edit_token=htmlspecialchars($_POST["s_edit_token"]);

		  if(!isset($_POST["s_edit_token"]) || !isset($_SESSION["s_edit_token"]) || $_POST["s_edit_token"] !== $_SESSION["s_edit_token"]) {
						print "Error: Your session is invalid. Transfer not performed";
						die();
				  } else {
				  		unset($_SESSION["s_edit_token"]);
				  try{
						  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
						  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						  	  
						  //$result=$con->query("update review set review=$review, rating=$rating, water=$water, air=$air, waste=$waste, land=$land, living=$living, other=$other, news=$news where id=$id ");
				     

						   		  $checkid=$db->prepare("select id from profile where review_id=:id and name=:name");	
								  $checkid->bindParam(':id', $id);
								  $checkid->bindParam(':name', $_SESSION["name"]);
								  $checkid->execute();
								  
								  if($checkid){
										foreach($checkid as $check_id){

												  $result=$db->prepare("update review set review=:review, rating=:rating, water=:water, air=:air, waste=:waste, land=:land, living=:living, other=:other, industry=:industry, product=:product, epa=:epa, measure=:measure, news=:news, status=:status where id=:id");					    
												  
												  $result->bindParam(':id', $id);
												  $result->bindParam(':review', $review);
										
												  $result->bindParam(':rating', $rating);

												  $result->bindParam(':water', $water);
												  $result->bindParam(':air', $air);
												  $result->bindParam(':waste', $waste);
												  $result->bindParam(':land', $land);
												  $result->bindParam(':living', $living);
												  $result->bindParam(':other', $other);
												  $result->bindParam(':news', $news);

												  $result->bindParam(':industry', $industry);
												  $result->bindParam(':product', $product);
												  $result->bindParam(':epa', $epa);
												  $result->bindParam(':measure', $measure);

												  $result->bindValue(':status', null, PDO::PARAM_INT);

												  $result->execute();
												}
								  }

				     }
					 catch(Exception $e){
						  //die(print_r($e));
					 	die("Sorry, error occured. Please try again.");
					 }

		  }

	header("Location:http://www.lovegreenguide.com/profile.php");
	die;
?>