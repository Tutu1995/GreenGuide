<?php

//if(!isset($_SESSION)) {session_start();}

	  #login form submits to here.
	  #Upon login, remember students login name in a PHP session variable.
	  include("db.php");

	  $name= htmlspecialchars($_GET["email"]);
	  $password= htmlspecialchars($_GET["password"]);
	  $token_signup=htmlspecialchars($_GET["token_signup"]);

	  if(!isset($token_signup) || $token_signup !== "06232017Job$") {
				//print "Error: Your session is invalid. Transfer not performed";
				die();
		  } else {
		  		//unset($_SESSION["token_user"]);

		  if(isset($name) && isset($password)){
			  
			  if (is_password_correct($name, $password)){
			  		//$_SESSION["name"]=$name;		#start session, remember user info
					//redirect("http://www.lovegreenguide.com/index.php","Login successful! Welcome back.");
			  		$myJSON = json_encode("Login successful! Welcome back.");
					echo $myJSON;
			  } else{
			  		$myJSON = json_encode("Incorrect user name and/or password.");
					echo $myJSON;
			  	//redirect("http://www.lovegreenguide.com/user.php","Incorrect user name and/or password.");
			  }
		  }
	  }

?>