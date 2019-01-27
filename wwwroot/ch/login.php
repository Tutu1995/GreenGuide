<?php

//if(!isset($_SESSION)) {session_start();}

	  #login form submits to here.
	  #Upon login, remember students login name in a PHP session variable.
	  include("db.php");

	  $name= htmlspecialchars($_POST["email"]);
	  $password= htmlspecialchars($_POST["password"]);
	  $token_user=htmlspecialchars($_POST["token_user"]);

	  if(!isset($token_user) || !isset($_SESSION["token_user"]) || $token_user !== $_SESSION["token_user"]) {
				print "错误:请重新登录";
				die();
		  } else {
		  		unset($_SESSION["token_user"]);

		  if(isset($name) && isset($password)){
			  
			  if (is_password_correct($name, $password)){
			  		$_SESSION["name"]=$name;		#start session, remember user info
					redirect("http://www.lovegreenguide.com/ch/index.php","登录成功! 欢迎!");
			  } else{
			  	redirect("http://www.lovegreenguide.com/ch/user.php","错误的使用者帐号或密码");
			  }
		  }
	  }

?>