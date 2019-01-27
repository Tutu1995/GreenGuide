<?php  
		  include("db.php");

		  ensure_logged_in();


		  if(isset($_SESSION["review_id"])){
		  		$review_id = $_SESSION["review_id"];
		  		unset($_SESSION["review_id"]);
		  }else{
		  		header("Location: http://greenguide.azurewebsites.net/ch/profile.php");
		  }
		  try{
				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!DOCTYPE html>
<html>
	<head>
		
		<title>Confirm a Review</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
 
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <link rel="shortcut icon" href="green-pin.png">

        <!-- Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	    <!-- jQuery library -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	    <!-- Latest compiled JavaScript -->
	    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</head>

	<body>
        
        		<?php
					include("header_b.php");
				?>
      			<!--
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
                                          <li><a href="profile.php">My Profile</a></li>
                                          <li id="review"><a href="WriteReview.php">Write a Community Review</a></li>
                                          <li><a href="map.php">Explore Reviews on a Map</a></li>
                                         
                                     </ul> 
                                </nav>
                                                   
                       	</div> 
                       
                       <div id="side">
                                <div style="margin-bottom:1em;"><a href="signup.php">Sign Up</a></div>
                                <div><a href="user.php">Log In/Out</a></div>
                       </div>  
            	</header>       
		-->

            <div class="main">
                
                  <h2> Confirm the Review: </h2>
                  
                  <?php				  
				  $reviews=$con->query("select * from review where id= $review_id ");
				  foreach($reviews as $review)
				  {
					  $r_company=$review[1];
					  $r_address=$review[2];
					  $r_city=$review[3];
					  $r_review=$review[4];
					  $r_lng=$review[5];
					  $r_lat=$review[6];
					  $r_rating=$review[7];

					  $r_industry=$review[18];
					  $r_product=$review[19];

					  $r_water=$review[8];
					  $r_air=$review[9];
					  $r_waste=$review[10];
					  $r_land=$review[11];
					  $r_living=$review[12];
					  $r_other=$review[13];
					  $r_news=$review[14];
					  $r_epa=$review[20];
					  $r_measure=$review[21];
					  $r_time=$review[15];
					 				  
				  }	
				  ?>
                  
                  <p>
                  Company Name: <?=$r_company?><br/> 
                  Company Address: <?=$r_address?>  City: <?=$r_city?><br/> 
                  </p>
                 
                  <div id="l-map"></div>
                  
                  <div id="mybox"><br/>
                          Thank you for the review! The review has been saved successfully as the following:
                  </div><br/> 
                  <div>
		                  <div id="s_review">
		                          Your Rating: <?=$r_rating?><br/>
		                          Your Reviews: <?=$r_review?><br/>
		                          Company Industry: <?=$r_industry?><br/>
		                          Company Product: <?=$r_product?><br/>
		                          Your Review Focus On: <?=$r_water?>  <?=$r_air?>  <?=$r_waste?>  <?=$r_land?>  <?=$r_living?>  <?=$r_other?><br/>
		                          Related News, Videos, or Links: <?=$r_news?><br/>
		                          EPA Data: <?=$r_epa?><br/>
		                          Measurement Data: <?=$r_measure?><br/>
		                          Time: <?=$r_time?><br/><br/>   
                  
		                  </div>          
        		 
		                  <div id="s_image">
				                  <?php
								  $show=$con->query("select id from image where review_id= $review_id ");
								  foreach($show as $img_id)
								  {
									  $img_name="uploads/".$img_id[0].".*";
									  //echo $img_name;
									  foreach(glob("$img_name") as $image){
									  		?>
										    	<img height="190" width="190" src="<?=$image?>" alt="user image"/>
										    <?php
									  }				  
								  }	
								  ?>
		                  </div><br/>
		          </div>

                <?php						
		  		}
		  	
		  		catch(Exception $e){
				    //die(print_r($e));
		  		 	die("Sorry, error occured. Please try again.");
			  		}	  
		 
				?>

				
			</div><br/>
					

			<div class="link">
					<br>
	            	<p>Check and Edit your reviews in <a href="http://greenguide.azurewebsites.net/ch/profile.php" style="text-decoration: underline;">My Profile</a>.</p>
	            	<p>Explore all the reviews in <a href="http://greenguide.azurewebsites.net/ch/map.php" style="text-decoration: underline;">Explore Reviews on a Map</a>.</p>
					<br><br>
			</div>


            		<br><br><br>
		  <?php
		 
		  	include("footer.php");
		  	include("bottom_boo.php");
		  ?>			
        
         
  	
    </body>
</html>

<script type="text/javascript">
	// 百度地图API功能
	"use strict";
	var lng=<?php echo $r_lng ?>;
	var lat=<?php echo $r_lat ?>;
	var rate=<?php echo $r_rating?>;

	document.getElementById("review").className="r_visited";

	//alert("lng:"+ lng);
	//alert("lat:"+ lat);
	var map = new BMap.Map("l-map");
	//var point = new BMap.Point(data.lng, data.lat);
	var point = new BMap.Point(lng, lat);
	map.centerAndZoom(point, 15);
	
	var m_color;
		//设置marker图标为水滴
		if (rate<-2){
			m_color="red";
		}
		else if(rate>=-2 && rate<-1 ){
			m_color="orange";
		}else if(rate>=-1 && rate<0){
			m_color="yellow";
		}else if(rate==0){
			m_color="white";
		}else if(rate>0 && rate<=1){
			m_color="aqua";
		}else if(rate>1 && rate<=2){
			m_color="lime";
		}else{
			m_color="green";
		}
		//alert(m_color);
		
		
		var marker = new BMap.Marker(new BMap.Point(lng, lat), {
		  // 指定Marker的icon属性为Symbol
		  icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
			scale: 1.5,//图标缩放大小
			fillColor: m_color,//填充颜色
			fillOpacity: 0.8//填充透明度
		  })
		});
		
	
	
	
	map.addOverlay(marker);            //增加点
	
	// 添加带有定位的导航控件
	var navigationControl = new BMap.NavigationControl({
	  // 靠左上角位置
	  anchor: BMAP_ANCHOR_TOP_LEFT,
	  // LARGE类型
	  type: BMAP_NAVIGATION_CONTROL_LARGE,
	  // 启用显示定位
	  enableGeolocation: true
	});
	map.addControl(navigationControl);
	// 添加定位控件
	map.disableScrollWheelZoom();
  	//禁用滚轮放大缩小
	
	
	
	// 百度地图API功能
	function G(id) {
		return document.getElementById(id);
	}
	
	var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
		{"input" : "suggestId"
		,"location" : map
	});

	ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
	var str = "";
		var _value = e.fromitem.value;
		var value = "";
		if (e.fromitem.index > -1) {
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
		
		value = "";
		if (e.toitem.index > -1) {
			_value = e.toitem.value;
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
		G("searchResultPanel").innerHTML = str;
	});

	var myValue;
	ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
	var _value = e.item.value;
		myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
		
		setPlace();
	});
	
	
	function setPlace(){
		
		function myFun(){
			var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
			
			//alert("marker的位置是" + pp.lng + "," + pp.lat);
			//alert("marker的位置是" + local.getResults().getPoi(0).title );
			//alert("marker的位置是" + local.getResults().getPoi(0).address);
			
			senGet(local.getResults().getPoi(0).title, pp.lng, pp.lat);
			
		}
		var local = new BMap.LocalSearch(map, { //智能搜索
		  onSearchComplete: myFun
		});
		local.search(myValue);
	}
	
	
	function senGet(company, lng, lat)
    {
        var mydiv = document.getElementById('getCompany').innerHTML = '<form id="getC"  action="company.php"><input name="company" type="hidden" value="'+ company +'" /><input name="lng" type="hidden" value="'+ lng +'" /><input name="lat" type="hidden" value="'+ lat +'" /></form>';
        var f=document.getElementById('getC');
        if(f){
        f.submit();
            //alert('submitted!');
        }
    }
	
	

</script>




  
