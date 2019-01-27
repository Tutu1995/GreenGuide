<?php
	ini_set('mysql.connect_timeout',300);
	ini_set('default_socket_timeout',300);
?>

<html>
    <body>
    <form method="post" enctype="multipart/form-data">
    <input type="file" name="image[]" accept="image/*" max="2" multiple />
    <br/><br/>
    <input type="submit" name="submit" value="Upload" />
    </form>  
    <?php
		print_r($_FILES);
		if(isset($_POST['submit']))
		{
			/*
			if(getimagesize($_FILES['image']['tmp_name'])==FALSE)
			{
				echo"Please select an image";
			}
			*/
			if(isset($_FILES['image'])){			
					foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
					$image=addslashes($_FILES['image']['tmp_name'][$key]);
					$name=addslashes($_FILES['image']['name'][$key]);
					$image=file_get_contents($image);
					$image=base64_encode($image);
					saveimage($name,$image);
				    }
			 }
		}
		displayimage();
		function saveimage($name,$image)
		{
			try{
			$con=new PDO("mysql:dbname=mygreen;host=us-cdbr-azure-west-b.cleardb.com","b6961e47d29df6","302a1307");
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result=$con->query("insert into image (name,image,review_id) values('$name','$image','1')");
			if($result)
			{
				echo'<br/>image uploaded.';
			}
			else
			{
				echo'<br/>image not uploaded.';
			}
			}
			catch(PDOException $ex){
				?>
                <p>(Error details:<em><?=$ex->getMessage?></em>)</p>
                <?php				
			}			
		}
		function displayimage()
		{
			try{
			$con=new PDO("mysql:dbname=mygreen;host=us-cdbr-azure-west-b.cleardb.com","b6961e47d29df6","302a1307");
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result=$con->query("select * from image");
				foreach($result as $row)
				{
					echo'<img height="300" width="300" src="data:image;base64,'.$row[2].'"> ';
				}				
			}
			catch(PDOException $ex){
				?>
                <p>(Error details:<em><?=$ex->getMessage?></em>)</p>
                <?php				
			}			
		}
				
	?>
    </body>
</html>