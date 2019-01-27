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
							<h3>请重设密码 </h3>
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
			                            <label for="password">新密码:</label>
			                            <input type="password" class="form-control input-sm" name="password">
			                          </div>
			                          <div class="form-group">
			                            <label for="pwd">确认密码:</label>
			                            <input type="password" class="form-control input-sm" name="confirmpassword">
			                          </div>
			                          <input type="hidden" name="email" value="<?= $email ?>" />
			                          <input type="hidden" name="token_reset" value="<?=$token_reset?>"/>
			                          <button type="submit" class="btn btn-default btn-sm" name="ResetPasswordForm">重设密码</button>
			                          
			                    </form>
			            </div>
        			</div>
		   <?php	
		   }
		   else{
			   echo "	错误发生";
		   }
	}
	catch(Exception $e){
		//die(print_r($e));
		die("很抱歉!错误发生，请重新尝试");
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
        alert("密码不一致");
        return false;
    }
}
</script>