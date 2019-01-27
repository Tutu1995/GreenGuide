<?php
include("top_1113bootest.php");
include('db.php');
 $passkey = htmlspecialchars($_GET['passkey']);
 
 //echo $passkey;
 
 try{
			//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$email=$db->prepare("SELECT email FROM user WHERE com_code=:passkey");
			$email->bindParam(":passkey", $passkey);
			$email->execute();

			$results=$db->prepare("UPDATE user SET com_code=NULL WHERE com_code=:passkey");
			$results->bindParam(":passkey", $passkey);
			$results->execute();

			$count = $results->rowCount();
			//print("updated $count rows.\n");
		   if($count>0){
				?>
		   				<div class="alert alert-success text-center">
							Your account is now active. You may now <a href="user.php">Log in</a>.
						</div>
				<?php
						if($email){
					             		foreach($email as $email_d)
								 		{
											  $deluser=$db->prepare("delete from user WHERE email = :email AND com_code IS NOT NULL");	
											  $deluser->bindParam(':email', $email_d[0]);
									  		  $deluser->execute();				    										
								 		}
						}						
		   }
		   else{
			   //echo "Some error occur.";
			   ?>
				   		<div class="alert alert-warning text-center">
							This email is already registered or some error occured.
						</div>
				<?php
		   }
	}
	catch(Exception $e){
		die(print_r($e));
	}
 
include("footer.php");
include("bottom_boo.php");
?>