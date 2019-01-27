<?php
	include("top_1113bootest.php");
	include("db.php");
	ensure_logged_in();
	$id=htmlspecialchars($_POST["id"]);

	$s_edit_token = md5(uniqid(rand(),TRUE));
	$_SESSION["s_edit_token"] = $s_edit_token; 


	$edit_token=htmlspecialchars($_POST["edit_token"]);

	if(!isset($_POST["edit_token"]) || !isset($_SESSION["edit_token"]) || $_POST["edit_token"] !== $_SESSION["edit_token"]) {
				print "错误发生, 请回上页重新再试";
				die();
		  } else {
		  		//unset($_SESSION["edit_token"]);

	try{
				  //$con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 
				  //$rows=$con->query("select * from review where id='$id' ");

				  $rows=$db->prepare("select * from review where id=:id ");					    
				  $rows->bindParam(':id', $id);
				  $rows->execute();


				  $all=array();
				  foreach ($rows as $row) {
				  		/*
						$p_image= array();
						$images=$con->query("select * from image where review_id=$row[0] ");
						if($images){	
							  foreach($images as $image)	
							  {
								  $p_image[]=$image;
								 
							  }
						}
						*/
						//$all[]=array("review"=>$row,"all_image"=>$p_image);	
						$all[]=array("review"=>$row);
						$r_company=$row[1];
						$r_address=$row[2];
						$r_city=$row[3];
				  } 
		}
		catch(Exception $e){
			//die(print_r($e));
			die("错误发生, 请重新再试");
		}

	}
?>


<head>
	<script src="rate.js" type="text/javascript"></script>
</head>

            <div class="container">
                
                  
              <h4>
                  公司名称: <?=$r_company?><br/> 
                  地址: <?=$r_address?>  城市: <?=$r_city?><br/> 
              </h4>
              <form action="s_edit.php" method="post" enctype="multipart/form-data">
                  <div>
                  	  <div class="form-group">
					    	<label for="category">*产业类别</label>
					    	<input class="form-control" id= "industry" type="text" name="industry" placeholder="ex. Oil & Gas or Electronics Manufacturing" required>
				      </div> 

				      <div class="form-group">
					    	<label for="products">*产品名称</label>
					    	<input class="form-control" id= "product" type="text" name="product" placeholder="ex. Glass" required>
				  	  </div> 

				  	  <div class="form-group">
						    <label for="rating">*评分:<span id="rate"></span></label>
						    <div id="sarea"></div>
	                        <div id="hint"></div>
	                        <input id="rating" type="hidden" name="rating">
	                        <input id="id" type="hidden" name="id"><br/> 
				      </div>

				      <!--
                      *What are this company's products? <input id= "product" type="text" name="product" size="150" placeholder="ex. Glass" required/><br/><br/>      
                      <div id="rate">*Your Rating: </div>
                      <div id="sarea"></div>
                      <div id="hint"></div>
                      <input id="rating" type="hidden" name="rating"><br/>     
                      <input id="id" type="hidden" name="id"><br/> 
                      *Your Reviews: <br/>
                       <textarea id="review" name="review" rows="10" cols="110" placeholder="Type your reviews here." required></textarea><br/><br/> 

                      <fieldset id="p_type">
                            <legend>What's your review focus on?</legend>
                            <label><input id="water" type="checkbox" name="water" />Water </label>
                            <label><input id="air" type="checkbox" name="air" />Air </label>
                            <label><input id="waste" type="checkbox" name="waste" />Waste </label>
                            <label><input id="land" type="checkbox" name="land" />Land</label>                   
                            <label><input id="living" type="checkbox" name="living" />Living Things </label>
                            <label><input id="other" type="checkbox" name="other" />Others </label>
                            <input id="other_item" type="text" name="other_item" size="20" /><br/>
                       </fieldset><br/>

                        Related News, Video or Links: <br/>
                       <textarea id="news" name="news" rows="3" cols="110" placeholder="Type related news, video or links here."></textarea><br/><br/>

                       EPA Data: <br/>
                       <textarea id="epa" name="epa" rows="3" cols="110" placeholder="Type EPA data here."></textarea><br/><br/>

                       Measurement data: (ex. PM2.5) <br/>
                       <textarea id="measure" name="measure" rows="3" cols="110" placeholder="Type measurement data here."></textarea><br/><br/>

                                              <input id="submit" type="submit" value="Save the edit" />
                                                                     <a id="cancel_edit"	href="http://greenguide.azurewebsites.net/profile.php"> Cancel </a>
                      -->

                      <div class="form-group">
						  <label for="review">*公司环境影响评价:</label>
						  <textarea id="review_txt" class="form-control" name="review" rows="10" placeholder="Type your reviews here." required></textarea>
					  </div> 

					  <div class="form-group">
					  	   <label for="p_type">环境关注点:</label>        		
							    <label class="checkbox-inline">
							      <input id="water" type="checkbox" name="water">水
							    </label>
							    <label class="checkbox-inline">
							      <input id="air" type="checkbox" name="air">空气
							    </label>
							    <label class="checkbox-inline">
							      <input id="waste" type="checkbox" name="waste">废弃物
							    </label>
							    <label class="checkbox-inline">
							      <input id="land" type="checkbox" name="land">土壤
							    </label>
							    <label class="checkbox-inline">
							      <input id="living" type="checkbox" name="living">生态系统
							    </label>
							    <label class="checkbox-inline">
							      <input id="other" type="checkbox" name="other">其他
							    </label>
							    <label class="checkbox-inline">
							      <input id="other_item" class="form-control" type="text" name="other_item" placeholder="Others" size="20" />
							    </label>		    		    
					   </div>                
                                

                       <div class="form-group">
							  <label for="Related">相关新闻、视频或链接:</label>
							  <textarea id="news" class="form-control" name="news" rows="3" placeholder="相关新闻、视频或链接" ></textarea>
					   </div>

					   <div class="form-group">
							  <label for="epa">环保局官方信息:</label>
							  <textarea id="epa" class="form-control" name="epa" rows="3" placeholder="环保局官方信息" ></textarea>
					   </div>

					   <div class="form-group">
							  <label for="Measure">实验数据: (例. PM2.5)</label>
							  <textarea id="measure" class="form-control" name="measure" rows="3" placeholder="实验数据" ></textarea>
					   </div>           


                       <input name="s_edit_token" type="hidden" value="<?= $s_edit_token ?>" />

                       <button id="submit" type="submit" class="btn btn-primary">保存编辑</button> 

                       <a href="http://www.lovegreenguide.com/ch/profile.php" class="btn btn-info" role="button">取消编辑</a>
                  </div>
              </form><br/>   
          </div>
          

		  <?php
				include("footer.php");
		  ?>

       	
	</body>
</html>



<script type="text/javascript">
		
	var all = <?php echo json_encode($all) ?>;

	document.getElementById("profile").className="active";

	var id=document.getElementById("id");
	id.value=all[0].review.id;

	var industry=document.getElementById("industry");
	industry.value=all[0].review.industry;
	var product=document.getElementById("product");
	product.value=all[0].review.product;

	var rate =document.getElementById("rate");
	rate.innerHTML=" "+ all[0].review.rating;
	var rating =document.getElementById("rating");
	rating.value= all[0].review.rating;
	var review_txt=document.getElementById("review_txt");
	review_txt.value=all[0].review.review;
	
	var news=document.getElementById("news");
	news.value=all[0].review.news;
	var water=document.getElementById("water");
	if(all[0].review.water){
		water.checked="checked";
	}
	var air=document.getElementById("air");
	if(all[0].review.air){
		air.checked="checked";
	}
	var waste=document.getElementById("waste");
	if(all[0].review.waste){
		waste.checked="checked";
	}
	var land=document.getElementById("land");
	if(all[0].review.land){
		land.checked="checked";
	}
	var living=document.getElementById("living");
	if(all[0].review.living){
		living.checked="checked";
	}
	var other=document.getElementById("other");
	if(all[0].review.other){
		other.checked="checked";
	}

	var other_item=document.getElementById("other_item");
	other_item.value=all[0].review.other;

	var epa=document.getElementById("epa");
	epa.value=all[0].review.epa;
	var measure=document.getElementById("measure");
	measure.value=all[0].review.measure;


	

</script>