<!DOCTYPE html>
<html>
<head>
	<link href="WriteReview.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
   
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>

	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<title>Explore Reviews</title>
	<link rel="shortcut icon" href="green-pin.png">
</head>
<body>
      
      			<?php
					include("header_b.php");
				?>

				
          <div id="newmap" class="map_s"></div>
                  
          <div class="container-fluid"><h3 id="count_c"></h3></div>
          <div id="loading" style="display: none">
						<img src="loading.gif" />
						Loading ...
				  </div>
				  <div id="list"></div>
				  <div class="container-fluid"><div id="page"></div></div>
				  <div id="getMap_point"></div>
				 
          <footer class="text-center">
					  <br><br><br>
					  <p>Share your feelings about the environment to the world! <a href="http://www.lovegreenguide.com" data-toggle="tooltip" title="LoveGreenGuide">- LoveGreenGuide </a></p>
					  <p>All pages and content &copy; Copyright Green Guide Inc.</p> 
				  </footer>
			
      
</body>
</html>
