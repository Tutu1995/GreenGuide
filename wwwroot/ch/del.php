<?php
	 include("db.php");
	 ensure_logged_in();

	 header("Content-type: application/json");
	 $id=htmlspecialchars($_POST["id"]);
/*
	 $del_token=htmlspecialchars($_POST["del_token"]);

	 if(!isset($_POST["del_token"]) || !isset($_SESSION["del_token"]) || $_POST["del_token"] !== $_SESSION["del_token"]) {
	        	print "Error: Your session is invalid. Transfer not performed";
	        	die();
	      } else {
	          	unset($_SESSION["del_token"]);
	 
				*/	
				 	try{
			              
						  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
						  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						  $checkid=$db->prepare("select id from profile where review_id=:id and name=:name");	
						  $checkid->bindParam(':id', $id);
						  $checkid->bindParam(':name', $_SESSION["name"]);
						  $checkid->execute();
						  
						  if($checkid){

						  		$upimg=$db->prepare("select id, file_type from image where review_id=:id ");
					            $upimg->bindParam(':id', $id);
					            $upimg->execute();

					            if($upimg){

					             		foreach($upimg as $img_id)
								 		{
											  $img_name="../uploads/".$img_id[0].".".$img_id[1];
											  unlink($img_name);		  
								 		}
								}	

								foreach($checkid as $check_id){
									  //$reviews=$con->query("delete from review where id='$id' ");
									  $reviews=$db->prepare("delete from review where id=:id ");					    
									  $reviews->bindParam(':id', $id);
									  $reviews->execute();

									  //$profile=$con->query("delete from profile where review_id='$id' ");
									  $profile=$db->prepare("delete from profile where review_id=:id ");					    
									  $profile->bindParam(':id', $id);
									  $profile->execute();

									  //$image=$con->query("delete from image where review_id='$id' ");
									  $image=$db->prepare("delete from image where review_id=:id ");					    
									  $image->bindParam(':id', $id);
									  $image->execute();
								}
						  }
					}
			        catch(Exception $e){
			              //die(print_r($e));
			        		die("Sorry, error occured. Please try again.");
			        }
	
		//}
        $json = array(			  	
				  "id" => $id,				 
			  	);
			  
		print json_encode($json);

?>