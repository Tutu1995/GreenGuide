<?php  
  		  session_start();
		  $company=$_GET["company"];
          
		  $lng=$_GET["lng"];
		  $lat=$_GET["lat"];
		  
		  
		  try{
				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 
				  $rows=$con->query("select * from review where company='$company' and lng='$lng' and lat='$lat' ");
				  $all=array();
				  foreach ($rows as $row) {
						$p_image= array();
						$images=$con->query("select * from image where review_id=$row[0] ");
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}
						$all[]=array("review"=>$row,"all_image"=>$p_image);	
				  } 
				  
				  $p_map=$con->query("select company, address, city, lng, lat, AVG(rating) as avg_r from review where company='$company' and lng='$lng' and lat='$lat' GROUP BY lng,lat,company ");
				  $a=array();
				  foreach ($p_map as $p) {
						$a[]=$p;
						$r_company=$p[0];
						$r_address=$p[1];
						$r_city=$p[2];
				  } 
			  }
		  catch(Exception $e){
			  //die(print_r($e));
		  		die("Sorry. Error occurred. Please try again.");
		  }
				  
?>		  
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Company Reviews</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
 
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
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
		

            <div class="main">
                           
                  <h2>
                  Company Name: <?=$r_company?><br/> 
                  Company Address: <?=$r_address?>  City: <?=$r_city?><br/> 
                  </h2>
                 
                  <div id="allmap"></div>
                  <div id="list"></div>
                  
            </div>

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
							//title : data[i].company , // 信息窗口标题
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
					
					
					
					
					var content = "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+data[i].company+"</h4>" + 
				"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].address+"</p>"+ "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].city+"</p>"+"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+"Rating: "+data[i].avg_r+"</p>";
				
					map.addOverlay(marker);               // 将标注添加到地图中
					addClickHandler(content,marker);
				}


	
			var list=document.getElementById("list");
			while (list.hasChildNodes()) {   
				list.removeChild(list.firstChild);
			}
			
			for (var i = 0; i < all.length; i++) {
				
				
				var info = document.createElement("div");
				info.className="info";
				var p = document.createElement("div");
				p.className = "info_p";	

				var pic=["_3.png","_2.png","_1.png","0.png","1.png","2.png","3.png"];
				var pic_rate= parseInt(all[i].review.rating)+3;
				var r_info= "Company Name: " + all[i].review.company +"<br/>" + "Company Address: "+ all[i].review.address +"<br/>" + "City: "+all[i].review.city+"<br/>" + "Rating: "+all[i].review.rating+"<br/>"+"<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+all[i].review.review +"<br/>"+ "Pollution Type: "+all[i].review.water +all[i].review.air+all[i].review.waste+all[i].review.land+all[i].review.living+all[i].review.other+"<br/>"+"Related News, Videos, or links: "+all[i].review.news+"<br/>"+"Time: "+all[i].review.time+"<br/>";
				
				p.innerHTML = r_info;			
															
				info.appendChild(p); 
				var image_div = document.createElement("div");
				image_div.className="image_div";
				//if(json.all[i].all_image[0].image){
					for (var j = 0; j < all[i].all_image.length; j++) {											
						var img = document.createElement("img");						
						img.setAttribute("src", "data:image/jpg;base64,"+all[i].all_image[j].image);						
						img.className="img";						
						image_div.appendChild(img);												
					}
				//}				
				
				info.appendChild(image_div);	

				var ask=document.createElement("div");
				ask.innerHTML="Was this review …?";
				ask.className="ask";
				//info.appendChild(ask);

				var btn = document.createElement("BUTTON");
				if(all[i].review.help){
    				//var t = document.createTextNode("Helpful : "+ all[i].review.help);
    				btn.innerHTML="Helpful : "+ all[i].review.help;
    			}
    			else{
    				//var t = document.createTextNode("Helpful");
    				btn.innerHTML="Helpful";
    			}
    			//btn.appendChild(t);
    			btn.className="btn_true";
    			btn.data = {				
				  id: all[i].review.id,	
				  vote: all[i].review.help		  
				}
    			btn.onclick=btnClick;
    			btn.setAttribute("id", "btn"+all[i].review.id );

    			//info.appendChild(btn);

    			var report = document.createElement("BUTTON");
    			var r = document.createTextNode("Report as Inappropriate");
    			
    			report.appendChild(r);
    			report.className="btn_r";
    			report.data = {				
				  id: all[i].review.id		  
				}
    			report.onclick=rClick;

    			//info.appendChild(report);


    			var btn_c = document.createElement("div");
    			btn_c.className="btn_mc";

    			btn_c.appendChild(ask);
    			btn_c.appendChild(btn);
    			btn_c.appendChild(report);

    			info.appendChild(btn_c);


    			var text = document.createElement("div");
    			text.setAttribute("id", all[i].review.id );
    			text.className="text";

    			info.appendChild(text);

				list.appendChild(info);				
			}


			
	}
	else{
		map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	}	


	// 将地址解析结果显示在地图上,并调整地图视野
			function addClickHandler(content,marker){
				marker.addEventListener("click",function(e){
					openInfo(content,e)
					
					//pointInfo(e)
					
					}			
				);
				//alert(content);
			}
			
			
			function openInfo(content,e){
				var p = e.target;
				var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
				var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
				map.openInfoWindow(infoWindow,point); //开启信息窗口
				//alert(content);
			}

			function btnClick(){
				//alert(this.data.id);
				var id=this.data.id;
				var vote_c=this.data.vote;
				//alert(vote_c);
				
		        var params = new FormData();
				params.append("id", id);		
				params.append("vote_c", vote_c);		
				
				var ajax = new XMLHttpRequest();
				ajax.onload = vote;
				ajax.open("POST", "vote.php", true);
				ajax.send(params);
			}

			function vote() {
				//alert("3");
				if (this.status == 200) {
					//alert("4");
					//alert(this.responseText);
					var json = JSON.parse(this.responseText);

					//alert("json.vote_c"+json.vote_c);
					if(json.set){
						var show=document.getElementById(json.id);
						show.innerHTML="Thank you for the voting!";	
						var v_btn=document.getElementById("btn"+json.id);	
						v_btn.data.vote=json.vote_c;				
					}
					else{
						var show=document.getElementById(json.id);
						show.innerHTML="You have voted before. Thank you!";
					}
					var btn_c=document.getElementById("btn"+json.id);
					btn_c.innerHTML="Helpful : "+json.vote_c;
				}
				else{
					alert("error in ajax");
				}
			}


			function rClick(){
				//alert(this.data.id);
				var id=this.data.id;
				
		        var params = new FormData();
				params.append("id", id);				
				
				var ajax = new XMLHttpRequest();
				ajax.onload = getr;
				ajax.open("POST", "report.php", true);
				ajax.send(params);

			}

			function getr() {
				//alert("3");
				if (this.status == 200) {
					//var json = JSON.parse(this.responseText);
					//alert(this.responseText);
					var show=document.getElementById(this.responseText);
					show.innerHTML="This review has been reported to admin.";
				}
				else{

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
