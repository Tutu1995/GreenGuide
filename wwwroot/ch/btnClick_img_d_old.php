<?php
	 include("db.php");
	 ensure_logged_in();

	 $img_id=htmlspecialchars($_POST["img_id"]);
	 $id=htmlspecialchars($_POST["id"]);
	 $size=htmlspecialchars($_POST["size"]);
	 
	 /*
	 $img_d_token=htmlspecialchars($_POST["img_d_token"]);

	 if(!isset($_POST["img_d_token"]) || !isset($_SESSION["img_d_token"]) || $_POST["img_d_token"] !== $_SESSION["img_d_token"]) {
	        print "Error: Your session is invalid. Transfer not performed";
	        die();
	      } else {
	          unset($_SESSION["img_d_token"]);
	          */
					
				 	try{
			              
						  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
						  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						  
						
						  //$image=$con->query("delete from image where id='$img_id' ");
						  $image=$db->prepare("delete from image where id=:img_id ");					    
						  $image->bindParam(':img_id', $img_id);
						  $image->execute();

						  //$img_name="uploads/".$img_id.".*";
						  //unlink(realpath($img_name));


						  /*
						  	$img_size=$con->prepare("select size from image where id=:img_id ");
				            $img_size->bindParam(':img_id', $img_id);
				            $img_size->execute();
				            

				            if($img_size){  
				                foreach($img_size as $isize)  
				                {
				                     
*/
				                	$r_size=$db->prepare("select size from review where id=:id ");
						            $r_size->bindParam(':id', $id);
						            $r_size->execute();
						            

						            if($r_size){  
						                foreach($r_size as $rsize)  
						                {	
						                	 $d_size=$rsize[0]-$size;

						                     $set_rsize=$db->prepare("update review set size=:size where id=:id"); 
		                                     $set_rsize->bindParam(':id', $id);
		                                     $set_rsize->bindParam(':size', $d_size);
		 									 $set_rsize->execute(); 

		 								}
		 							}
				                  
				                //}
				            //}
						
					}
			        catch(Exception $e){
			              die(print_r($e));
			        }
	//}	    
		    
	 echo $img_id;
       

?>