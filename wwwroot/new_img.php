<?php
	include("db.php");
	ensure_logged_in();

	$id=htmlspecialchars($_POST["id"]);

	$img_e_token=htmlspecialchars($_POST["img_e_token"]);

	$i_size=htmlspecialchars($_POST["i_size"]);

	$img_token = md5(uniqid(rand(),TRUE));
	$_SESSION["img_token"] = $img_token; 

	//echo $id;

	 if(isset($_POST['submit'])){
	 		 //echo "submit";

		  	if(!isset($_POST["img_e_token"]) || !isset($_SESSION["img_e_token"]) || $_POST["img_e_token"] !== $_SESSION["img_e_token"]) {
			        print "Error: Your session is invalid. Transfer not performed";
			        die();
		      } else {
		          	unset($_SESSION["img_e_token"]);
            		
					 try{
								  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
								  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								  $checkid=$con->prepare("select id from profile where review_id=:id and name=:name");	
								  $checkid->bindParam(':id', $id);
								  $checkid->bindParam(':name', $_SESSION["name"]);
								  $checkid->execute();
								  
								  if($checkid){
										foreach($checkid as $check_id){
								  
											  if(isset($_FILES['image'])){	

											  		$img_size=0;
									  				foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
									  					if($_FILES['image']['tmp_name'][$key]){
									  						$img_size+=$_FILES['image']['size'][$key];
									  					}
									  				}

									  				if($img_size>(8388608-$i_size)){
									  						$txt= "Sorry, updated image size is bigger than 8MB. Please check the image size again.";
									  				} else {
									  						//$n = round(((8388608-$i_size-$img_size)/1024/1024),4);
											  				$txt= "This review has ".(8388608-$i_size-$img_size). " MB left for image."  ;								  					
															  foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
																	  $image=addslashes($_FILES['image']['tmp_name'][$key]);
																	  //$name=addslashes($_FILES['image']['name'][$key]);
																	  $image=file_get_contents($image);
																	  $image=base64_encode($image);
																	  //$result=$con->query("insert into image (name,image,review_id) values('$name','$image','$id')");
																	  $result=$con->prepare("insert into image (image,review_id) values(:image,:id)");
																	  $result->bindParam(':image', $image);
																	  $result->bindParam(':id', $id);
																	  $result->execute();

																	  $set_null=$con->prepare("update review set status=:status where id=:id");	
																	  $set_null->bindParam(':id', $id);
																	  $set_null->bindValue(':status', null, PDO::PARAM_INT);
																	  $set_null->execute();	
															  }
													}
											  }
										}
								   }
						}
						catch(Exception $e){
							//die(print_r($e));
							die("Sorry, error occured. Please try again.");
						}
			}
			
	  }
	

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>New Images</title>
		
		
	</head>

	<body>
      		<div id="new_img"></div>
	</body>
</html>





<script type="text/javascript">
		var re_id = <?php echo json_encode($id) ?>;
		//alert(re_id);
		var img_token = <?php echo json_encode($img_token) ?>;
		var txt = <?php echo json_encode($txt) ?>;
		
		
				var mydiv = document.getElementById('new_img').innerHTML = '<form id="new_i"  action="img_e.php" method="post"><input name="id" type="hidden" value="'+ re_id+'" /><input name="img_token" type="hidden" value="'+ img_token +'" /><input name="txt" type="hidden" value="'+ txt +'" /></form>';
				        var f=document.getElementById('new_i');
				        if(f){
				        f.submit();
				            //alert('submitted!');
				        }
		

</script>
