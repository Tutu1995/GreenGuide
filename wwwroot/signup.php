<?php
if(!isset($_SESSION)) {session_start();}

include("top_1113bootest.php");

$token_signup = md5(uniqid(rand(),TRUE));
$_SESSION["token_signup"] = $token_signup; 
?>

<div class="container">
      <div class="row">
            <div class="col-sm-6">
                <h3>Sign Up</h3>
               
                       
                <?php 
                
                         //session_start();
                         if(isset($_SESSION['error']))
                         {
                          //echo '<p>'.$_SESSION['error']['email'].'</p>';
                          //echo '<p>'.$_SESSION['error']['password'].'</p>';
                            unset($_SESSION['error']);
                         }
                         
                ?>

                <!--
                      <div class="signup_form">
                              <form action="register.php" method="post" >
                                   <p>
                                        <label for="email">E-mail:</label>
                                        <input name="email" type="text" id="email" size="30"/>
                                   </p>
                                   <p>
                                        <label for="password">Password:</label>
                                        <input name="password" type="password" id="password" size="30"/>
                                   </p>
                                   <p>  <input type="hidden" name="token_signup" value="<?=$token_signup?>"/>
                                        <input name="submit" type="submit" value="Submit"/>
                                   </p>
                              </form>
                      </div>
                -->


                      <form action="register.php" method="post" role="form">
                          <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control input-sm" id="email" name="email">
                          </div>
                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control input-sm" id="password" name="password">
                          </div>
                          <input type="hidden" name="token_signup" value="<?=$token_signup?>"/>
                          <button type="submit" name="submit" class="btn btn-default btn-sm">Sign up</button>
                          
                    </form>
                    <br>                
            </div>
      </div>
</div>

<div class="container"> 
        <p><a href="user.php">Login</a></p>
</div>
<br><br><br>

<?php
  include("footer.php");
  include("bottom_boo.php");
?>
        