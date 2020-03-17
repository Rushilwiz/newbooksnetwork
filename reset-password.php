<?php
     require "header.php"
?>
          <div class="login-page">
               <div class="form">
                    <form class="login-form" action="includes/reset-request.inc.php" method="post">
                         <?php 
                              if(isset($_GET['reset'])) {
                                   if ('success' == $_GET['reset']) {
                                        echo '<p style="color: green;">The email has been sent! Please check your inbox.</p>';
                                   }     
                              }
          
                              if(isset($_GET['error'])) {
                                   $error = $_GET['error'];
                                       
                                   if ($error == 'emailerror') {
                                        echo '<p style="color: red;">There was a problem sending the email! Please try again</p>';
                                   } elseif ($error == 'sqlerror') {
                                        echo '<p style="color: red;">There was a server error! Please try again.</p>';
                                   }                              
                              }
                         ?>
                         <h1 style="margin-top: 0;">Forgot your password?</h1>
                         <p>An e-mail will be sent to you with instructions on how to reset your password</p>
                         <input type="text" name="email" placeholder="Enter your email address">
                         <button type="submit" name="reset-submit">Send Email</button>
                    </form>
               </div>
          </div>
<?php
     require "footer.php"
?>