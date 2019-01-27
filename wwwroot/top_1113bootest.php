<!DOCTYPE html>
<html>
<head>
	<link href="WriteReview.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<!--<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>-->


  <!-- Latest compiled and minified CSS -->
<!--
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
-->
  <!-- jQuery library -->
  <!--
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <!--
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
-->

  <!-- 新 Bootstrap 核心 CSS 文件 -->
  <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <!-- 可选的Bootstrap主题文件（一般不用引入） 
  <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  -->
  
  <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

  <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
  <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
  
	<title>Green Guide</title>
  <link rel="shortcut icon" href="green-pin.png">
</head>
<body>
      <!--<div class="wrapper">-->
                 

                 
                  <nav class="navbar navbar-default" style="margin-bottom:0px; background-color: white; border: white; ">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      
                      <a class="navbar-brand" href="index.php" style="color:green; font-size:25px; padding-top:10px;"><span><img src="green-pin.png" alt="green" width="28" height="35"/></span> LoveGreenGuide</a>
                    </div>

                    <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" >
                     
                      <form action="search-all.php" class="navbar-form navbar-right" role="search"  >
                                                              <div class="form-group">
                                                                  <label class="sr-only" for="s_company">company:</label>
                                                                  <input type="text" class="form-control input-sm" id="suggestId" name="s_company" placeholder="Company Name / (Location + Company Name) / Industry / Product " size="62">
                                                              </div>
                                                              <div class="form-group" >
                                                                  <label class="sr-only" for="s_location">location</label>
                                                                  <input type="text" class="form-control input-sm" name="s_location" placeholder="Near Location">
                                                              </div>
                        <button type="submit" class="btn btn-default btn-sm">Search for Reviews</button>
                      </form>
               
                    </div>

                    <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                    <div id="getCompany"></div>
                    
                  </div>
                </nav>




                  <nav class="navbar navbar-default" style="border-top-left-radius: 0; border-top-right-radius: 0; margin-bottom:0px; border: none;">
                    <div class="container-fluid">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" >
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span> 
                        </button>
                        <!--<a class="navbar-brand" href="index.php" style="color:lightgreen; font-size:22px; padding-top:2px;"><span><img src="green-pin_2.png" alt="green" width="25" height="30"/></span> LoveGreenGuide</a>-->
                        <a class="navbar-brand" href="index.php" ><span class="glyphicon glyphicon-home"></span></a>


                      </div>
                      <div class="collapse navbar-collapse" id="myNavbar" >
                        <ul class="nav navbar-nav">
                          
                          <li id="profile"><a href="profile.php">My Reviews</a></li>
                          <li id="review"><a href="WriteReview.php">Write a Community Review</a></li> 
                          <li id="map"><a href="map.php">Explore Reviews on a Map</a></li> 
                          <li id="guideline"><a href="guidelines.php">Guidelines</a></li>
                          <li id="about" class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">User Guide
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                  <li id="about_2"><a href="about.php">Pollution Measurement Guide</a></li>
                                  <li id="join"><a href="join.php">Pollution Impact</a></li>
                                  <li id="contact"><a href="contact.php">Sucessful Environmental restore cases</a></li>
                              </ul>
                          </li>
                          <li id="about" class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">About Us
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                  <li id="about_2"><a href="about.php">About Us</a></li>
                                  <li id="join"><a href="join.php">Join Us</a></li>
                                  <li id="contact"><a href="contact.php">Contact Us</a></li>
                              </ul>
                          </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                          <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                          <li><a href="user.php"><span class="glyphicon glyphicon-log-in"></span> LogIn/Out</a></li>
                          <li><a href="../ch/index.php">中文</a></li>
                        </ul>
                      </div>
                    </div>
                  </nav>



                           
      
      <?php
			if(!isset($_SESSION)){
				session_start();
			}

			if(isset($_SESSION["flash"])){
				?>
        <div class="container-fluid">
                <p id="flash"><?=$_SESSION["flash"]?></p>
        </div>
                <?php
				unset($_SESSION["flash"]);
			}

  	  ?>
