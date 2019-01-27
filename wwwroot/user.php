<?php 
if(!isset($_SESSION)) {session_start();}

include("top_1113bootest.php");

$token_user=md5(uniqid(rand(),TRUE));
$_SESSION["token_user"]=$token_user;

 if(isset($_SESSION["name"])) {?>
	
    <div class="container">
            <h3> User Status </h3>
            <p> You are logged in as <?=$_SESSION["name"] ?>.</p>
            
            <form id="logout" action="logout.php" method="post">
            	<!--<input type="submit" value="Log out" />-->
                <button type="submit" class="btn btn-default btn-sm">Log out</button>
                <input type="hidden" name="logout" value="true"/>
            </form>
    </div>
    
    <?php } else{?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                	<h3>Log in</h3>
                    <!--<form id="login" action="login.php" method="post" role="form">
                        <form id="login" action="login.php" method="post" role="form">
                        <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control input-sm" id="email" size="32">
                        </div> 
                    	<dl>
                        	<dt>Email Address</dt>		<dd><input type="text" name="email" /></dd>
                            
                            <dt>Password</dt>	<dd><input type="password" name="password" /></dd>
                            <dt> </dt>			<dd><input type="submit" value="Log in" /></dd>
                            <input type="hidden" name="token_user" value="<?=$token_user?>"/>
                        </dl>
                    </form>
                    -->

                    <form id="login" action="login.php" method="post" role="form">
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control input-sm" id="email" name="email">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Password</label>
                            <input type="password" class="form-control input-sm" id="pwd" name="password">
                          </div>
                          
                          <button type="submit" class="btn btn-default btn-sm">Log in</button>
                          <input type="hidden" name="token_user" value="<?=$token_user?>"/>
                    </form>
                    <br>
            </div>
        </div>
    </div>
    
    <div class="container">           
            <p>No account? Please <a href="signup.php">sign up!</a></p>
            <p><a href="forget.php">Forget Password</a></p>            
    </div>
    <br><br><br>
<?php } 

    include("footer.php");
    include("bottom_boo.php");
?>