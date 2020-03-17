<?php
     require "header.php"
?>
          <div class="login-page">
               <div class="form">
                    <form class="login-form" action="includes/login.inc.php" method="post">
                         <?php 
                              if(isset($_GET['error'])) {
                                   $error = $_GET['error'];
                                   
                                   if ($error == 'emptyfields') {
                                        echo '<p style="color: red;">Please fill in all fields!</p>';
                                   } elseif ($error == 'wrongpwd') {
                                        echo '<p style="color: red;">That password is incorrect</p>';
                                   } elseif ($error == 'nouser') {
                                        echo "<p style='color: red;'>That user does not exist! Click <a href='signup.php'>here</a> to signup!</p>";
                                   } elseif ($error == 'nologin') {
                                        echo "<p style='color: red;'>You don't seem to be logged in, please try again below. If the problem persists please contact marshallpoe@gmail.com</p>";
                                   }
                              }
                         ?>
                         <h3>Login to the NBN Database</h3>
                         <input name="uid" type="text" placeholder="email" />
                         <input name="pwd" type="password" placeholder="password" />
                         <button type="submit" name="login-submit">login</button>
                         <p class="message"><a href="reset-password.php">Forgot Password?</a></p>
                    </form>
               </div>
          </div>
<?php
     require "footer.php"
?>