<?php
	$id=$_POST["id"];

	echo $id;

	 //if(isset($_POST['submit'])){
	 		 echo "submit";
            //if(is_uploaded_file($_FILES['image']['tmp_name'])){ 
					 try{
								  $con=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
								  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								  
								  if(isset($_FILES['image'])){	
								  echo "image";		  		
										  foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
										  		if($_FILES['image']['tmp_name'][$key]){

														  $image=addslashes($_FILES['image']['tmp_name'][$key]);
														  $name=addslashes($_FILES['image']['name'][$key]);
														  $image=file_get_contents($image);
														  $image=base64_encode($image);
														  $result=$con->query("insert into image (name,image,review_id) values('$name','$image','$id')");
													}
										  }
								  }
								  
						}
						catch(Exception $e){
							die(print_r($e));
						}
			//}
	  //}
	

?>

<!--
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
-->





<script type="text/javascript">
/*
		var re_id = <?php echo json_encode($id) ?>;
		//alert(re_id);
		

		var mydiv = document.getElementById('new_img').innerHTML = '<form id="new_i"  action="img_e.php" method="post"><input name="id" type="hidden" value="'+ re_id+'" /></form>';
		        var f=document.getElementById('new_i');
		        if(f){
		        f.submit();
		            //alert('submitted!');
		        }
*/
</script>