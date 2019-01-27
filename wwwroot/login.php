<?php

//if(!isset($_SESSION)) {session_start();}

	  #login form submits to here.
	  #Upon login, remember students login name in a PHP session variable.
	  include("db.php");

	  $name= htmlspecialchars($_POST["email"]);
	  $password= htmlspecialchars($_POST["password"]);
	  $token_user=htmlspecialchars($_POST["token_user"]);

	  if(!isset($token_user) || !isset($_SESSION["token_user"]) || $token_user !== $_SESSION["token_user"]) {
				print "Error: Your session is invalid. Transfer not performed";
				die();
		  } else {
		  		unset($_SESSION["token_user"]);

		  if(isset($name) && isset($password)){
			  
			  if (is_password_correct($name, $password)){
			  		$_SESSION["name"]=$name;		#start session, remember user info
					redirect("http://www.lovegreenguide.com/index.php","Login successful! Welcome back.");
			  } else{
			  	redirect("http://www.lovegreenguide.com/user.php","Incorrect user name and/or password.");
			  }
		  }
	  }

?>