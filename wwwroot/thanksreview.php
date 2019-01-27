<?php  
          
		  $company=$_POST["company"];
          $address=$_POST["address"];
          $review=$_POST["review"];
		  $lng=$_POST["lng"];
		  $lat=$_POST["lat"];
          $water=$_POST["water"];
          $air=$_POST["air"];
          $waste=$_POST["waste"];
          $land=$_POST["land"];
          $living=$_POST["living"];
          $other=$_POST["other"];
		  $news=$_POST["news"];
		  $image_1=$_FILES["pic"]["tmp_name"];
		  $pic_name=$_FILES["pic"]["name"];
		  //$image_2=file_get_contents($image_1);
		  //$image=base64_encode($image_2);
		  
		  //print_r($_FILES);
          
          $server = "tcp:rhrcl8b8ia.database.windows.net,1433";
          $user = "yiruli@rhrcl8b8ia";
          $pwd = "Uw1364228";
          $db = "GreenGuide";
          
          try{
              $conn = new PDO( "sqlsrv:Server= $server ; Database = $db ", $user, $pwd);
              $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  
              //if(isset($_POST["company"]) && isset($_POST["address"]) && isset($_POST["review"])) {
				  
				  //$insert_img="INSERT INTO image (Pic_name, Pic) VALUES ('$pic_name','$image')";
                                        
                  $insert="INSERT INTO test_review (Company, Address, Review) VALUES ('$company','$address','$review')";
				  //$dispaly="select * from image";
               
			   //$result_img=$conn->query($insert_img);
               $result=$conn->query($insert);
			   //$result_show_img= $conn -> query($dispaly);
			   
	
              //} 
          }
          catch(Exception $e){
              die(print_r($e));
          }
                   
  ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thank You for the Review!</title>
<link href="WriteReview.css" type="text/css" rel="stylesheet" />
<style type="text/css">
            body, html{width: 100%;height: 100%;margin:0;font-family:"微软雅黑";font-size:14px;}
</style>
</head>

<body>
      <div class="wrapper">
            <header>	
                  <p class="head">
                      Green Guide
                  </p>
              
                  <div id="search">
                      <!-- form to search for every movie by a given actor -->
                      <form action="search-all.php" method="post" >
                              <div>
                                  <input name="firstname" type="text" size="24" placeholder="Company Name" autofocus /> 
                                  <input name="lastname" type="text" size="24" placeholder="Near Location" /> 
                                  <input type="submit" value="go" />
                              </div>
                      </form>
                   </div>  
                   
                   <nav>
                       <ul id="topmenu">
                            <li>Home</li>
                            <li>User Profile</li>
                            <li><a href="WriteReview.php">Write a Community Review</a></li>
                            <li>Explore Reviews on a Map</li>
                       </ul> 
                   </nav>
             </header> 
             <div class="main">      
                Thank you for the review!
             </div>
      </div>
</body>
</html>