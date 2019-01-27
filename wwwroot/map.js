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


	}else{
		map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	}	
			
			
	
	
	
	
</script>
