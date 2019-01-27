<?php

include("db.php");
ensure_logged_in();

$token = md5(uniqid(rand(),TRUE));
$_SESSION["token"] = $token; 

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Write a Review</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
       
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        <script src="rate.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="green-pin.png">
		
	</head>

	<body>
      <div class="wrapper">
      		<?php
					include("header.php");

					if(isset($_SESSION["flash"])){
									?>
					                <div id="flash"><?=$_SESSION["flash"]?></div>
					                <?php
									unset($_SESSION["flash"]);
					}
					
			?>
      			<!--
            <header id="header">	
                		<div class="head">
                            Green Guide
                        </div>
                  
                        <div id="search">
                                <div id="in_s">
                                      <form action="search-all.php" >
                                            <input id="suggestId" name="s_company" type="text" size="62" placeholder="Company Name or (Location + Company Name)" autofocus /> 
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

            <!--<p style="color:blue;">Every review is anonymous. We will work on everything to protect your privacy and personal data.</p>-->
            <div class="main">
            	  <p style="color:blue; background-color: #F8F8F8; text-align:center; width:100%; margin-top: 0px; ">Every review is anonymous. We work on everything to protect your privacy and personal data.</p>
                  <div id="r-result"><strong>Please search the company in the dropdown menu and click the company (we stronly suggest): </strong><input type="text" id="suggestId_2" size="64" placeholder="Company Name or (Location + Company Name)"  /><br><strong><span style="color: blue;">After click the company in the menu, the company's information will show automatically on the map and in the form. </span><br>If you can't find the company in the dropdown menu, please type the company's information in the following form. *Please refresh the page and leave the map empty if you type your own address. Since the system will use the address which is shown in the map.</strong></div><br/>
                  <div id="searchResultPanel_2" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                  <div id="l-map"></div>
                              
                  <p>*Required input <br/>If the company's name can not be found in the dropdown menu, please type in the company's name, address and city in the following form. 
                  </p>
              
              <form onsubmit="form_submit()" action="savereview.php" method="post" enctype="multipart/form-data">
                  <div>
                       <label class="heading" for="name">*Company Name:    </label><input id= "company" type="text" name="company" size="100" required/><br/>
                       <label class="heading" for="address">*Company Address: </label><input id= "address" type="text" name="address" size="100" required/><br/>
                       <label class="heading" for="city">*Company City:    </label><input id= "city" type="text" name="city" size="100" required/><br/><br/>
                       <input id="lng" type="hidden" name="lng">
                       <input id="lat" type="hidden" name="lat">   

                       *Company Industry Category: <input id= "industry" type="text" name="industry" size="150" placeholder="ex. Oil & Gas or Electronics Manufacturing" required/><br/><br/>
                       *What are this company's products? <input id= "product" type="text" name="product" size="150" placeholder="ex. Glass" required/><br/><br/>                                          
                       
                      <div id="rate">*Your Rating: </div>
                      <div id="sarea"></div>
                      <div id="hint"></div>
                      <input id="rating" type="hidden" name="rating"><br/>                      
                       
                       *Company Environmental Performance Review: <br/>
                       <textarea name="review" rows="10" cols="110" placeholder="Type your reviews here." required></textarea><br/><br/> 
                       
                       <fieldset id="p_type" >
                            <legend>What's your review focus on?</legend>
                            <label><input type="checkbox" name="water" />Water </label>
                            <label><input type="checkbox" name="air" />Air </label>
                            <label><input type="checkbox" name="waste" />Waste </label>
                            <label><input type="checkbox" name="land" />Land</label>                   
                            <label><input type="checkbox" name="living" />Ecosystem </label>
                            <label><input type="checkbox" name="other" />Others </label>
                            <input type="text" name="other_item" size="20" /><br/>
                       </fieldset><br/>
                       
                       Related News, Video or Links: <br/>
                       <textarea name="news" rows="3" cols="110" placeholder="Type related news, video or links here."></textarea><br/><br/>

                       EPA Data: <br/>
                       <textarea name="epa" rows="3" cols="110" placeholder="Type EPA data here."></textarea><br/><br/>

                       Measurement data: (ex. PM2.5) <br/>
                       <textarea name="measure" rows="3" cols="110" placeholder="Type measurement data here."></textarea><br/><br/>
                       
                       Please Upload Pictures: (Maximum upload file size: 8MB)<br/>
                       <input id="myFile"	type="file" name="image[]" size="80" accept="image/*" multiple onchange="myFunction()" /><br/>
                       <p id="demo" style="color: blue;"></p><br/>

                       Please click this validation button before clicking "Submit".                                      
                       <input type="button" onclick="check_add();" value="Validate Address & Rating" /><br><br>

                       <input type="hidden" name="token" value="<?= $token ?>" />
                   		

                       <input id="submit" type="submit" value="Submit!" /> 

                       <br><br><br>
                       <fieldset id="r_process">
                            <legend id="r_l">Review Process</legend>
			                        <p style="color:blue;">
			                       	  Every review will be checked on Text and Image quality by the system. While waiting for the system check, the review is marked as <span style="color:aqua; font-weight: bold;">“In Process”</span> in “User Profile”.<br><br>
									  If there is no problem on Text and image quality, the review will be made public on “Explore Reviews on a Map” and “Supplier Map” in 24 hours. Users will see a <span style="color:green; font-weight: bold;">“Public”</span> mark on their review in “User profile” after the review is made public. <br><br>
									  If Text and Image quality has issues after the system check, the review will be marked as <span style="color:orange; font-weight: bold;">“Postponed”</span> in "user profile". User may edit the review and resend it again for system checking. Or contact system admin(yiruli09@gmail.com) to deal with the issues. <br><br>
									  Green Guide also reserves the right to delete the reviews with inappropriate contents with or without notices. <br>
									</p>
					   </fieldset><br/>
                  </div>
              </form><br/>   
          </div>

          <div id="loading" style="display: none">
				<img src="loading.gif" />
				Loading ...
		  </div>
          

          			<div class="headfoot">
				                <p>
				                    <q>Share your feelings about the environment to the world!</q> - Green Guide<br />
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
<script type="text/javascript">
	"use strict";
	document.getElementById("submit").disabled = true;
	document.getElementById("rating").value="";
	document.getElementById("review").className="r_visited";

/*
	function myFunction(){
    var x = document.getElementById("myFile");
    var txt = "";
    if ('files' in x) {
        if (x.files.length == 0) {
            txt = "Select one or more files.";
        } else {
            for (var i = 0; i < x.files.length; i++) {
                txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                var file = x.files[i];
                if ('name' in file) {
                    txt += "name: " + file.name + "<br>";
                }
                if ('size' in file) {
                    txt += "size: " + file.size + " bytes <br>";
                }
            }
        }
    } 
    else {
        if (x.value == "") {
            txt += "Select one or more files.";
        } else {
            txt += "The files property is not supported by your browser!";
            txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
        }
    }
    document.getElementById("demo").innerHTML = txt;
}
*/


	function myFunction(){
	    var x = document.getElementById("myFile");
	    var txt = "";
	    var file_size=0;
	    if ('files' in x) {
	        if (x.files.length == 0) {
	            txt = "Select one or more files.";
	        } else {
	            for (var i = 0; i < x.files.length; i++) {
	                //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
	                var file = x.files[i];
	                
	                if ('size' in file) {
	                    file_size +=  file.size;
	                }
	            }
	            var n = parseFloat(file_size/1024/1024).toFixed(4);
	            txt += "Total image size: " + n + " MB <br>";
	            if (file_size>8388608){
	            	txt += "The total image size is too big! Please choose the file again. ";
	            } else{
	            	txt += "The total image size is OK.";
	            }
	        }
	    } 
	    else {
	        if (x.value == "") {
	            txt += "Select one or more files.";
	        } else {
	            txt += "The files property is not supported by your browser!";
	            txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
	        }
	    }
	    
	    document.getElementById("demo").innerHTML = txt;
	}


	// 百度地图API功能
	function G(id) {
		return document.getElementById(id);
	}

	var map = new BMap.Map("l-map");
	map.centerAndZoom("西安",5);                   // 初始化地图,设置城市和地图级别。

	var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
		{"input" : "suggestId_2"
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
		G("searchResultPanel_2").innerHTML = str;
	});

	var myValue;
	ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
	var _value = e.item.value;
		myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		G("searchResultPanel_2").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
		toggleLoadingMessage();
		setPlace();
	});
	
	function setPlace(){
		map.clearOverlays();    //清除地图上所有覆盖物
		function myFun(){
			var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
			map.centerAndZoom(pp, 18);
			map.addOverlay(new BMap.Marker(pp));    //添加标注
			//alert("marker的位置是");
			//alert("marker的位置是" + pp.lng + "," + pp.lat);
			//alert("marker的位置是" + local.getResults().getPoi(0).title );
			//alert("marker的位置是" + local.getResults().getPoi(0).business);
			//alert("marker的city是" + local.getResults().getPoi(0).city);
			document.getElementById("company").value = local.getResults().getPoi(0).title;
			document.getElementById("address").value = local.getResults().getPoi(0).address;
			document.getElementById("city").value = local.getResults().getPoi(0).city;
			document.getElementById("lng").value = pp.lng;
			document.getElementById("lat").value = pp.lat;

			toggleLoadingMessage();
		}
		var local = new BMap.LocalSearch(map, { //智能搜索
		  onSearchComplete: myFun
		});
		local.search(myValue);
	}

	
	function check_add(){
		//alert("1");
		var add=document.getElementById("address").value;
		var city=document.getElementById("city").value;
		var lng=document.getElementById("lng").value;
		var lat=document.getElementById("lat").value;
		var rating=document.getElementById("rating").value;

		var x = document.getElementById("myFile");

		var check_img_size=0;

		for (var i = 0; i < x.files.length; i++) {
	                //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
	                var file = x.files[i];
	                
	                if ('size' in file) {
	                    check_img_size +=  file.size;
	                }
	    }



		//alert(add);
		//alert(city);
		if((add)&&(city)){
			if((!lng)&&(!lat)){
				//alert("2");
				var myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				myGeo.getPoint(document.getElementById("address").value, function(point){
					if (point) {
						document.getElementById("lng").value = point.lng;
						document.getElementById("lat").value = point.lat;
						//alert("地址:"+ point.lng+ " " + point.lat );
						if(rating){
							if (check_img_size<8388608){
									document.getElementById("submit").disabled = false;
									document.getElementById("submit").style.color="green";
									document.getElementById("submit").style.fontWeight="bold";
									alert("Ready to Click Submit! 請點擊Submit提交點評!");
							} else{
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "The total image size is too big! Please choose the file again. ";
									alert("The total image size is too big! Please choose the file again.");
							}
						}
						else{
							alert("Please Choose a Rate. 請選擇評分!");
						}
					}else{
						alert("Can't Interpret the Address. Please Type in a New Address. 您选择地址没有解析到结果, 請重新輸入地址和城市!");
					}
				}, document.getElementById("city").value);
			}
			else{

				var myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				myGeo.getPoint(document.getElementById("address").value, function(point){
					if (point) {
						alert("Correct Address. 地址正確!");
						//document.getElementById("lng").value = point.lng;
						//document.getElementById("lat").value = point.lat;
						//alert("地址:"+ point.lng+ " " + point.lat );
						if(rating){
							if (check_img_size<8388608){
									document.getElementById("submit").disabled = false;
									document.getElementById("submit").style.color="green";
									document.getElementById("submit").style.fontWeight="bold";
									alert("Ready to Click Submit! 請點擊Submit提交點評!");
							} else{
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "The total image size is too big! Please choose the file again. ";
									alert("The total image size is too big! Please choose the file again.");
							}
						}
						else{
							alert("Please Choose a Rate. 請選擇評分!");
						}
					}else{
						alert("Can't Interpret the Address. Please Type in a New Address. 您选择地址没有解析到结果, 請重新輸入地址和城市!");
					}
				}, document.getElementById("city").value);

			}
		}
		else{
			alert("Address or City is empty. Please make sure to fill the Address and City. 地址或城市為空白, 請確認是否填入地址和城市!");
		}
	}
	


	function form_submit(){
		document.getElementById("submit").value="Processing...";
		document.getElementById("submit").disabled = true;
		document.getElementById("submit").style.color="blue";
	}



	
	
	
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
	
	var ac_2 = new BMap.Autocomplete(    //建立一个自动完成的对象
		{"input" : "suggestId"
		,"location" : map
	});

	ac_2.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
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

	var myValue_2;
	ac_2.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
	var _value = e.item.value;
		myValue_2 = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue_2;
		
		setPlace_2();
	});
	
	
	function setPlace_2(){
		//map.clearOverlays();    //清除地图上所有覆盖物
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
		local.search(myValue_2);
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


    function toggleLoadingMessage() {
		var load = document.getElementById("loading");
		if (load.style.display) {
			load.style.display = "";
		} else {
				load.style.display = "none";
		}
	}	
	
  
  
</script>

