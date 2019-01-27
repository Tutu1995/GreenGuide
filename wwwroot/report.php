<?php
	 include("db.php");
	 header("Content-type: application/json");
		  	  
	 $id=$_POST["id"];
	 $reason=$_POST["reason"];

	 try{
              
			  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  
			  $reviews=$db->query("select report, reason from review where id='$id' ");
			
			  if(reviews){
					foreach($reviews as $review)
					{					 
						$report=$review[0];
						$r_reason=(string)$review[1]." ".(string)$reason;

						if ($report){
							$report++;
						}
						else{
							$report=1;							
						}
						$update_r=$db->query("update review set report = '$report' where id='$id' ");
						$update_reason=$db->query("update review set reason = '$r_reason' where id='$id' ");
					}
				}
				echo $id;
        }
        catch(Exception $e){
              die(print_r($e));
        }

?>