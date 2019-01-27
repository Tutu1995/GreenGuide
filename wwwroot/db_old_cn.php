<?php
if(!isset($_SESSION)) {session_start();}

$db=new PDO("mysql:dbname=mysql_greenguide;host=greenguide.mysqldb.chinacloudapi.cn","greenguide%yiruli","Uw1364228");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#Return true if given password is correct password for this user name.
function is_password_correct($name, $password){
		
		try{
			$db=new PDO("mysql:dbname=mysql_greenguide;host=greenguide.mysqldb.chinacloudapi.cn","greenguide%yiruli","Uw1364228");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$name= $db->quote($name);
			//$rows=$db->query("SELECT password FROM user WHERE email=$name AND com_code IS NULL");

			$rows=$db->prepare("SELECT password FROM user WHERE email=:email AND com_code IS NULL");
			$rows->bindParam(":email", $name);
			$rows->execute();
			$submitted_pw_hash=md5($password);
			if($rows){
				foreach($rows as $row){
					//if($password===$row["password"]){return TURE;}
					if($submitted_pw_hash===$row["password"]){return TURE;}					
				}
			}
			return FALSE;	#user not found, or wrong password
		}
		catch(Exception $e){
			//die(print_r($e));
			die("Sorry! Error occurred. Please try again.");
		}
}

#redirects current page to login.php if user is not logged in.
function ensure_logged_in(){
	if(!isset($_SESSION["name"])){
		redirect("http://www.lovegreenguide.com/user.php","Please enter your email address and password to log in.");
	}
}

#redirects current page to the given URL and optionally sets flash message.
function redirect($url,$flash_message=NULL){
	if($flash_message){
		$_SESSION["flash"]=$flash_message;
	}
	//header("Location: $url");
	if (!headers_sent()) {
	    header('Location: '.$url);
	    die;
	} else {
		echo '<script type="text/javascript">';
	    echo 'window.location.href="'.$url.'";';
	    echo '</script>';
		die;
	}
}


?>