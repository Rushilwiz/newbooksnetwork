<?php
    require 'header.php';

    $email = $_SESSION['userUid'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    $emailHex = '#';
    $firstHex = '#';
    $lastHex = '#';

      foreach(array('r', 'g', 'b') as $color){
          $val = mt_rand(0, 255);
          $dechex = dechex($val);
          if(strlen($dechex) < 2){
              $dechex = "0" . $dechex;
          }
          $emailHex .= $dechex;
      }

      foreach(array('r', 'g', 'b') as $color){
          $val = mt_rand(0, 255);
          $dechex = dechex($val);
          if(strlen($dechex) < 2){
              $dechex = "0" . $dechex;
          }
          $firstHex .= $dechex;
      }

      foreach(array('r', 'g', 'b') as $color){
          $val = mt_rand(0, 255);
          $dechex = dechex($val);
          if(strlen($dechex) < 2){
              $dechex = "0" . $dechex;
          }
          $lastHex .= $dechex;
      }

?>
    <link href="https://fonts.googleapis.com/css?family=Courgette|Lora|Roboto+Mono&display=swap" rel="stylesheet">
    <div class='page'>
             <div style="margin-top: 25px;">
                  <ul class="navbar">
                      <li><a class="navlink" href="channels.php">My Channels</a></li>
                      <li><a class="navlink" href="newbook.php">New Book</a></li>
                      <li><a class="navlink" href="index.php">Home</a></li>
                      <li><a class="navlink active" href="profile.php">Profile</a></li>
                      <li><a class="navlink" href="help.php">Help</a></li>
                      <li><a class="navlink" href="../includes/logout.inc.php">Logout</a></li>
                  </ul>
             </div>


             <?php
                  if(isset($_GET['error'])) {
                       $error = $_GET['error'];

                       if ($error == 'invalidemail') {
                            echo '<h2 style="color: red; text-align: center;">Your email seems to be invalid, please try again</h2>';
                       } elseif ($error == 'duplicate') {
                            echo '<h2 style="color: red; text-align: center;">Looks like someone else is already working on this book, sorry about that. Please contact Marshall Poe if this seems to be an error.</h2>';
                       } elseif ($error == 'sqlerror') {
                           echo '<h2 style="color: red; text-align: center;">There seems to be an error with your request, please try again later.</h2>';
                       }
                  }
             ?>

        <div style="background: #fff;">
            <h1 style="font-size: 250%; text-align: center; font-weight: 400;">Getting a new look?</h1>
            <div class="newbook-form">
                  <h1 style="margin-bottom: 20px; font-weight: 300;"><span style="border-bottom: 2px #000 solid;">Your Profile</span></h1>
                    <div class="col-50" style="float:right">
                      <form id="profile-form" class="form" method="post" action="includes/update-profile.php">
                          <input required name="email" placeholder="email" value=<?php echo $email ?> style="border: 2px <?php echo $emailHex ?> solid;">
                          <input required name="firstname" placeholder="first name" value=<?php echo $firstname ?> style="border: 2px <?php echo $firstHex ?> solid; margin-top:20px">
                          <input required name="lastname" placeholder="last name" value=<?php echo $lastname ?> style="border: 2px <?php echo $lastHex ?> solid; margin-top:20px;">
                        </form>
                    </div>
                    <div class="col-50" style="float:left;">
                        <h1 style="margin-top:0; margin-bottom:5px; text-align: right; line-height: 45px;"><span style="font-family: 'Courgette'">email</span>&nbsp;&nbsp;&nbsp;<br><br><span style="font-family: 'Lora'">first name</span>&nbsp;&nbsp;&nbsp;<br><br><span <span style="font-family: 'Roboto Mono'">>last name</span>&nbsp;&nbsp;&nbsp;</h1>
                    </div>
                  <button style="" form="profile-form" type="submit" name="submit">apply</button>
        </div>
    </div>
<?php
    require 'footer.php';
?>
