<?php
			include("db.php");
			include("top_1113bootest.php");
			


			$email = htmlspecialchars($_POST['email']);
			$token_forget=htmlspecialchars($_POST["token_forget"]);

			?>
				<br>
				<div class="container">
			<?php
			print_r($email);

			if(!isset($token_forget) || !isset($_SESSION["token_forget"]) || $token_forget !== $_SESSION["token_forget"]) {
					print "錯誤發生,無法執行";
					die;
			  } else {
			  		unset($_SESSION["token_forget"]);

			//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			
			try{
				 $com_code = md5(uniqid(rand()));	
				 //$email=$db->quote($email);
				 //$results=$db->query("SELECT * FROM user WHERE email = $email");

				 $results=$db->prepare("SELECT * FROM user WHERE email = :email");
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
												'subject' => '爱绿评帐号资讯',
												//'html' => 'Your password:'.$password.'	  Please login at http://greenguide.azurewebsites.net/user.php ',
												'html' => '请连结至以下网址以重设密码: http://www.lovegreenguide.com/ch/reset.php?passkey='.$com_code.'&email='.$email,
												'text' => '请连结至以下网址以重设密码: http://www.lovegreenguide.com/ch/reset.php?passkey='.$com_code.'&email='.$email,
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
									   //echo "	密码重设确认信已寄至您的信箱";
								   	?>
								   		<div class="alert alert-success text-center">
											密码重设确认信已寄至您的邮箱!
										</div>
									<?php
								   }
								   else{
									   //echo "	无法寄送密码重设确认信至您的信箱";
									?>
									   <div class="alert alert-warning text-center">
										    无法寄送密码重设确认信至您的信箱
									   </div>
									<?php
								   }
							  //}
						?>
							</div>
						<?php
				   }
			 }
			 else{
			 
				   $_SESSION['error']['email'] = "此邮箱不存在";
				   redirect("http://www.lovegreenguide.com/ch/forget.php","此邮箱不存在");
			 
			 }
			 

	  }
	  catch(Exception $e){
		  //die(print_r($e));
	  	  die("Sorry. Error occurred. Please try again.");
	  }

	}

	//include("bottom.php");
	include("footer.php");
    include("bottom_boo.php");
?>