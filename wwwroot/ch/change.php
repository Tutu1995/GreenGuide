<?php
if(!isset($_SESSION)) {session_start();}
include("top_1113bootest.php");
include("db.php");
 //include('db.php');
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
$confirmpassword = htmlspecialchars($_POST["confirmpassword"]);
$token_reset=htmlspecialchars($_POST["token_reset"]);
//print_r($email);
//print_r($password); 
 //echo $passkey;

if(!isset($token_reset) || !isset($_SESSION["token_reset"]) || $token_reset !== $_SESSION["token_reset"]) {
				print "錯誤發生,無法執行";
				die();
		  } else {
		  		unset($_SESSION["token_reset"]);

?>
	<br>
	<div class="container">
<?php

 try{
			//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($password == $confirmpassword)
			{
				$password = md5($password);
				//$update_p=$db->query("UPDATE user SET password='$password' WHERE email = '$email'");

				$update_p = $db->prepare("UPDATE user SET password = :password WHERE email = :email");
				$update_p->bindParam(':password', $password);
				$update_p->bindParam(':email', $email);
				$update_p->execute();

				session_destroy();
				session_regenerate_id(TRUE);
				session_start();

				//echo "Your password has been successfully reset.";
				//echo '<div>您的密码已经重设，请 <a href="user.php">登录</a></div>';
				//print_r($password);
				?>
		   				<div class="alert alert-success text-center">
							您的密码已经重设, 请 <a href="user.php">登录</a>.
						</div>
				<?php

			}
        	else{
				echo "密码不一致";
			}
    }
	catch(Exception $e){
		//die(print_r($e));
		die("很抱歉!错误发生，请重新尝试.");
	}

}
 
?>
		</div>
		<br><br><br>
	<?php
 
  	include("footer.php");
  	include("bottom_boo.php");
?>