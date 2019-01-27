<?php
if(!isset($_SESSION)) {session_start();}
include("top_1113bootest.php");

$token_forget = md5(uniqid(rand(),TRUE));
$_SESSION["token_forget"] = $token_forget; 

?>

	<!--
	<h2>Please enter your email:</h2>
        <form id="getp" action="getp.php" method="post">
        	<dl>
            	<dt>Email Address</dt>		<dd><input type="text" name="email" /></dd>
            	<input type="hidden" name="token_forget" value="<?=$token_forget?>"/>
                <dt> </dt>			<dd><input type="submit" value="Submit" /></dd>
            </dl>
        </form>
    -->

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                	<h3>Please enter your email:</h3>
                   

                    <form id="getp" action="getp.php" method="post" role="form">
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control input-sm" name="email">
                          </div>
                          <input type="hidden" name="token_forget" value="<?=$token_forget?>"/>
                          <button type="submit" class="btn btn-default btn-sm">Submit</button>
                    </form>
                    <br>
            </div>
        </div>
    </div>
 	<br><br><br>

<?php
include("footer.php");
include("bottom_boo.php");
?>