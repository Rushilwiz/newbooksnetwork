<?php
     require "header.php"
?>
          <div class="login-page">
               <div class="form">
                         <?php
                              if(isset($_GET['newpwd'])) {
                                   $newpwd = $_GET['newpwd'];
                                   if ($newpwd == 'sqlerror') {
                                        echo '<p style="color: red;">There was an error completing your request, please try again.</p>';
                                   } else if($newpwd == 'success') {
                                        echo '<p style="color: green;">Your password has been reset! Click <a href="/newbooksnetwork/login.php">here</a> to login.</p>';
                                   }

                              } else {
                                  $selector = $_GET['selector'];
                                  $validator = $_GET['validator'];
                                   if (empty($selector) || empty($validator)) {
                                        echo '<p style="color: red;">Your request could not be validated.</p>';
                                   } else {
                                        $selector = $_GET['selector'];
                                        $validator = $_GET['validator'];
                                        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                                             ?>
                                                  <form class="login-form" action="includes/reset-password.inc.php" method="post">
                                                       <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                                       <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                                       <input type="password" name="pwd" placeholder="new password">
                                                       <input type="password" name="verify-pwd" placeholder="verify password">
                                                       <button type="submit" name="reset-submit">submit</button>
                                                  </form>
                                             <?php
                                        }
                                   }
                              }
                         ?>
               </div>
          </div>
<?php
     require "header.php"
?>
