<?php
include("top_1113bootest.php");
include("db.php");
 //include('db.php');
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
				
						//echo '<div>您的帐号已开启. 请 <a href="user.php">登录</a>.</div>';
		   		?>
		   				<div class="alert alert-success text-center">
							您的帐号已开启. 请 <a href="user.php">登录</a>.
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
			   //echo "错误发生";
			   	?>
				   		<div class="alert alert-warning text-center">
							此电子邮件已经注册或发生错误
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