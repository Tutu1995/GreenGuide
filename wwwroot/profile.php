<?php
  		  include("db.php");
		  ensure_logged_in();

		  $edit_token = md5(uniqid(rand(),TRUE));
		  $_SESSION["edit_token"] = $edit_token;


		  $img_token = md5(uniqid(rand(),TRUE));
		  $_SESSION["img_token"] = $img_token;


		  try{
				  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				  $s_name=$_SESSION["name"];
				  $rows=$db->query("select lng, lat, company, address, city, AVG(rating) as avg_r, COUNT(r.id) AS num_r from review r join profile p on r.id= p.review_id where p.name='$s_name' GROUP BY lng,lat,company ");

				  $a=array();
				  foreach ($rows as $row) {

						$a[]=$row;
				  }

				  $reviews=$db->query("select * from review r join profile p on r.id= p.review_id where p.name='$s_name' order by r.id DESC ");
				  $all=array();
				  foreach ($reviews as $review) {
						//$p_image= array();
						//$images=$con->query("select * from image where review_id=$review[0] ");
						$images_c=$db->query("select COUNT(id) from image where review_id=$review[0] ");
						//$image_count = $images_c -> fetchColumn()
						//$img_count = $images -> fetchColumn()
						/*
						if($images){
							  foreach($images as $image)
							  {
								  $p_image[]=$image;

							  }
						}
						*/
						//$all[]=array("review"=>$review,"all_image"=>$p_image);
						$all[]=array("review"=>$review, "img_count" => $images_c -> fetchColumn());
						//$all[]=array("review"=>$review);
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

	<title>User Profile</title>
	<link rel="shortcut icon" href="green-pin.png">
</head>
<body>

      			<?php
					include("header_b.php");
				?>
      			<!--
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
                                          <li id="profile"><a href="profile.php">My Reviews</a></li>
                                          <li><a href="WriteReview.php">Write a Community Review</a></li>
                                          <li><a href="map.php">Explore Reviews on a Map</a></li>

                                     </ul>
                                </nav>

                       </div>

                       <div id="side">
                                <div style="margin-bottom:1em;"><a href="signup.php">Sign Up</a></div>
                                <div><a href="user.php">Log In/Out</a></div>
                       </div>
                  </header>

                  <p style="color:RGB(0,176,80); background-color: #F8F8F8; text-align:center; width:100%; margin-top: 0px; ">Your recent reviews - You can edit and delete reviews here.</p>
                  -->
                  <div class="container text-center"><p class="text-primary">Your recent reviews - You can edit and delete reviews here.</p></div>

                  <div id="allmap"></div>

                  <div class="container-fluid"><h3 id="count_c"></h3></div>
                  <div id="list"></div>
                  <div id="loading" style="display: none">
						<img src="loading.gif" />
						Processing ...
				  </div>
                  <div id="getedit"></div>
                  <div id="imgedit"></div>
                  <div class="container-fluid"><div id="page"></div></div>
                  <?php
				  	include("footer.php");
			  	  ?>

                  <!--
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
                  -->

</body>
</html>


<script type="text/javascript">
	"use strict";
	// 百度地图API功能
	var data = <?php echo json_encode($a) ?>;
	var all = <?php echo json_encode($all) ?>;
	//var all_page1 = all.slice(all.length-10-1, all.length);
	var edit_token = <?php echo json_encode($edit_token) ?>;
	//var del_token = <?php echo json_encode($del_token) ?>;
	var img_token = <?php echo json_encode($img_token) ?>;
	var length=data.length;

	document.getElementById("profile").className="active";

	var count_c=document.getElementById("count_c");
	count_c.innerHTML=all.length+" Reviews"
	count_c.className="text-warning";
	count_c.style.borderBottom="1px solid silver";
	count_c.style.marginTop = "3px";

	var map = new BMap.Map("allmap");

	if(data.length>0){
				map.centerAndZoom(new BMap.Point(data[length-1].lng,data[length-1].lat), 10);


				var opts = {
							//width : 280,     // 信息窗口宽度
							//height: 112,     // 信息窗口高度
							width : 260,     // 信息窗口宽度
							height: 130,     // 信息窗口高度
							offset: new BMap.Size(10,-25),
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


					var num = data[i].avg_r;
					var n = parseFloat(num).toFixed(2);

					var content = "<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+data[i].company+"</h4>" +
				"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].address+"</p>"+ "<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>"+data[i].city+"</p>"+"<p style='margin:0;line-height:1.5;font-size:13px;font-weight: bold;text-indent:2em'>"+"Rating: "+n+"</p>" +  "<p style='margin:0;line-height:1.5;color: orange;font-size:13px;text-indent:2em'>"+data[i].num_r+" Reviews"+"</p>";

					map.addOverlay(marker);               // 将标注添加到地图中
					addClickHandler(content,marker);

					setPage(1);
					setList(1);

					/*
					toggleLoadingMessage();
					var ajax = new XMLHttpRequest();
					ajax.onload = pInfoGet;
					ajax.open("GET", "ajax_com.php?company="+data[i].company+"&lng="+ data[i].lng +"&lat="+ data[i].lat+"&page="+"1", true);
					ajax.send();
					*/
				}


		} else {
					map.centerAndZoom(new BMap.Point(116.417854,39.921988), 15);
	}

	/*
	function pInfoGet() {
		//alert("3");
		toggleLoadingMessage();
		if (this.status == 200) {
			//alert("4");
			//alert(this.responseText);
			var json = JSON.parse(this.responseText);
			// set page list
			setPage(json.review_count, json.company, json.lng, json.lat);
			setList(json);
		} else {
			alert("HTTP error " + this.status + ": " + this.statusText + "\n" + this.responseText);
		}
	}
	*/

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



	function setPage(page){
				//alert(count);
				var squareArea=document.getElementById("page");

				while (squareArea.hasChildNodes()) {
					squareArea.removeChild(squareArea.firstChild);
				}

				var next=false;
				var pre=false;
				var first = 1;
				var page_num = Math.ceil(all.length/10);
				var last = page_num;
				if (page_num>5)
				{
					if(parseInt(page)-3>0){
						first=parseInt(page)-2;
						if(parseInt(page)+2>page_num){
							last = page_num;
						}
						else{
							last=parseInt(page)+2;
						}
					}
					else{
						first=1;
						last=5;
					}
				}

				if (parseInt(page)==parseInt(page_num)){
					next=false;
				}
				else{
					next=true;
				}

				if (parseInt(page)>1){
					pre=true;
				}


				if (pre){
					var square = document.createElement("div");
					square.className="page_note";
					square.data = {

								item:parseInt(page)-1
						}

					square.innerHTML="pre";
					square.onmouseover=squareOver;
					square.onclick=itemClick;
					square.onmouseout=squareOut;

					squareArea.appendChild(square);
				}


				for(var i=first-1; i<last;i++){
					//alert(i);
					var square = document.createElement("div");
					square.className="page_note";
					/*
					square.data = {
								company: company,
								lng:lng,
								lat:lat
						}
					*/
					square.innerHTML=i+1;
					square.onmouseover=squareOver;
					square.onclick=squareClick;
					square.onmouseout=squareOut;

					squareArea.appendChild(square);
				}


				if (next){
					var square = document.createElement("div");
					square.className="page_note";
					square.data = {

								item:parseInt(page)+1
						}

					square.innerHTML="next";
					square.onmouseover=squareOver;
					square.onclick=itemClick;
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
				/*
				toggleLoadingMessage();
				var ajax = new XMLHttpRequest();
				ajax.onload = showList;
				ajax.open("GET", "ajax_com.php?company="+this.data.company+"&lng="+ this.data.lng +"&lat="+ this.data.lat+ "&page="+this.innerHTML, true);
				ajax.send();
				*/
				setPage(this.innerHTML);
				setList(this.innerHTML);
			}

			function itemClick(){
				setPage(this.data.item);
				setList(this.data.item);
			}

			/*
			function showList(page){


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

			}*/


	function setList(page){
			var all_page = all.slice((page-1)*10, page*10);

			var b_color = document.querySelectorAll("#page div");
			for (var c=0; c<b_color.length; c++){
					b_color[c].style.border="";
			}
			for (var c=0; c<b_color.length; c++){
						//alert("c"+c);
						//alert("innerHTML"+b_color[c].innerHTML);
						//alert("page"+json.page);
					if (b_color[c].innerHTML==page)
					{
						b_color[c].style.border="1px solid blue";
					}
			}

			var list=document.getElementById("list");
			while (list.hasChildNodes()) {
				list.removeChild(list.firstChild);
			}


			for (var i = 0; i < all_page.length; i++) {

				var wrap = document.createElement("div");
				wrap.className="container-fluid";
				wrap.setAttribute("id", "wrap"+all_page[i].review.review_id );

				var c_row = document.createElement("div");
				c_row.className="row";

				var container = document.createElement("div");
				container.className="col-sm-11";
				//container.style.borderBottom = "1px solid silver";
				container.style.paddingTop = "10px";


				var ad = document.createElement("div");
				ad.className="col-sm-1";


				var info = document.createElement("div");
				info.className="row";
				//info.setAttribute("id", "info"+all_page[i].review.review_id );
				//alert("all_page[i].review.review_id: "+all_page[i].review.review_id);
				var p = document.createElement("div");
				//p.className = "info_p";
				p.className = "col-sm-6 info_pb";

				var pic=["_3.png","_2.png","_1.png","0.png","1.png","2.png","3.png"];
				var pic_rate= parseInt(all_page[i].review.rating)+3;

				var r_status;
				var status_color;
				switch (all_page[i].review.status) {
				    case "1":
				        r_status="Public";
				        status_color="green";
				        break;
				    case "2":
				        r_status="Postponed";
				        status_color="orange";
				        break;
				    default:
				        r_status="In Process";
				        status_color="blue";
				}

				//var r_info= "Company Name: " + all_page[i].review.company +"<br/>" + "Company Address: "+ all_page[i].review.address +"<br/>" + "City: "+all_page[i].review.city+"<br/>" + "Rating: "+all_page[i].review.rating+"<br/>" + "<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+all_page[i].review.review +"<br/>"+ "Environment Type: "+all_page[i].review.water+" " +all_page[i].review.air+" "+all_page[i].review.waste+" "+all_page[i].review.land+" "+all_page[i].review.living+" "+all_page[i].review.other+"<br/>"+"Related News, Videos, or links: "+all_page[i].review.news+"<br/>"+"Time: "+all_page[i].review.time+"<br/>";
				var r_info= "<h4 style='margin:0 0 5px 0;color:"+ status_color +";'>"+r_status+"</h4>" + "Company Name: " + all_page[i].review.company +"<br/>" + "Company Address: "+ all_page[i].review.address +"<br/>" + "City: "+all_page[i].review.city+"<br/>" + "Company Industry: " +all_page[i].review.industry+"<br/>"+ "Company Product: " +all_page[i].review.product+ "<br/>"+"Rating: "+all_page[i].review.rating+"<br/>" + "<img src='"+ pic[pic_rate] +"' width='228' height='30' /><br/>"+ "Reviews: "+all_page[i].review.review +"<br/>"+ "Review Focus: "+all_page[i].review.water+" " +all_page[i].review.air+" "+all_page[i].review.waste+" "+all_page[i].review.land+" "+all_page[i].review.living+" "+all_page[i].review.other+"<br/>"+"Related News, Videos, or links: "+all_page[i].review.news+"<br/>"+ "EPA Data: " +all_page[i].review.epa+ "<br/>"+ "Measurement Data: " +all_page[i].review.measure+ "<br/>"+"Time: "+all_page[i].review.time+"<br/>";
				//var r_info="<p>"+all_page[i].review.review+"</p>";

				p.innerHTML = r_info;

				info.appendChild(p);


				var image_div = document.createElement("div");
				//image_div.className="image_div";
				image_div.className="col-sm-5";
				image_div.data = {
						id: all_page[i].review.review_id
				}
	    	image_div.setAttribute("id", "image_div"+all_page[i].review.review_id);
	    	info.appendChild(image_div);


	    	if (all_page[i].img_count>0){
					var btn_v = document.createElement("BUTTON");
			    	btn_v.innerHTML="View Image";
			    	btn_v.className="btn btn-default";
			    	btn_v.style.display = "inline-block";
			    	btn_v.data = {
							id: all_page[i].review.review_id
					}
		    	btn_v.onclick=btnClick_v;
		    	btn_v.setAttribute("id", "btn_v"+all_page[i].review.review_id);
				}

				//alert(json.all[i].img_count);
				var img_c_div = document.createElement("p");
				img_c_div.innerHTML="Image Count: "+ all_page[i].img_count;
				//img_c_div.className="img_c";


				/*
					for (var j = 0; j < json.all[i].all_image.length; j++) {
						var img = document.createElement("img");
						img.setAttribute("src", "data:image/jpg;base64,"+json.all[i].all_image[j].image);
						img.className="img";
						img.onmouseover=imgOver;

						image_div.appendChild(img);
					}
				*/

						var btn = document.createElement("BUTTON");
		    			btn.innerHTML="Edit Text";
		    			btn.className="btn btn-default";
		    			btn.data = {
						  id: all_page[i].review.review_id
						}
						//alert("data_id:"+all[i].review.review_id);
		    			btn.onclick=btnClick_e;
		    			btn.setAttribute("id", "btn_e"+all_page[i].review.review_id );




		    			var btn_i = document.createElement("BUTTON");
		    			btn_i.innerHTML="Edit Image";
		    			btn_i.className="btn btn-default";
		    			btn_i.data = {
						  id: all_page[i].review.review_id
						}
		    			btn_i.onclick=btnClick_i;
		    			btn_i.setAttribute("id", "btn_i"+all_page[i].review.review_id );




		    			var btn_d = document.createElement("BUTTON");
		    			btn_d.innerHTML="Delete Review";
		    			btn_d.className="btn btn-default";
		    			btn_d.data = {
						  id: all_page[i].review.review_id
						}
		    			btn_d.onclick=btnClick_d;
		    			btn_d.setAttribute("id", "btn_d"+all_page[i].review.review_id );


		    			var btn_ct = document.createElement("div");
		    			btn_ct.className="row";

		    			var btn_lt = document.createElement("div");
		    			btn_lt.className="col-sm-6 col-sm-pull-5";

		    			var btn_rt = document.createElement("div");
		    			btn_rt.className="col-sm-5 col-sm-push-6";

		    			btn_rt.appendChild(img_c_div);

		    			btn_ct.appendChild(btn_rt);
				    	btn_ct.appendChild(btn_lt);



		    			var btn_c = document.createElement("div");
		    			btn_c.className="row";

		    			var btn_l = document.createElement("div");
		    			btn_l.className="col-sm-6 col-sm-pull-5";
		    			//btn_l.style.paddingTop = "10px";


		    			btn_l.appendChild(btn);
		    			btn_l.appendChild(btn_d);


		    			var btn_r = document.createElement("div");
		    			btn_r.className="col-sm-5 col-sm-push-6";

		    			//btn_r.appendChild(img_c_div);
		    			btn_r.appendChild(btn_i);
		    			if (all_page[i].img_count>0){
				    		btn_r.appendChild(btn_v);
				    	}


				    	btn_c.appendChild(btn_r);
				    	btn_c.appendChild(btn_l);

				    	/*
		    			var btn_c = document.createElement("div");
		    			btn_c.className="btn_c";

		    			btn_c.appendChild(btn);
		    			btn_c.appendChild(btn_d);
		    			btn_c.appendChild(btn_i);
		    			if (all_page[i].img_count>0){
		    				btn_c.appendChild(btn_v);
		    			}
		    			btn_c.appendChild(img_c_div);
		    			*/

		    			var border_b = document.createElement("p");
						border_b.className="border_b";


		    			container.appendChild(info);
		    			container.appendChild(btn_ct);
		    			container.appendChild(btn_c);
		    			container.appendChild(border_b);

						c_row.appendChild(container);
						c_row.appendChild(ad);

						wrap.appendChild(c_row);

						list.appendChild(wrap);
			}



	}


			function imgOver(){

				var no_border =this.parentNode.childNodes;
			    for (var i = 0; i < no_border.length; i++) {
			        no_border[i].className="img";
			    }
				this.className="img_over";
			}


			function imgOut(){
				var no_border =this.parentNode.childNodes;
			    for (var i = 0; i < no_border.length; i++) {
			        no_border[i].className="img";
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
									//img.setAttribute("src", "data:image/jpg;base64,"+json.all_image[j].image);
									if(json.inupfile==0){
											img.setAttribute("src", "data:image/jpg;base64,"+json.all_image[j]);
									}
									else{
											img.setAttribute("src", json.all_image[j]);
									}
									img.className="img";
									image_div.appendChild(img);
								}
								document.getElementById("btn_v"+json.id).disabled = true;
						}
						else{
							alert("error in ajax");
						}
					}


					function btnClick_e(){
						//alert("edit text");
						var mydiv = document.getElementById('getedit').innerHTML = '<form id="gete"  action="edit.php" method="post"><input name="id" type="hidden" value="'+ this.data.id +'" /><input name="edit_token" type="hidden" value="'+ edit_token +'" /></form>';
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
							//params.append("del_token", del_token);

							var ajax = new XMLHttpRequest();
							ajax.onload = del;
							ajax.open("POST", "del.php", true);
							ajax.send(params);
					    }
					}

					function btnClick_i(){
						//alert("edit image");
						var mydiv = document.getElementById('imgedit').innerHTML = '<form id="geti"  action="img_e.php" method="post"><input name="id" type="hidden" value="'+ this.data.id +'" /><input name="img_token" type="hidden" value="'+ img_token +'" /></form>';
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





					function del() {
						toggleLoadingMessage();
						if (this.status == 200) {
							//alert("4");
							//alert(this.responseText);
							var json = JSON.parse(this.responseText);

							//var show=document.getElementById(json.id);
							//show.innerHTML="This review is deleted!";
							var info_d=document.getElementById("wrap"+json.id );
							//alert("5");
		          			list.removeChild(info_d);
		          			//alert("6");

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
  map.disableScrollWheelZoom();
  //禁用滚轮放大缩小
</script>
