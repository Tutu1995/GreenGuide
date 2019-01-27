<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Explore</title>
		
		<link href="WriteReview.css" type="text/css" rel="stylesheet" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AVpUxExAZfNTcMV8Wn1uccLu"></script>
        
        <style type="text/css">
            body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
            #allmap{width:100%;height:500px;}
            p{margin-left:5px; font-size:14px;}
        </style>
        <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
        
		
	</head>

	<body>
    <div id="wrapper">
    	<header>	
            <p id="head">
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
                      <li>About Me</li>
                      <li>Write a Review</li>
                      <li>Explore Reviews on a Map</li>
                 </ul> 
			 </nav>
         </header>       
		

		<div id="main">
			
        <div id="allmap"></div>
        
        </div>
	</body>
</html>
<script type="text/javascript">
	// 百度地图API功能	
	map = new BMap.Map("allmap");
	map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	var data_info = [[116.417854,39.921988,"地址：北京市东城区王府井大街88号乐天银泰百货八层"],
					 [116.406605,39.921585,"地址：北京市东城区东华门大街"],
					 [116.412222,39.912345,"地址：北京市东城区正义路甲5号"]
					];
	var opts = {
				width : 250,     // 信息窗口宽度
				height: 80,     // 信息窗口高度
				title : "信息窗口" , // 信息窗口标题
				enableMessage:true//设置允许信息窗发送短息
			   };
	for(var i=0;i<data_info.length;i++){
		var marker = new BMap.Marker(new BMap.Point(data_info[i][0],data_info[i][1]));  // 创建标注
		var content = data_info[i][2];
		map.addOverlay(marker);               // 将标注添加到地图中
		addClickHandler(content,marker);
	}
	function addClickHandler(content,marker){
		marker.addEventListener("click",function(e){
			openInfo(content,e)}
		);
	}
	function openInfo(content,e){
		var p = e.target;
		var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
		var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
		map.openInfoWindow(infoWindow,point); //开启信息窗口
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
</script>
