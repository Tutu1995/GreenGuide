<?php
	 session_start();
	 include("db.php");
	 header("Content-type: application/json");

	 $id=$_POST["id"];
	 $vote_c=$_POST["vote_c"];
	 $isset=0;


	 
			if(!isset($_SESSION["vote"][$id]) && !isset($_COOKIE[$id])){			
				 	try{
			              
						  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
						  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						  
						  $reviews=$db->query("select help from review where id='$id' ");
						
						  if(reviews){
								foreach($reviews as $review)
								{					 
									$help=$review[0];
									if ($help){
										$help++;
									}
									else{
										$help=1;							
									}
									$update_h=$db->query("update review set help = '$help' where id='$id' ");
								}
							}
							$_SESSION["vote"][$id]=$id;
							$exp=time()+(60*60*24*30);
							setcookie($id,$id,$exp);
							
							if ($vote_c=="null"){
								$vote_c=1;	
							}
							else{		
								$vote_c++;						
							}

							$isset++;
			        }
			        catch(Exception $e){
			              die(print_r($e));
			        }
		    }


        $json = array(			  	
				  "id" => $id,
				  "vote_c"=> $vote_c,
				  "set"=> $isset,
			  	);
			  
		print json_encode($json);

?>