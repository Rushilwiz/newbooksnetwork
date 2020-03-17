<?php
     require "../header.php";
     require 'includes/db.inc.php';

     if (isset($_GET['firstname']) and isset($_GET['permissions'])) {
        $firstname = $_GET['firstname'];

        $permissions = explode(',',substr($_GET['permissions'], 1, -1));
        $permissionString = '';
        $index = 1;

        foreach ($permissions as $channel) {
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT channelName FROM channels WHERE channelID = ".$channel.""));
            $channelName = $row['channelName'].", ";

            if(count($permissions) == 2) {
                if ($index == 1) {
                    $channelName = substr($channelName, 0, -2). " ";
                }
            }
            if ((count($permissions) == $index) and (count($permissions) != 1)) {
                $channelName = "and ".$channelName;
            }
            $permissionString .= $channelName;
            $index++;
        }
        $permissionString = substr($permissionString, 0, -2);

     } else {
         header("Location: ../login.php");
         exit();
     }
?>
<div class="page2">
               <div class="form">
                    <form class="login-form" action="page3.php">
                         <h2>Great, <?php echo $firstname ?>! You're currently hosting <?php echo $permissionString ?>. If this is incorrect, please contact <a href="mailto:marshallpoe@gmail.com">marshallpoe@gmail.com.</a></h2>
                         <button>NEXT</button>
                    </form>
               </div>
          </div>
<?php
     require "../footer.php"
?>
