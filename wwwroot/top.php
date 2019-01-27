<!DOCTYPE html>
<html>
<head>
	<link href="WriteReview.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
  
  
	<title>Green Guide</title>
  <link rel="shortcut icon" href="green-pin.png">
</head>
<body>
      <div class="wrapper">
                  <div id="header">	
                        <div class="head">
                            <span><img src="lovegreenguide.png" alt="green" width="216" height="50"/></span>
                            
                        </div>
                  
                        <div id="search">
                                <div id="in_s">
                                      <form action="search-all.php" >
                                            <input id="suggestId" name="s_company" type="text" size="62" placeholder="Company Name / (Location + Company Name) / Industry / Product " autofocus /> 
                                            <input name="s_location" type="text" size="22" placeholder="Near Location" />  
                                            <input type="submit" value="go" />  
                                      </form>
                                </div>
                                <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                                <div id="getCompany"></div>

                                <nav>
                                     <ul id="topmenu">
                                          <li id="home"><a href="index.php">Home</a></li>
                                          <li id="profile"><a href="profile.php">My Reviews</a></li>
                                          <li id="review"><a href="WriteReview.php">Write a Community Review</a></li>
                                          <li id="map"><a href="map.php">Explore Reviews on a Map</a></li>
                                          <li id="guideline"><a href="guidelines.php">Guidelines</a></li>
                                          <!--<li><a href="Apple.php">Apple Supplier Map</a></li> -->
                                     </ul> 
                                </nav>
                                                   
                       </div> 

                       <div id="side">
                                <div style="margin-bottom:1em;"><a href="signup.php">Sign Up</a></div>
                                <div><a href="user.php">Log In/Out</a></div>
                       </div> 

                       <div id="language">
                                <a id="lang"  href="user.php">中文</a>
                       </div> 
                                      
                   </div>    
                   
                 <!--
                 <div class="clear"></div>
               -->
                                     
      
      <?php
			if(!isset($_SESSION)){
				session_start();
			}

			if(isset($_SESSION["flash"])){
				?>
                <div id="flash"><?=$_SESSION["flash"]?></div>
                <?php
				unset($_SESSION["flash"]);
			}

  	  ?>
