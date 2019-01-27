
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

	<!--<script src="scroll.js" type="text/javascript"></script>-->
	<title>爱绿评搜索</title>
	<link rel="shortcut icon" href="green-pin.png">

	<style>
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
      top: 20px;
  }
  </style>

</head>
<body style="height: auto; overflow:hidden;">
      
      			<?php
					include("header_b.php");
				?>      			
        <div class="container-fluid">           
                   <!--<h2 id="hover">Hover a company brief and check out its location on the map. Click a company brief and check out all its reviews. </h2> -->
                   <p>点击公司简介并查看其所有点评。 将鼠标移至公司简介上，地图将秀出公司位置</p> 
                   <!--
                   <div id="keyword"></div>
                   <div class="inline">
	                   <div id="fixed">
	                   		<div id="s_allmap"></div>
	                   </div>
	                   <div id="s_list"></div> 
	               </div>
					-->
				   <div id="keyword"></div>
                   <div class="row">   
	                   <div class="col-sm-5">
	                   		<div id="s_list"></div> 
	                   </div>
	                   <div class="col-sm-7">
	                   		<div data-spy="affix" data-offset-top="203">
	                   			<div id="s_allmap"></div>
	                   		</div>
	                   </div>
	               </div>
                   
                   <div class="spacer">
					    &nbsp;
				   </div>
		</div>

                   <?php
					  	include("footer.php");
				   ?>
</body>
</html>
<?php  
		include("db.php");
		$s_location=htmlspecialchars($_GET["s_location"]);
		$s_company=htmlspecialchars($_GET["s_company"]);
        $s_status=1;
          try{
					//$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
					//$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  
					if ($s_location && !($s_company)) {
						
						$rows=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (address LIKE ? or city LIKE ?) GROUP BY lng,lat,company");					    
						$rows->execute(array($s_status, '%'.$s_location.'%', '%'.$s_location.'%'));
						
						$a=array();
						foreach ($rows as $row) {				  
							$a[]=$row;
						} 					    
					}
					
					if(!($s_location) && $s_company) {
						
						$coms=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (company LIKE ? or industry LIKE ? or product LIKE ?) GROUP BY lng,lat,company");					    
						$coms->execute(array($s_status, '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%'));

						$a=array();
						foreach ($coms as $com) {				  
							$a[]=$com;
						} 		
					}

					if($s_location && $s_company) {

						$comls=$db->prepare("select lng, lat, company, address, city, industry, product, AVG(rating) as avg_r, COUNT(id) as num_r from review where status=? and (company LIKE ? or industry LIKE ? or product LIKE ?) and (address LIKE ? or city LIKE ?) GROUP BY lng,lat,company");					    
						$comls->execute(array($s_status, '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_company.'%', '%'.$s_location.'%', '%'.$s_location.'%'));

						$a=array();
						foreach ($comls as $coml) {				  
							$a[]=$coml;
						} 		
					}
					
			  }
			  catch(Exception $e){
				  die(print_r($e));
			      //die("Sorry. Error occurred. Please try again.");
			  }
                   
  ?>
  
  <script type="text/javascript">
    "use strict";
	// 百度地图API功能	
	var data = <?php echo json_encode($a) ?>;

	var s_company = <?php echo json_encode($s_company) ?>;
	var s_location = <?php echo json_encode($s_location) ?>;

	document.getElementById("keyword").innerHTML= "搜索字 : "+s_company+" "+s_location;
	//document.getElementById("fixed").className = "fixed_1";

	//alert(data[0].company);
	var map = new BMap.Map("s_allmap");
	//map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	map.centerAndZoom(new BMap.Point(114, 34), 5);


	var opts = {
				width : 260,     // 信息窗口宽度
				height: 130,     // 信息窗口高度
				//title : data[i].company , // 信息窗口标题
				enableMessage:true,//设置允许信息窗发送短息
				offset: new BMap.Size(10,-25)
			   };
			   
	var m_color;

	if(data !==null){		   	
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
				
				
				var marker = new BMap.Marker(new BMap.Point(data[i].lng,data[i].lat), {
				  // 指定Marker的icon属性为Symbol
				  icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
					scale: 1.5,//图标缩放大小
					fillColor: m_color,//填充颜色
					fillOpacity: 0.8//填充透明度
				  })
				});
				
				var num = data[i].avg_r;
				var n = parseFloat(num).toFixed(2);
						
				var content = "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+data[i].company+"</h4>" + 
			"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].address+"</p>"+ "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].city+"</p>"+"<p style='margin:0;line-height:1.5;font-weight:bold;font-size:13px;text-indent:2em'>"+"Rating: "+n+"</p>" + "<p style='margin:0;line-height:1.5;color: orange;font-size:13px;text-indent:2em; '>"+data[i].num_r+" Reviews"+"</p>";
			
				map.addOverlay(marker);               // 将标注添加到地图中
				addClickHandler(content,marker);
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
			
			for(var i=0;i<data.length;i++){
						var list=document.getElementById("s_list");
										
						var info = document.createElement("div");
						info.className="s_info";
						info.data = {
						
						  company: data[i].company,
						  lng: data[i].lng,
						  lat: data[i].lat
						}
						info.onmouseover=infoOver;
						info.onclick=infoClick;
						
						var p = document.createElement("div");
						p.className = "s_info_p";	
						var r_info= data[i].company ;
						
						p.innerHTML = r_info;																		
						info.appendChild(p); 
						
						var a_div = document.createElement("div");
						a_div.className="s_image_div";

						var num = data[i].avg_r;
						var n = parseFloat(num).toFixed(2);

						var a_info= "Company Address: "+ data[i].address +"<br/>" + "City: "+data[i].city+"<br/>" + "Industry: " +data[i].industry+ "<br/>" + "Product: " +data[i].product +  "<p style='margin:0;line-height:1.5;font-weight:bold;font-size:13px;'>"+"Rating: "+n+"</p>" + "<p style='margin:0;line-height:1.5;color: orange;font-size:13px; '>"+data[i].num_r+" Reviews"+"</p>";

						a_div.innerHTML = a_info;												
						info.appendChild(a_div);
						
						list.appendChild(info);	
							
										
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
	
	var star;
	function infoOver(){
		//alert(this.data.name);
		//alert(this.data.lng);
		this.style.cursor="pointer";
		
		map.removeOverlay(star);
		var point = new BMap.Point(this.data.lng, this.data.lat);
		map.centerAndZoom(point, 15);
		//set = new BMap.Marker(point); // 创建点
		
		
		star = new BMap.Marker( point, {
			// 初始化五角星symbol
			icon: new BMap.Symbol(BMap_Symbol_SHAPE_STAR, {
			scale: 1.1,
			fillColor: "pink",
			fillOpacity: 0.3
		  })
		});
		map.addOverlay(star); 
	}
	
	function infoClick(){
		var mydiv = document.getElementById('getCompany').innerHTML = '<form id="getC"  action="company.php"><input name="company" type="hidden" value="'+ this.data.company +'" /><input name="lng" type="hidden" value="'+ this.data.lng +'" /><input name="lat" type="hidden" value="'+ this.data.lat +'" /></form>';
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
  map.disableScrollWheelZoom();
  //禁用滚轮放大缩小
</script>


