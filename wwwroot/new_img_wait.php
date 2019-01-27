<?php
	header("Content-type: application/json");
	$id=$_POST["id"];

	//echo $id;

	 if(isset($_POST['submit'])){
	 		 //echo "submit";
            //if(is_uploaded_file($_FILES['image']['tmp_name'])){ 
					 try{
								  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
								  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								  
								  if(isset($_FILES['image'])){	
								  //echo "image";	
								 // $all= array();
								  $p_image= array();	  		
										  foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
										  		if($_FILES['image']['tmp_name'][$key]){

														  $image=addslashes($_FILES['image']['tmp_name'][$key]);
														  $name=addslashes($_FILES['image']['name'][$key]);
														  $image=file_get_contents($image);
														  $image=base64_encode($image);
														  $result=$con->query("insert into image (name,image,review_id) values('$name','$image','$id')");
/*
														  $last_id = $con->lastInsertId();
														  		
																$rows=$con->query("select * from image where id='$last_id' ");
																if($rows){	
																	  foreach($rows as $row)	
																	  {
																		  $p_image[]=$row;
																		  //echo "img: " . $image[2];
																		  //echo'<img height="190" width="190" src="data:image;base64,'.$image[2].'"> ';
																		  
																	  }
																}
																
*/
													}
										  }
								  }
								  //$all[]=array("id"=>$id,"all_image"=>$p_image);
								  
						}
						catch(Exception $e){
							die(print_r($e));
						}
			//}
	  }

	  $json = array(			  	
				  "all_image"=>$p_image,
			  	);
			  
	  print json_encode($json);
	

?>

