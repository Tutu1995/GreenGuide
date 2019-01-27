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
                  <header>	
                      	<p class="head">
                            Green Guide
                        </p>
                  
                        <div id="search">
                                <div id="in_s">
                                      <form action="search-all.php" >
                                            <input id="suggestId" name="s_company" type="text" size="72" placeholder="Company Name or related keyword ex. location" autofocus /> 
                                            <input name="s_location" type="text" size="24" placeholder="Near Location" />  
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

                  <div id="mycity"> 
		                  Please enter the city or location you would like to check out: <input type="text" id="field" placeholder="City or Location" size="24">
		                  <button onclick="mycity()">Submit</button>
		          </div><br/>     
                  <div id="allmap"></div>
                  <h2>Click a mark on the above map and check out its reviews:</h2>
                  
                  <div id="loading" style="display: none">
						<img src="loading.gif" />
						Loading ...
				  </div>
				  <div id="list"></div>
                  
      </div>
</body>
</html>

<?php
			try{

				  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				  
				  //$result=$con->query("insert into review (company, address, city, review, lng, lat, rating, water, air, waste, land, living, other, news) values('$company', '$address', '$city', '$review', '$lng', '$lat', '$rating', '$water', '$air', '$waste', '$land', '$living', '$other', '$news')");
				  $rows=$con->query("select lng, lat, company, address, city, AVG(rating) as avg_r from review GROUP BY lng,lat,company ");
				  $a=array();
				  foreach ($rows as $row) {
				 
						$a[]=$row;
				  } 
				}
			  catch(Exception $e){
				  die(print_r($e));
			  }
  
?>



<script type="text/javascript">
	// 百度地图API功能	
	var data = <?php echo json_encode($a) ?>;
	//alert(data[0].company);
	map = new BMap.Map("allmap");
	map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);

	function mycity() {
	    if(document.getElementById("field").value){
	    	map.centerAndZoom(document.getElementById("field").value,15);
		}else{
			map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
		}
	}
	 
	
	var opts = {
				width : 300,     // 信息窗口宽度
				height: 120,     // 信息窗口高度
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
		//alert(m_color);
		
		//var m_color="red";
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
		// 将地址解析结果显示在地图上,并调整地图视野
			   
	
	function addClickHandler(content,marker){
		marker.addEventListener("click",function(e){
			openInfo(content,e)
			
			pointInfo(e)
			
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
	
	function pointInfo(e){
		toggleLoadingMessage();
		var pi = e.target;
		//var params = new FormData();
			//params.append("lng", pi.getPosition().lng);
			//params.append("lat", pi.getPosition().lat);
			//alert(pi.getPosition().lng);
			//alert(pi.getPosition().lat);
			
			var ajax = new XMLHttpRequest();
			ajax.onload = pInfoGet;
			ajax.open("GET", "ajax.php?lng="+ pi.getPosition().lng +"&lat="+ pi.getPosition().lat, true);
			//ajax.send(params);
			ajax.send();
	}
	
	function pInfoGet() {
		//alert("3");
		toggleLoadingMessage();
		if (this.status == 200) {
			//alert("4");
			//alert(this.responseText);
			var json = JSON.parse(this.responseText);
			
			
			for (var i = 0; i < json.all.length; i++) {
				
				
				var info = document.createElement("div");
				info.className="info";
				var p = document.createElement("div");
				p.className = "info_p";	
				
				var pic=["_3.png","_2.png","_1.png","0.png","1.png","2.png","3.png"];
				var pic_rate= parseInt(json.all[i].review.rating)+3;
				alert("pic rate: "+pic[pic_rate]);
				alert("rate: "+pic_rate);
				var r_info= "Company Name: " + json.all[i].review.company +"<br/>" + "Company Address: "+ json.all[i].review.address +"<br/>" + "City: "+json.all[i].review.city+"<br/>" + "Rating: "+json.all[i].review.rating+"<br/>" + "<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+json.all[i].review.review +"<br/>"+ "Environment Type: "+json.all[i].review.water+" " +json.all[i].review.air+" "+json.all[i].review.waste+" "+json.all[i].review.land+" "+json.all[i].review.living+" "+json.all[i].review.other+"<br/>"+"Related News, Videos, or links: "+json.all[i].review.news+"<br/>"+"Time: "+json.all[i].review.time+"<br/>";
				//r_info="Yes!Yes!Yes!";
				//alert(r_info);
				p.innerHTML = r_info;			
															
				info.appendChild(p);

				




				var image_div = document.createElement("div");
				image_div.className="image_div";
				//if(json.all[i].all_image[0].image){
					for (var j = 0; j < json.all[i].all_image.length; j++) {											
						var img = document.createElement("img");						
						img.setAttribute("src", "data:image/jpg;base64,"+json.all[i].all_image[j].image);						
						img.className="img";						
						image_div.appendChild(img);												
					}
				//}				
				
				info.appendChild(image_div);	



				var ask=document.createElement("div");
				ask.innerHTML="Was this review …?";
				ask.className="ask";
				info.appendChild(ask);


				var btn = document.createElement("BUTTON");
				if(json.all[i].review.help){
    				btn.innerHTML="Helpful : "+ json.all[i].review.help;
    			}
    			else{
    				btn.innerHTML="Helpful";
    			}
    			
    			btn.className="btn_true";
    			//alert(json.all[i].review.id);
    			//alert(json.all[i].review.help);
    			btn.data = {				
				  id: json.all[i].review.id,	
				  vote: json.all[i].review.help		  
				}
    			btn.onclick=btnClick;
    			btn.setAttribute("id", "btn"+json.all[i].review.id );
    			info.appendChild(btn);


    			var report = document.createElement("BUTTON");
    			var r = document.createTextNode("Report as Inappropriate");
    			
    			report.appendChild(r);
    			report.className="btn_r";
    			report.data = {				
				  id: json.all[i].review.id		  
				}
    			report.onclick=rClick;
    			info.appendChild(report);


    			text = document.createElement("div");
    			text.setAttribute("id", json.all[i].review.id );
    			text.className="text";

    			info.appendChild(text);




				list.appendChild(info);				
			}
				
		  
		} else {
			alert("HTTP error " + this.status + ": " + this.statusText + "\n" + this.responseText);
		}
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
						show.innerHTML="You have voted this review. Thank you!";
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


	function toggleLoadingMessage() {
		var load = document.getElementById("loading");
		if (load.style.display) {
			load.style.display = "";
			//alert("set none as &&.");
		} else {
			//document.getElementById("list").innerHTML = "";
			var list=document.getElementById("list");
			while (list.hasChildNodes()) {   
				list.removeChild(list.firstChild);
			}
			load.style.display = "none";
			//alert("set && as none.");
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
        f=document.getElementById('getC');
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
