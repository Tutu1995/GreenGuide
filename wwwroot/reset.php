<?php
if(!isset($_SESSION)) {session_start();}
include("top_1113bootest.php");
include("db.php");
 //include('db.php');
$passkey = htmlspecialchars($_GET["passkey"]);
$email = htmlspecialchars($_GET["email"]);

$token_reset = md5(uniqid(rand(),TRUE));
$_SESSION["token_reset"] = $token_reset; 

?>
	<br>
	<div class="container">
<?php
print_r($email);
 //echo $passkey;
 
 try{
			//$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
			//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$results=$db->query("UPDATE user SET com_code=NULL WHERE com_code='$passkey'");

			$results=$db->prepare("UPDATE user SET com_code=NULL WHERE com_code=:passkey");
			$results->bindParam(":passkey", $passkey);
			$results->execute();

			$count = $results->rowCount();
			//print("updated $count rows.\n");
		   if($count>0){
		   ?>
		   			<div class="row">
            			<div class="col-sm-6">
							<h3>Please reset your password. </h3>
								  <!--
								  <form action="change.php"	name="myForm" onsubmit="return validateForm()"	method="POST">
										  <dl>
								            	<dt>New Password:</dt>		<dd><input type="password" name="password" size="20" /></dd>
								                <dt>Confirm Password:</dt>	<dd><input type="password" name="confirmpassword" size="20" /></dd>
								                <input type="hidden" name="email" value="<?= $email ?>" />
								                <input type="hidden" name="token_reset" value="<?=$token_reset?>"/>
								                <dt> </dt>			<dd><input type="submit" name="ResetPasswordForm" value=" Reset Password " /></dd>
								          </dl>
								  </form>
								  -->
								  <form action="change.php"	name="myForm" onsubmit="return validateForm()"	method="POST" role="form">
			                          <div class="form-group">
			                            <label for="password">New Password:</label>
			                            <input type="password" class="form-control input-sm" name="password">
			                          </div>
			                          <div class="form-group">
			                            <label for="pwd">Confirm Password:</label>
			                            <input type="password" class="form-control input-sm" name="confirmpassword">
			                          </div>
			                          <input type="hidden" name="email" value="<?= $email ?>" />
			                          <input type="hidden" name="token_reset" value="<?=$token_reset?>"/>
			                          <button type="submit" class="btn btn-default btn-sm" name="ResetPasswordForm">Reset Password</button>
			                          
			                    </form>
			            </div>
        			</div>
		   <?php	
		   }
		   else{
			   echo "	Some error occur.";
		   }
	}
	catch(Exception $e){
		//die(print_r($e));
		die("Sorry. Error occurred. Please try again.");
	}

	?>
		</div>
		<br><br><br>
	<?php
 
  	include("footer.php");
  	include("bottom_boo.php");
?>


<script>
function validateForm() {
    var x = document.forms["myForm"]["password"].value;
    var y = document.forms["myForm"]["confirmpassword"].value;
    //alert(x);
    //alert(y);
    if (x != y) {
        alert("Your passwords do not match.");
        return false;
    }
}
</script>