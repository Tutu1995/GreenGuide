<!DOCTYPE html>
<html>
<head>
	<link href="WriteReview.css" type="text/css" rel="stylesheet" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <!--
	<style type="text/css">
		body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
		#allmap{width:100%;height:500px;}
		p{margin-left:5px; font-size:14px;}
	</style>
    -->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
	<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
	<title>给多个点添加信息窗口</title>
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
                                <li><a href="map.php">Explore Reviews on a Map</a></li>
                           </ul> 
                       </nav>
                   </header>       
                  <div id="allmap"></div>
                  <p>点击标注点，可查看由纯文本构成的简单型信息窗口</p>
                  <div id="list"></div>
                  <a id="myAnchor">A Link: Go to w3schools.com</a>
                  <img id="img">
                  <img id="img2" width="160" height="140">
                  <img src="data:image/gif;base64,R0lGODlhEAAOALMAAOazToeHh0tLS/7LZv/0jvb29t/f3//Ub/
/ge8WSLf/rhf/3kdbW1mxsbP//mf///yH5BAAAAAAALAAAAAAQAA4AAARe8L1Ekyky67QZ1hLnjM5UUde0ECwLJoExKcpp
V0aCcGCmTIHEIUEqjgaORCMxIC6e0CcguWw6aFjsVMkkIr7g77ZKPJjPZqIyd7sJAgVGoEGv2xsBxqNgYPj/gAwXEQA7" 
width="16" height="14" alt="embedded folder icon">
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
				  ?>
					  <li> Company: <?= $row["company"] ?>,
					  Address: <?= $row["address"] ?> </li> 
				  <?php
						$a[]=$row;
				  } 
				}
			  catch(Exception $e){
				  die(print_r($e));
			  }
/*
		  $server = "tcp:rhrcl8b8ia.database.windows.net,1433";
          $user = "yiruli@rhrcl8b8ia";
          $pwd = "Uw1364228";
          $db = "GreenGuide";
          
          try{
              $conn = new PDO( "sqlsrv:Server= $server ; Database = $db ", $user, $pwd);
              $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  
              //if(isset($_POST["company"]) && isset($_POST["address"]) && isset($_POST["review"])) {
				  
				  //$insert_img="INSERT INTO image (Pic_name, Pic) VALUES ('$pic_name','$image')";
                                        
                  $insert="SELECT * FROM test_review";
				  //$dispaly="select * from image";
               
			   //$result_img=$conn->query($insert_img);
               $rows=$conn->query($insert);
			   //$result_show_img= $conn -> query($dispaly);		
              //} 
			  $a=array();
			  foreach ($rows as $row) {
			  ?>
                  <li> Company: <?= $row["Company"] ?>,
                  Address: <?= $row["Address"] ?> </li> 
			  <?php
					$a[]=$row;
			  } 
			  
			 // print_r($a);
			  print_r($a[0][Company]);
			  
		  }
          catch(Exception $e){
              die(print_r($e));
          }
*/		  		  
?>



<script type="text/javascript">
	// 百度地图API功能	
	var data = <?php echo json_encode($a) ?>;
	//alert(data[0].company);
	map = new BMap.Map("allmap");
	map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	
	
	
	
	var opts = {
				width : 350,     // 信息窗口宽度
				height: 142,     // 信息窗口高度
				//title : data[i].company , // 信息窗口标题
				enableMessage:true//设置允许信息窗发送短息
			   };
			   
	var m_color;		   	
	for(var i=0;i<data.length;i++){
		//var myIcon = new BMap.Icon("Pink-icon.png", new BMap.Size(300,157));
		//var marker = new BMap.Marker(new BMap.Point(data[i].lng,data[i].lat),{icon:myIcon});  // 创建标注
		//alert(data[i].avg_r);
		
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
		alert(m_color);
		
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
	"<img style='float:right;margin:4px' id='imgDemo' src='http://app.baidu.com/map/images/tiananmen.jpg' width='139' height='104' title='"+data[i].company+"'/>" + 
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
		alert(content);
	}
	
	function pointInfo(e){
		var pi = e.target;
		var params = new FormData();
			params.append("lng", pi.getPosition().lng);
			params.append("lat", pi.getPosition().lat);
			alert(pi.getPosition().lng);
			alert(pi.getPosition().lat);
			
			var ajax = new XMLHttpRequest();
			ajax.onload = pInfoGet;
			ajax.open("POST", "ajax.php", true);
			ajax.send(params);
	}
	
	function pInfoGet() {
		alert("3");
		if (this.status == 200) {
			alert("4");
			alert(this.responseText);
			var json = JSON.parse(this.responseText);
			var list=document.getElementById("list");
			
			for (var i = 0; i < json.all.length; i++) {
				alert(json.all[i].review.company);
				if(json.all[i].all_image[0].image){
					document.getElementById("img2").setAttribute("src", "data:image/jpg;base64,"+json.all[i].all_image[0].image);
				}
				
				var info = document.createElement("div");
				var p = document.createElement("p");
				var r_info= "Company Name: " + json.all[i].review.company +"<br/>" + "Company Address: "+ json.all[i].review.address +"<br/>" + "City: "+json.all[i].review.city+"<br/>" + "Rating: "+json.all[i].review.rating+"<br/>"+ "Reviews: "+json.all[i].review.review +"<br/>"+ "Pollution Type: "+json.all[i].review.water +json.all[i].review.air+json.all[i].review.waste+json.all[i].review.land+json.all[i].review.living+json.all[i].review.other+"<br/>"+"Related News, Videos, or links: "+json.all[i].review.news+"<br/>"+"Time: "+json.all[i].review.time+"<br/>";
				//r_info="Yes!Yes!Yes!";
				p.innerHTML = r_info;
				p.style.width="43%";
				p.style.border="1px solid silver"; 
				p.style.cssFloat = "left";
				info.appendChild(p); 
								
				
				var image_div = document.createElement("div");
				if(json.all[i].all_image[0].image){
					for (var j = 0; j < json.all[j].all_image.length; j++) {						
						var img = document.createElement("img");
						img.setAttribute("src", "data:image/jpg;base64,"+json.all[i].all_image[j].image);
						img.style.width="160px"; 
						img.style.height="140px";
						image_div.appendChild(img);
					}
				}
				image_div.style.width="55%";
				image_div.style.border="1px solid silver"; 
				image_div.style.cssFloat = "right";
				info.appendChild(image_div);
				
				info.style.border="1px solid silver"; 
				
				list.appendChild(info);
			}
				
		  
		} else {
			alert("HTTP error " + this.status + ": " + this.statusText + "\n" + this.responseText);
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
