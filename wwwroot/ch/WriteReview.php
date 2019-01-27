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
		<title>写环境点评</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
       
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        <script src="rate.js" type="text/javascript"></script>
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

					if(isset($_SESSION["flash"])){
									?>
									<div class="container-fluid">
					                	<div id="flash"><?=$_SESSION["flash"]?></div>
					                </div>
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
            	  <div class="container text-center"><p class="text-primary">所有点评是匿名的。我们将保护您的个人信息！</p></div>
            	  
                  <div class="container-fluid">
                  		<form class="form-inline" role="form">
              					<div class="form-group">
              							    <label for="go_location">在下拉菜单中搜寻公司并点击公司名称: </label>
              							    <input type="text" class="form-control input-sm" id="suggestId_2" size="64" placeholder="公司名称 或 （地点+公司名称）">
              					</div>
      							<div id="searchResultPanel_2" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
						</form>

	                  	<p class="text-primary" style="margin-bottom:0px;">在下拉菜单中点击公司名称后，公司相关信息将自动代入</p>
	                  	<p>如果在下拉菜单中找不到公司名称, 请在下列表格中填入公司相关信息. *若您需要使用自行输入的公司讯息，请先刷新页面使地图空白，由于系统将使用在地图上所显示的地址</p>
                  </div>
                 
                  <div id="l-map"></div>
                              
                  
            

            <div class="container">  
              <p class="text-primary">* 必填 </p>
              <p>如果在下拉菜单中找不到公司名称，请在下列表格中填入公司名称、地址和所在城市 
              </p>
              <form class="form" role="form" onsubmit="form_submit()" action="savereview.php" method="post" enctype="multipart/form-data">
              	  <div class="form-horizontal">
	              	  <div class="form-group">
						    <label class="control-label col-sm-2" for="name">*公司名称:</label>
						    <div class="col-sm-10">
						      <input class="form-control" id= "company" type="text" name="company" required>
						    </div>
						    <label class="control-label col-sm-2" for="address">*地址:</label>
						    <div class="col-sm-10">
						      <input class="form-control" id= "address" type="text" name="address" required>
						    </div>
						    <label class="control-label col-sm-2" for="city">*城市:</label>
						    <div class="col-sm-10">
						      <input class="form-control" id= "city" type="text" name="city" required>
						    </div>
						    <input id="lng" type="hidden" name="lng">
	                        <input id="lat" type="hidden" name="lat">  

	                        
					  </div>
				  </div>

				  <div class="form-group">
					    <label for="category">*产业类别:</label>
					    <input class="form-control" id= "industry" type="text" name="industry" placeholder="例：石化或电子产业" required>
				  </div> 

				  <div class="form-group">
					    <label for="products">*产品名称</label>
					    <input class="form-control" id= "product" type="text" name="product" placeholder="例：玻璃" required>
				  </div> 	
				  
                  
                   
                      <div class="form-group">
						    <label for="rating">*评分:<span id="rate"></span></label>
						    <div id="sarea"></div>
	                        <div id="hint"></div>
	                        <input id="rating" type="hidden" name="rating">
				      </div>


				      <div class="form-group">
						  <label for="review">*环境点评:</label>
						  <textarea class="form-control" name="review" rows="10" placeholder="环境点评" required></textarea>
					  </div>

					  <div class="form-group">
					  	   <label for="p_type">环境关注点:		</label>
	                                     		
							    <label class="checkbox-inline">
							      <input type="checkbox" name="water">水
							    </label>
							    <label class="checkbox-inline">
							      <input type="checkbox" name="air">空气
							    </label>
							    <label class="checkbox-inline">
							      <input type="checkbox" name="waste">废弃物
							    </label>
							    <label class="checkbox-inline">
							      <input type="checkbox" name="land">土壤
							    </label>
							    <label class="checkbox-inline">
							      <input type="checkbox" name="living">生态系统
							    </label>
							    <label class="checkbox-inline">
							      <input type="checkbox" name="other">其他
							    </label>
							    <label class="checkbox-inline">
							      <input id="other_item" class="form-control" type="text" name="other_item" placeholder="其他" size="20" />
							    </label>	    
					   </div>

                       <div class="form-group">
							  <label for="Related">相关新闻、视频或链接:</label>
							  <textarea class="form-control" name="news" rows="3" placeholder="相关新闻、视频或链接" ></textarea>
					   </div>

					   <div class="form-group">
							  <label for="epa">环保局官方信息:</label>
							  <textarea class="form-control" name="epa" rows="3" placeholder="环保局官方信息" ></textarea>
					   </div>

					   <div class="form-group">
							  <label for="Measure">实验数据: (例. PM2.5)</label>
							  <textarea class="form-control" name="measure" rows="3" placeholder="实验数据" ></textarea>
					   </div>


					   <div class="form-group">
							  <label for="pic">选择图片: (最大总容量 : 1 MB. 可接受档案格式: .png .jpeg .jpg .bmp .gif)</label>
							  <input id="myFile"  type="file" name="image[]" size="80" accept="image/gif, image/jpeg, image/png, image/jpg, image/bmp" multiple onchange="myFunction()" />
							  <p id="demo" class="text-primary"></p>
					   </div>

					   <div class="form-group">
							  <label for="submit">请在点击“提交”前点击“检验数据”键</label>
							  <input type="button" onclick="check_add();" class="btn btn-primary"  value="检验数据" />
							  <p id="demo" class="text-primary"></p>
					   </div>

                

                       <input type="hidden" name="token" value="<?= $token ?>" />
                   		

                       <button id="submit" type="submit" class="btn btn-default">提交</button>

                       <br><br><br>

                       <h3 class="text-primary">点评审核流程</h3>
                       <div class="well text-primary">所有点评的内容和图片将经过系统审核。在系统审核期间，您的点评将显示为 <span style="color:aqua; font-weight: bold;">“审核中”</span>于"我的点评"<br><br>
									  一旦审核通过，您的点评将在24小时内生效并显示在 “地图浏览点评”. 点评将标注为 <span style="color:green; font-weight: bold;">“已公布”</span>. <br><br>
									  若审核未通过，您的点评将标注为 <span style="color:orange; font-weight: bold;">“延期”</span>, 用户可以修改并再次提交审核或联系系统管理员(yiruli@uw.edu) <br><br>
									  绿色指南将保留对失实或不当点评直接删除的权利，删除可以不通知用户
					   </div>
 
                  
              </form><br/> 
               
          </div>

          <div id="loading" style="display: none">
				<img src="loading.gif" />
				下载中 ...
		  </div>
          
          <br><br><br>
		  <?php		 
		  	include("footer.php");
		  	include("bottom_boo.php");
		  ?>			
          			           
       
	</body>
</html>
<script type="text/javascript">
	"use strict";
	document.getElementById("submit").disabled = true;
	document.getElementById("rating").value="";
	document.getElementById("review").className="active";

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
	    var _validFileExtensions = ["jpg", "jpeg", "bmp", "gif", "png"];  

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
	                var FileName  = x.files[i].name;
	                /*
	                var arr1 = new Array;
					arr1 = FileName.split("\\");
					var len = arr1.length;
					var img1 = arr1[len-1];
					var filext = img1.substring(img1.lastIndexOf(".")+1);
					*/
			        
			          
			        if (FileName.length > 0) {
			        	var FileExt = FileName.substring(FileName.lastIndexOf('.')+1);
			        	//alert(FileExt);

		                var blnValid = false;
		                for (var j = 0; j < _validFileExtensions.length; j++) {
		                    var sCurExtension = _validFileExtensions[j];
		                    //alert(FileExt.toLowerCase());
		                    //alert(sCurExtension.toLowerCase());
		                    if (FileExt.toLowerCase() == sCurExtension.toLowerCase()) {
		                        blnValid = true;
		                        break;
		                    }
		                }

		                if (!blnValid) {
		                    txt += "抱歉, " + FileName + " 无法上传，允许的档案格式为: " + _validFileExtensions.join(", ")+"<br>";
		                    document.getElementById("submit").disabled = true;
						    document.getElementById("submit").style.color="gray";
		                    //return false;
		                }
		            }
	            }

	            


	            var n = parseFloat(file_size/1024/1024).toFixed(4);
	            txt += "图片总量: " + n + " MB <br>";
	            if (file_size>1048576){
	            	txt += "图片总量太大！请重新选择文件 ";
	            	document.getElementById("submit").disabled = true;
					document.getElementById("submit").style.color="gray";
	            } else{
	            	txt += "图片总量在允许范围";
	            }
	        }
	    } 
	    else {
	        if (x.value == "") {
	            txt += "Select one or more files.";
	        } else {
	            txt += "该文件属性您的浏览器不支持!";
	            txt  += "<br>所选的文件的路径: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
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
		var check_img_type=0;
	    var _validFileExtensions = ["jpg", "jpeg", "bmp", "gif", "png"]; 

	    if (x.files.length == 0) {
	            check_img_type=1;
	    } else {
			for (var i = 0; i < x.files.length; i++) {
		                //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
		                var file = x.files[i];
		                
		                if ('size' in file) {
		                    check_img_size +=  file.size;
		                }

		                var FileName  = x.files[i].name;	                
				          
				        if (FileName.length > 0) {
				        	var FileExt = FileName.substring(FileName.lastIndexOf('.')+1);
				        	//alert(FileExt);

			                var blnValid = false;
			                for (var j = 0; j < _validFileExtensions.length; j++) {
			                    var sCurExtension = _validFileExtensions[j];
			                    //alert(FileExt.toLowerCase());
			                    //alert(sCurExtension.toLowerCase());
			                    if (FileExt.toLowerCase() == sCurExtension.toLowerCase()) {
			                        blnValid = true;
			                        check_img_type=1;
			                        break;
			                    }
			                }

			                if (!blnValid) {
			                    document.getElementById("submit").disabled = true;
							    document.getElementById("submit").style.color="gray";
							    check_img_type=0;
			                }
			            }
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
							if (check_img_size<1048576 && check_img_type==1){
									document.getElementById("submit").disabled = false;
									document.getElementById("submit").style.color="green";
									document.getElementById("submit").style.fontWeight="bold";
									alert("Ready to Click Submit! 請點擊Submit提交點評!");
							} else if (check_img_size>=1048576) {
									document.getElementById("submit").disabled = true;
									document.getElementById("submit").style.color="gray";
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "总图片大小太大！ 请再次选择文件 ";
									alert("总图片大小太大！ 请再次选择文件");
							} else if (check_img_type==0) {
									document.getElementById("submit").disabled = true;
									document.getElementById("submit").style.color="gray";
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "抱歉, 无法上传，允许的档案格式为: .jpg, .jpeg, .bmp, .gif, .png. ";
									alert("抱歉, 无法上传，允许的档案格式为: .jpg, .jpeg, .bmp, .gif, .png.");
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
			else if((lng)&&(lat)){

				var myGeo = new BMap.Geocoder();
				// 将地址解析结果显示在地图上,并调整地图视野
				//myGeo.getPoint(document.getElementById("address").value, function(point){
					//if (point) {
						alert("Correct Address. 地址正確!");
						//document.getElementById("lng").value = point.lng;
						//document.getElementById("lat").value = point.lat;
						//alert("地址:"+ point.lng+ " " + point.lat );
						if(rating){
							if (check_img_size<1048576 && check_img_type==1){
									document.getElementById("submit").disabled = false;
									document.getElementById("submit").style.color="green";
									document.getElementById("submit").style.fontWeight="bold";
									alert("Ready to Click Submit! 請點擊Submit提交點評!");
							} else if (check_img_size>=1048576){
									document.getElementById("submit").disabled = true;
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "总图片大小太大！ 请再次选择文件 ";
									alert("总图片大小太大！ 请再次选择文件");
							} else if (check_img_type==0) {
									document.getElementById("submit").disabled = true;
									document.getElementById("submit").style.color="gray";
									document.getElementById("demo").innerHTML = "";
									document.getElementById("demo").innerHTML = "抱歉, 无法上传，允许的档案格式为: .jpg, .jpeg, .bmp, .gif, .png. ";
									alert("抱歉, 无法上传，允许的档案格式为: .jpg, .jpeg, .bmp, .gif, .png.");
							}
						}
						else{
							alert("Please Choose a Rate. 請選擇評分!");
						}
					//}else{
						//alert("Can't Interpret the Address. Please Type in a New Address. 您选择地址没有解析到结果, 請重新輸入地址和城市!");
					//}
				//}, document.getElementById("city").value);
			} else {
					alert("Can't Interpret the Address. Please Type in a New Address. 您选择地址没有解析到结果, 請重新輸入地址和城市!");
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

