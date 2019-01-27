<?php

include("db.php");
ensure_logged_in();

?>

<!DOCTYPE html>
<html>
<head>
	<link href="WriteReview.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
   
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
	<script src="map_search.js" type="text/javascript"></script>
	<title>User Profile</title>
	<link rel="shortcut icon" href="green-pin.png">
</head>
<body>
      <div class="wrapper">
                 <header id="header">	                                        
                        <div class="head">
                            Green Guide
                        </div>
                  
                        <div id="search">
                                <div id="in_s">
                                      <form action="search-all.php" >
                                            <input id="suggestId" name="s_company" type="text" size="62" placeholder="Company Name or related keyword ex. location" autofocus /> 
                                            <input name="s_location" type="text" size="22" placeholder="Near Location" />  
                                            <input type="submit" value="go" />  
                                      </form>
                                </div>
                                <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                                <div id="getCompany"></div>

                                <nav>
                                     <ul id="topmenu">
                                          <li><a href="index.php">Home</a></li>
                                          <li><a href="profile.php">User Profile</a></li>
                                          <li><a href="WriteReview.php">Write a Community Review</a></li>
                                          <li><a href="map.php">Explore Reviews on a Map</a></li>
                                         
                                     </ul> 
                                </nav>
                                                   
                       </div> 

                       <div id="side">
                                <a href="signup.php">Sign Up</a><br/><br/>
                                <a href="user.php">Log In/Out</a>
                       </div> 
                  </header>       
                  <div id="allmap"></div>
                  <h2>Your Reviews: </h2>
                  <div id="list"></div>
                  <div id="loading" style="display: none">
						<img src="loading.gif" />
						Loading ...
				  </div>
                  <div id="getedit"></div>
                  <div id="imgedit"></div>
                  <div id="page"></div>

                  	
					<div class="headfoot">
				                <p>
				                    <q>Share your feeling about the environment to the world!</q> - Green Guide<br />
				                    All pages and content &copy; Copyright Green Guide Inc.
				                </p>
				    
				                <div id="w3c">
				                    <a href="https://webster.cs.washington.edu/validate-html.php">
				                        <img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
				                    <a href="https://webster.cs.washington.edu/validate-css.php">
				                        <img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
				                    <a href="https://webster.cs.washington.edu/jslint/?referer">
				                        <img src="https://webster.cs.washington.edu/images/w3c-js.png" alt="Valid CSS" /></a>
				                </div>
			        </div>
                  
      </div>
</body>
</html>




