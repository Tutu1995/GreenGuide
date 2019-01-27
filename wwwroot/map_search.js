(function(){
	"use strict";
window.onload=function(){

var map = new BMap.Map("allmap");	


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

	  //map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);  // 初始化地图,设置中心点坐标和地图级别
	  
	  map.setCurrentCity("北京");          // 设置地图显示的城市 此项是必须设置的
	  //map.enableScrollWheelZoom(false);     //开启鼠标滚轮缩放


	  var ajax = new XMLHttpRequest();
	  ajax.onload = getProfile;
	  ajax.open("GET", "getProfile.php?page=1", true);
	  ajax.send();
	  toggleLoadingMessage();




function getProfile() {
		//alert("3");
		toggleLoadingMessage();
		if (this.status == 200) {
			//alert("4");
			//alert(this.responseText);
			var json = JSON.parse(this.responseText);
			//alert("5");
			//alert(json.data.length);


			if(json.data.length>0){
				//alert(json.data[0].lng);
			//map.centerAndZoom(new BMap.Point(json.data[0].lng,json.data[0].lat), 15);
			map.setViewport({center:new BMap.Point(json.data[0].lng,json.data[0].lat),zoom:15})
			
			
			//alert("9");
			
					   
			var m_color;		   	
				for(var i=0;i<json.data.length;i++){
					//alert("6");
					var m_color;
					//设置marker图标为水滴
					if (json.data[i].avg_r<-2){
						m_color="red";
					}
					else if(json.data[i].avg_r>=-2 && json.data[i].avg_r<-1 ){
						m_color="orange";
					}else if(json.data[i].avg_r>=-1 && json.data[i].avg_r<0){
						m_color="yellow";
					}else if(json.data[i].avg_r==0){
						m_color="white";
					}else if(json.data[i].avg_r>0 && json.data[i].avg_r<=1){
						m_color="aqua";
					}else if(json.data[i].avg_r>1 && json.data[i].avg_r<=2){
						m_color="lime";
					}else{
						m_color="green";
					}
					//alert("7");
					//alert(json.data[i].lng);
					//alert(json.data[i].lat);
					var marker = new BMap.Marker(new BMap.Point(json.data[i].lng,json.data[i].lat), {
					  // 指定Marker的icon属性为Symbol
					  icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
						scale: 1.5,//图标缩放大小
						fillColor: m_color,//填充颜色
						fillOpacity: 0.8//填充透明度
					  })
					});
					

					
					var content = "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+json.data[i].company+"</h4>" + "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+json.data[i].address+"</p>"+ "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+json.data[i].city+"</p>"+"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+"Rating: "+json.data[i].avg_r+"</p>";
					//alert("8");
					map.addOverlay(marker);  
					//alert("10");             // 将标注添加到地图中
					addClickHandler(content,marker);
					//alert("11"); 

					
				}			
				// 将地址解析结果显示在地图上,并调整地图视野
			// set page list
			setPage(json.review_count);
			setList(json);

			}else{
				map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
			}	
					   
			

		} else {
			alert("HTTP error " + this.status + ": " + this.statusText + "\n" + this.responseText);
		}
}	


			function addClickHandler(content,marker){
				marker.addEventListener("click",function(e){
					openInfo(content,e)
					//alert("12");
					//pointInfo(e)
					
					}			
				);
				
			}
			
			
			function openInfo(content,e){
				var p = e.target;
				var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
				var opts = {
						width : 280,     // 信息窗口宽度
						height: 112,     // 信息窗口高度
						enableMessage:true//设置允许信息窗发送短息
					   };
				var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
				map.openInfoWindow(infoWindow,point); //开启信息窗口
				//alert(content);
			}

			function setPage(count){
				//alert(count);
				var squareArea=document.getElementById("page");
				for(var i=0; i<count/10;i++){
					//alert(i);
					var square = document.createElement("div");
					square.className="page_note";
		
					square.innerHTML=i+1;
					square.onmouseover=squareOver;
					square.onclick=squareClick;
					square.onmouseout=squareOut;

					squareArea.appendChild(square);
				}
			}

			function squareOver(){
				var no_line = document.querySelectorAll("#page div");
			    for (var i = 0; i < no_line.length; i++) {
			        no_line[i].style.textDecoration = "none";
			    }  
				
				this.style.textDecoration="underline";
				this.style.cursor="pointer";
	
			}

			function squareOut(){
				var no_line = document.querySelectorAll("#page div");
			    for (var i = 0; i < no_line.length; i++) {
			        no_line[i].style.textDecoration = "none";
			    }  
			}

			function squareClick(){
				//alert("click");
				//alert(this.innerHTML);
				var ajax = new XMLHttpRequest();
				ajax.onload = showList;
				ajax.open("GET", "getProfile.php?page="+this.innerHTML, true);
				ajax.send();
				toggleLoadingMessage();
			}

			function showList(){
				toggleLoadingMessage();
				if (this.status == 200) {
					//alert("showlist");
					//alert(this.responseText);
					var json = JSON.parse(this.responseText);
					setList(json);	
				}
				else {
					alert("HTTP error " + this.status + ": " + this.statusText + "\n" + this.responseText);
				}
			}


			function setList(json){
				
					//alert("5");
					//alert(json.all.length);

					var b_color = document.querySelectorAll("#page div");
					for (var c=0; c<json.review_count/10; c++){	
						b_color[c].style.border="";
					}
					for (var c=0; c<json.review_count/10; c++){
						//alert("c"+c);
						//alert("innerHTML"+b_color[c].innerHTML);
						//alert("page"+json.page);
						if (b_color[c].innerHTML==json.page)
						{
							b_color[c].style.border="2px solid blue";
						}
					}


					var list=document.getElementById("list");
					while (list.hasChildNodes()) {   
						list.removeChild(list.firstChild);
					}
					
					for (var i = 0; i < json.all.length; i++) {
						
						//alert(i);
						var info = document.createElement("div");
						info.className="info";
						info.setAttribute("id", "info"+json.all[i].review.review_id );
						var p = document.createElement("div");
						p.className = "info_p";	

						var pic=["_3.png","_2.png","_1.png","0.png","1.png","2.png","3.png"];
						var pic_rate= parseInt(json.all[i].review.rating)+3;
						var r_info= "Company Name: " + json.all[i].review.company +"<br/>" + "Company Address: "+ json.all[i].review.address +"<br/>" + "City: "+json.all[i].review.city+"<br/>" + "Rating: "+json.all[i].review.rating+"<br/>"+ "<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+json.all[i].review.review +"<br/>"+ "Environment Type: "+json.all[i].review.water+" "+json.all[i].review.air+" "+json.all[i].review.waste+" "+json.all[i].review.land+" "+json.all[i].review.living+" "+json.all[i].review.other+"<br/>"+"Related News, Videos, or links: "+json.all[i].review.news+"<br/>"+"Time: "+json.all[i].review.time+"<br/>";
						
						p.innerHTML = r_info;			
																	
						info.appendChild(p); 
						var image_div = document.createElement("div");						
						image_div.className="image_div";
						image_div.data = {				
						  id: json.all[i].review.review_id				  	  
						}
		    			image_div.setAttribute("id", "image_div"+json.all[i].review.review_id );
		    			info.appendChild(image_div);


		    			if (json.all[i].img_count>0){
								var btn_v = document.createElement("BUTTON");				
				    			btn_v.innerHTML="View Image";   			
				    			btn_v.className="btn_v";
				    			btn_v.data = {				
								  id: json.all[i].review.review_id				  	  
								}
				    			btn_v.onclick=btnClick_v;
				    			btn_v.setAttribute("id", "btn_v"+json.all[i].review.review_id );
				    	}

						//alert(json.all[i].img_count);
						var img_c_div = document.createElement("div");
						img_c_div.innerHTML="Image Count: "+ json.all[i].img_count;
						img_c_div.className="img_c";
						/*
							for (var j = 0; j < json.all[i].all_image.length; j++) {											
								var img = document.createElement("img");						
								img.setAttribute("src", "data:image/jpg;base64,"+json.all[i].all_image[j].image);						
								img.className="img";						
								image_div.appendChild(img);												
							}
						
							info.appendChild(image_div);	
						*/


						var btn = document.createElement("BUTTON");				
		    			btn.innerHTML="Edit Text";    			
		    			btn.className="btn_edit";
		    			btn.data = {				
						  id: json.all[i].review.review_id				  	  
						}
						//alert("data_id:"+all[i].review.review_id);
		    			btn.onclick=btnClick_e;
		    			btn.setAttribute("id", "btn_e"+json.all[i].review.review_id );

		    			


		    			var btn_i = document.createElement("BUTTON");				
		    			btn_i.innerHTML="Edit Image";   			
		    			btn_i.className="btn_i";
		    			btn_i.data = {				
						  id: json.all[i].review.review_id				  	  
						}
		    			btn_i.onclick=btnClick_i;
		    			btn_i.setAttribute("id", "btn_i"+json.all[i].review.review_id );

		    			


		    			var btn_d = document.createElement("BUTTON");				
		    			btn_d.innerHTML="Delete Review";   			
		    			btn_d.className="btn_del";
		    			btn_d.data = {				
						  id: json.all[i].review.review_id				  	  
						}
		    			btn_d.onclick=btnClick_d;
		    			btn_d.setAttribute("id", "btn_d"+json.all[i].review.review_id );

		    			

		    			var btn_c = document.createElement("div");
		    			btn_c.className="btn_c";

		    			btn_c.appendChild(btn);
		    			btn_c.appendChild(btn_d);
		    			btn_c.appendChild(btn_i);
		    			if (json.all[i].img_count>0){
		    				btn_c.appendChild(btn_v);
		    			}
		    			btn_c.appendChild(img_c_div);

		    			info.appendChild(btn_c);


		    			//var text = document.createElement("div");
		    			//text.setAttribute("id", all[i].review.review_id );
		    			//text.className="text";

		    			//info.appendChild(text);

		    			
						list.appendChild(info);				
					}
				
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
						
						var x;
					    if (confirm("Are you sure to delet this review?") == true) {
					        x = 1;
					    } else {
					        x = 0;
					    }
					    if(x){
					    	toggleLoadingMessage();
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

					function btnClick_v(){
							toggleLoadingMessage();
							var id=this.data.id;					
							//alert("view id: "+id);

							var params = new FormData();
							params.append("id", id);			
							
							var ajax = new XMLHttpRequest();
							ajax.onload = view;
							ajax.open("POST", "view.php", true);
							ajax.send(params);

					}


					function view() {
						toggleLoadingMessage();
						if (this.status == 200) {

								var json = JSON.parse(this.responseText);
								//alert(this.responseText);
								var image_div=document.getElementById("image_div"+json.id );  
								
								for (var j = 0; j < json.all_image.length; j++) {											
									var img = document.createElement("img");						
									img.setAttribute("src", "data:image/jpg;base64,"+json.all_image[j].image);						
									img.className="img";						
									image_div.appendChild(img);												
								}	
								document.getElementById("btn_v"+json.id).disabled = true;	
						}
						else{
							alert("error in ajax");
						}
					}


					function del() {
						toggleLoadingMessage();
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

					function toggleLoadingMessage() {
						var load = document.getElementById("loading");
						if (load.style.display) {
							load.style.display = "";
						} else {
							load.style.display = "none";
						}
					}	
	



};


}
)();