<?php
     require "../header.php";
     require "includes/db.inc.php";
     if (isset($_GET['original'])) {
        $original = $_GET['original'];


        $sql = "SELECT * FROM newusers WHERE uidUsers = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $original);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $uid = $row['uidUsers'];
                $firstname = $row['firstUsers'];
                $lastname = $row['lastUsers'];
                $permissions = $row['permissionUsers'];
            } else {
                header("Location: ../login.php?error=sqlerror");
                exit();
            }
        } else {
            header("Location: ../login.php?error=sqlerror");
            exit();
        }

        if (isset($_GET['firstname'])) {
            $firstname = $_GET['firstname'];
        }

        if (isset($_GET['lastname'])) {
            $lastname = $_GET['lastname'];
        }

        if (isset($_GET['uid'])) {
            $uid = $_GET['uid'];
        }

     } else {
         header("Location: ../login.php");
     }


?>
          <div class="create-page">
               <div class="mid-33">
                    <h1 class="create-header">Welcome to the NewBooksNetwork Host Database! Your account is ready to be created, we just need a password. Also please verify that all of your information is correct as listed. You'll need your email and password to log yourself in.</h1>

                    <div class="login-page">
                         <div class="form">
                              <form class="login-form" action="includes/adduser.inc.php" method="post">
                                   <?php
                                        if(isset($_GET['error'])) {
                                             $error = $_GET['error'];

                                             if ($error == 'emptyfields') {
                                                  echo '<p style="color: red;">Please fill in all fields!</p>';
                                             }
                                        }
                                   ?>
                                   <input required name="uid" type="text" value="<?php echo $uid ?>" placeholder="email" />
                                   <input required name="original" type="hidden" value="<?php echo $original ?>">
                                   <input required name="firstname" type="text" value="<?php echo $firstname ?>" placeholder="first name" />
                                   <input required name="lastname" type="text" value="<?php echo $lastname ?>" placeholder="last name" />
                                   <input required name="permissions" type="hidden" value="<?php echo $permissions ?>" />
                                   <input required name="pwd" type="password" placeholder="password" />
                                   <input required name="verify-password" type="password" placeholder="verify password" />
                                   <button type="submit" name="newuser-submit">login</button>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
<?php
     require "../footer.php"
?>
