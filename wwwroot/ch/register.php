<?php
include("top_1113bootest.php");
include("db.php");

$email=htmlspecialchars($_POST['email']);
$password=htmlspecialchars($_POST['password']);
$token_signup=htmlspecialchars($_POST["token_signup"]);
			

			if(!isset($token_signup) || !isset($_SESSION["token_signup"]) || $token_signup !== $_SESSION["token_signup"]) {
					print "		错误发生,无法执行";
					die();
			  } else {
			  		unset($_SESSION["token_signup"]);
try{
		//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
		//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($_POST['submit']))
		{
			   //whether the email is blank
			   if($email == '')
			   {
					$_SESSION['error']['email'] = "请输入邮箱";
					redirect("http://www.lovegreenguide.com/ch/signup.php","请输入邮箱");
			   }
			   else
			   {
					//echo "2";
					//whether the email format is correct
					if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email))
					{
						 //echo "3";
						 //if it has the correct format whether the email has already exist
						 //$email= $_POST['email'];
						 //echo $email;
						 $result1=$db->prepare("SELECT * FROM user WHERE email = :email AND com_code IS NULL");
						 $result1->bindParam(":email", $email);
						 $result1->execute();
						 if($result1){
							   foreach($result1 as $result){
									$_SESSION['error']['email'] = "邮箱已被使用";
									redirect("http://www.lovegreenguide.com/ch/signup.php","邮箱已被使用");
							   }
						 }
					}
					else
					{
						 //this error will set if the email format is not correct
						 $_SESSION['error']['email'] = "邮箱不正确";
						 redirect("http://www.lovegreenguide.com/ch/signup.php","邮箱不正确");
					}
		 		}
			   //whether the password is blank
			   if($password== '')
			   {
				    //echo "4";
					$_SESSION['error']['password'] = "請輸入密码";
					//echo "Password is required.";
					redirect("http://www.lovegreenguide.com/ch/signup.php","請輸入密码");
			   }
		 
			   //if the error exist, we will go to registration form
			   if(isset($_SESSION['error']))
			   {
					//redirect("http://greenguide.azurewebsites.net/signup.php","error exist.");
					//unset($_SESSION['error']);
			   	//echo "error exist.";
					//header("Location: http://greenguide.azurewebsites.net/signup.php");
			   		exit;
					
			   }
			   else
			   {
				    //echo "4";
					//$email = $_POST['email'];
					$password = md5($password);
					//$password = $_POST['password'];
					$com_code = md5(uniqid(rand()));
				  
					//$result2=$db->query("INSERT INTO user (email, password, com_code) VALUES ('$email', '$password', '$com_code')");
				  	$result2= $db->prepare("INSERT INTO user (email, password, com_code) VALUES (?, ?, ?)");
				  	$result2->execute(array($email, $password, $com_code));
					if($result2)
					{
					
						 $url = 'https://api.sendgrid.com/';
						 $user = 'azure_f92ef4ded444b595be806608868c3738@azure.com';
						 $pass = '2g6JXZNf0h83bac'; 
						
						 $params = array(
							  'api_user' => $user,
							  'api_key' => $pass,
							  'to' => $email,
							  'subject' => '爱绿评注册资讯',
							  'html' => '请连结至以下网址以开启帐号: http://www.lovegreenguide.com/ch/confirm.php?passkey='.$com_code,
							  'text' => 'http://www.lovegreenguide.com/ch/confirm.php?passkey='.$com_code,
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
						   

				   if($response)
							{
				   //echo "	帐号开启确认信已寄至您的邮箱";
				   ?>
				   		<div class="alert alert-success text-center">
						  帐号开启确认信已寄至您的邮箱!
						</div>
				   <?php
				   }
				   else
						 {
					//echo "	无法寄送帐号开启确认信至您的邮箱";
					?>
						<div class="alert alert-warning text-center">
						  无法寄送帐号开启确认信至您的邮箱
						</div>
					<?php
				   }
			  }
		   }
		}
}
		catch(Exception $e){
			//die(print_r($e));
			die("很抱歉!错误发生，请重新尝试.");
		}
	}

  include("footer.php");
  include("bottom_boo.php");

?>