<?php
			include("db.php");
			//include("top_1113bootest.php");
			
			$email = htmlspecialchars($_GET['email']);
			$token_signup=htmlspecialchars($_GET["token_signup"]);


			if(!isset($token_signup) || $token_signup !== "06232017Job$") {
					//print "Error: Your session is invalid. Transfer not performed";
					die();
			} else {

			//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			
			try{
				 $com_code = md5(uniqid(rand()));	
				 //$email=$db->quote($email);
				 //$results=$db->query("SELECT * FROM user WHERE email = $email");

				 $results=$db->prepare("SELECT * FROM user WHERE email = :email AND com_code IS NULL");
				 $results->bindParam(":email", $email);
				 $results->execute();


				 $count = $results->rowCount();
				 if($count>0){
					   foreach($results as $result){   
					   
							  //$pass=$db->query("select password from user where email=$email");
							//$setcom_code=$db->query("UPDATE user SET com_code='$com_code' WHERE email = $email");

							$setcom_code=$db->prepare("UPDATE user SET com_code='$com_code' WHERE email = :email");
							$setcom_code->bindParam(":email", $email);
							$setcom_code->execute();

							  //if($pass)
							  //{
									//foreach($pass as $p)
									//{	
										   //$password=$p[0];
										   
									
										   $url = 'https://api.sendgrid.com/';
										   $user = 'azure_f92ef4ded444b595be806608868c3738@azure.com';
										   $pass = '2g6JXZNf0h83bac'; 
										  
										   $params = array(
												'api_user' => $user,
												'api_key' => $pass,
												'to' => $email,
												'subject' => 'LoveGreenGuide info',
												//'html' => 'Your password:'.$password.'	  Please login at http://greenguide.azurewebsites.net/user.php ',
												'html' => 'Please click the link below to reset your password: http://www.lovegreenguide.com/reset.php?passkey='.$com_code.'&email='.$email,
												'text' => 'test',
												'from' => 'yiruli@uw.edu',
											 );
										  
										   $request = $url.'api/mail.send.json';
										  
										   // Generate curl request
										   $session = curl_init($request);
										  
										   // Tell curl to use HTTP POST
										   curl_setopt ($session, CURLOPT_POST, true);
										  
										   // Tell curl that this is the body of the POST
										   curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
										  
										   // Tell curl not to return headers, but do return the response
										   curl_setopt($session, CURLOPT_HEADER, false);
										   curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
										   
										   curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
										  
										   // obtain response
										   $response = curl_exec($session);
										   curl_close($session);
								  
								   // print everything out
								   //print_r($response);
									//} 
				  
								   if($response){
									   $myJSON = json_encode("Your password reset form has been sent to your email address.");
									   echo $myJSON;
									   /*
									    ?>
									   		<div class="alert alert-success text-center">
												Your password reset form has been sent to your email address.
											</div>
										<?php
										*/
								   }
								   else{
									   $myJSON = json_encode("LoveGreenGuide cannot send password reset form to your e-mail address.");
									   echo $myJSON;
									   /*
									    ?>
										   <div class="alert alert-warning text-center">
											    LoveGreenGuide cannot send password reset form to your e-mail address.
										   </div>
										<?php
										*/
								   }
							  //}
								   /*
						?>
							</div>
						<?php     */
					   }
				 }
				 else{
				 
					   $_SESSION['error']['email'] = "This Email doesn't exist.";
					   $Email_required = json_encode($_SESSION['error']['email']);
					   echo $Email_required;
					   //redirect("http://www.lovegreenguide.com/forget.php","This Email doesn't exist.");
				 
				 }
			 

		  }
		  catch(Exception $e){
			  //die(print_r($e));
		  	  die("Sorry. Error occurred. Please try again.");
		  }

	}

	//include("bottom.php");
	//include("footer.php");
    //include("bottom_boo.php");
?>