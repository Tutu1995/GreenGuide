<?php
	include("db.php");
	session_destroy();
	session_regenerate_id(TRUE);
	session_start();
	redirect("http://www.lovegreenguide.com/index.php","Logout sucessful.");
?>