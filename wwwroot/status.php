<?php
	 include("db.php");
	 header("Content-type: application/json");
	 $id=$_POST["id"];
	 $r_status=$_POST["r_status"];
	 

					
				 	try{
			              
						  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
						  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						  $reviews=$db->query("UPDATE review SET status=$r_status WHERE id='$id'");
						  
					}
			        catch(Exception $e){
			              die(print_r($e));
			        }
		    
		    
	

        $json = array(			  	
				  "id" => $id,
				 
			  	);
			  
		print json_encode($json);

?>