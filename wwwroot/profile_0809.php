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
                  <div id="getedit"></div>
                  <div id="imgedit"></div>

                  	
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

<?php
			try{

				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				  
				  
				  $s_name=$_SESSION["name"];
				  $rows=$con->query("select lng, lat, company, address, city, AVG(rating) as avg_r from review r join profile p on r.id= p.review_id where p.name='$s_name' GROUP BY lng,lat,company ");
				  $a=array();
				  foreach ($rows as $row) {
				  
						$a[]=$row;
				  } 
				  
				  $reviews=$con->query("select * from review r join profile p on r.id= p.review_id where p.name='$s_name' ");
				  $all=array();
				  foreach ($reviews as $review) {
						$p_image= array();
						$images=$con->query("select * from image where review_id=$review[0] ");
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}
						$all[]=array("review"=>$review,"all_image"=>$p_image);	
				  } 
				  
				}
			  catch(Exception $e){
				  //die(print_r($e));
			  		die("Sorry. Error occurred. Please try again.");
			  }

?>



<script type="text/javascript">
	"use strict";
	// 百度地图API功能	
	var data = <?php echo json_encode($a) ?>;
	var all = <?php echo json_encode($all) ?>;
	
	var map = new BMap.Map("allmap");


	if(data.length>0){
			map.centerAndZoom(new BMap.Point(data[0].lng,data[0].lat), 15);
			
	
			var opts = {
						width : 280,     // 信息窗口宽度
						height: 112,     // 信息窗口高度
						enableMessage:true//设置允许信息窗发送短息
					   };
					   
			var m_color;		   	
			for(var i=0;i<data.length;i++){
				
				var m_color;
				//设置marker图标为水滴
				if (data[i].avg_r<-2){
					m_color="red";
				}
				else if(data[i].avg_r>=-2 && data[i].avg_r<-1 ){
					m_color="orange";
				}else if(data[i].avg_r>=-1 && data[i].avg_r<0){
					m_color="yellow";
				}else if(data[i].avg_r==0){
					m_color="white";
				}else if(data[i].avg_r>0 && data[i].avg_r<=1){
					m_color="aqua";
				}else if(data[i].avg_r>1 && data[i].avg_r<=2){
					m_color="lime";
				}else{
					m_color="green";
				}
				
				var marker = new BMap.Marker(new BMap.Point(data[i].lng,data[i].lat), {
				  // 指定Marker的icon属性为Symbol
				  icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
					scale: 1.5,//图标缩放大小
					fillColor: m_color,//填充颜色
					fillOpacity: 0.8//填充透明度
				  })
				});
				
				
				
				
				var content = "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+data[i].company+"</h4>" + "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].address+"</p>"+ "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].city+"</p>"+"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+"Rating: "+data[i].avg_r+"</p>";
			
				map.addOverlay(marker);               // 将标注添加到地图中
				addClickHandler(content,marker);
			}			
				// 将地址解析结果显示在地图上,并调整地图视野
					   
			
			
			
			
			var list=document.getElementById("list");
					while (list.hasChildNodes()) {   
						list.removeChild(list.firstChild);
					}
					
					for (var i = 0; i < all.length; i++) {
						
						
						var info = document.createElement("div");
						info.className="info";
						info.setAttribute("id", "info"+all[i].review.review_id );
						var p = document.createElement("div");
						p.className = "info_p";	

						var pic=["_3.png","_2.png","_1.png","0.png","1.png","2.png","3.png"];
						var pic_rate= parseInt(all[i].review.rating)+3;
						var r_info= "Company Name: " + all[i].review.company +"<br/>" + "Company Address: "+ all[i].review.address +"<br/>" + "City: "+all[i].review.city+"<br/>" + "Rating: "+all[i].review.rating+"<br/>"+ "<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+all[i].review.review +"<br/>"+ "Environment Type: "+all[i].review.water+" "+all[i].review.air+" "+all[i].review.waste+" "+all[i].review.land+" "+all[i].review.living+" "+all[i].review.other+"<br/>"+"Related News, Videos, or links: "+all[i].review.news+"<br/>"+"Time: "+all[i].review.time+"<br/>";
						
						p.innerHTML = r_info;			
																	
						info.appendChild(p); 
						var image_div = document.createElement("div");
						
							image_div.className="image_div";
						
							for (var j = 0; j < all[i].all_image.length; j++) {											
								var img = document.createElement("img");						
								img.setAttribute("src", "data:image/jpg;base64,"+all[i].all_image[j].image);						
								img.className="img";						
								image_div.appendChild(img);												
							}
						
							info.appendChild(image_div);	
						


						var btn = document.createElement("BUTTON");				
		    			btn.innerHTML="Edit Text";    			
		    			btn.className="btn_edit";
		    			btn.data = {				
						  id: all[i].review.review_id				  	  
						}
						//alert("data_id:"+all[i].review.review_id);
		    			btn.onclick=btnClick_e;
		    			btn.setAttribute("id", "btn_e"+all[i].review.review_id );

		    			


		    			var btn_i = document.createElement("BUTTON");				
		    			btn_i.innerHTML="Edit Image";   			
		    			btn_i.className="btn_i";
		    			btn_i.data = {				
						  id: all[i].review.review_id				  	  
						}
		    			btn_i.onclick=btnClick_i;
		    			btn_i.setAttribute("id", "btn_i"+all[i].review.review_id );

		    			


		    			var btn_d = document.createElement("BUTTON");				
		    			btn_d.innerHTML="Delete Review";   			
		    			btn_d.className="btn_del";
		    			btn_d.data = {				
						  id: all[i].review.review_id				  	  
						}
		    			btn_d.onclick=btnClick_d;
		    			btn_d.setAttribute("id", "btn_d"+all[i].review.review_id );

		    			

		    			var btn_c = document.createElement("div");
		    			btn_c.className="btn_c";

		    			btn_c.appendChild(btn);
		    			btn_c.appendChild(btn_d);
		    			btn_c.appendChild(btn_i);

		    			info.appendChild(btn_c);


		    			//var text = document.createElement("div");
		    			//text.setAttribute("id", all[i].review.review_id );
		    			//text.className="text";

		    			//info.appendChild(text);

		    			
						list.appendChild(info);				
					}

	
	}else{
		map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	}	

			function addClickHandler(content,marker){
				marker.addEventListener("click",function(e){
					openInfo(content,e)
					
					//pointInfo(e)
					
					}			
				);
				
			}
			
			
			function openInfo(content,e){
				var p = e.target;
				var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
				var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
				map.openInfoWindow(infoWindow,point); //开启信息窗口
				//alert(content);
			}

					function btnClick_e(){
						//alert("edit text");
						var mydiv = document.getElementById('getedit').innerHTML = '<form id="gete"  action="edit.php" method="post"><input name="id" type="hidden" value="'+ this.data.id +'" /></form>';
				        var f=document.getElementById('gete');
				        if(f){
				        f.submit();
				            //alert('submitted!');
				        }
					}

					function btnClick_d(){
						//alert("delete");
						var x;
					    if (confirm("Are you sure to delet this review?") == true) {
					        x = 1;
					    } else {
					        x = 0;
					    }
					    if(x){

							var id=this.data.id;					
							
					        var params = new FormData();
							params.append("id", id);			
							
							var ajax = new XMLHttpRequest();
							ajax.onload = del;
							ajax.open("POST", "del.php", true);
							ajax.send(params);
					    }
					}
			
					function btnClick_i(){
						//alert("edit image");
						var mydiv = document.getElementById('imgedit').innerHTML = '<form id="geti"  action="img_e.php" method="post"><input name="id" type="hidden" value="'+ this.data.id +'" /></form>';
				        var f=document.getElementById('geti');
				        if(f){
				        f.submit();
				            //alert('submitted!');
				        }
						
					}

					function del() {
						
						if (this.status == 200) {
							//alert("4");
							//alert(this.responseText);
							var json = JSON.parse(this.responseText);
							
							//var show=document.getElementById(json.id);
							//show.innerHTML="This review is deleted!";	
							var info_d=document.getElementById("info"+json.id );        
		          			list.removeChild(info_d);
								
						}
						else{
							alert("error in ajax");
						}
					}		
	
	
	
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
		//map.clearOverlays();    //清除地图上所有覆盖物
		function myFun(){
			var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
			//map.centerAndZoom(pp, 18);
			//map.addOverlay(new BMap.Marker(pp));    //添加标注
			//alert("marker的位置是" + pp.lng + "," + pp.lat);
			//alert("marker的位置是" + local.getResults().getPoi(0).title );
			//alert("marker的位置是" + local.getResults().getPoi(0).address);
			//document.getElementById("company").value = local.getResults().getPoi(0).title;
			//document.getElementById("address").value = local.getResults().getPoi(0).address;
			//document.getElementById("lng").value = pp.lng;
			//document.getElementById("lat").value = pp.lat;
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
</script>



