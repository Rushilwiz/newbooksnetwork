<?php
    require 'header.php'
?>
    <div class='page'>
             <div style="margin-top: 25px;">
                  <ul class="navbar">
                      <li><a class="navlink" href="channels.php">My Channels</a></li>
                      <li><a class="navlink active" href="newbook.php">New Book</a></li>
                      <li><a class="navlink" href="index.php">Home</a></li>
                      <li><a class="navlink" href="profile.php">Profile</a></li>
                      <li><a class="navlink" href="help.php">Help</a></li>
                      <li><a class="navlink" href="../includes/logout.inc.php">Logout</a></li>
                  </ul>
             </div>


        <div style="background: #fff;">
            <h2 style="font-size: 300%; text-align: center;">Submitting a book?</h2>
            <?php
                 if(isset($_GET['error'])) {
                      $error = $_GET['error'];

                      if ($error == 'success') {
                           echo '<h2 style="color: green; text-align: center;">Success! Your book has been added to the database, check your homepage to see it.</h2>';
                      } elseif ($error == 'duplicate') {
                           echo '<h2 style="color: red; text-align: center;">Looks like someone else is already working on this book, sorry about that. Please contact Marshall Poe if this seems to be an error.</h2>';
                      } elseif ($error == 'sqlerror') {
                          echo '<h2 style="color: red; text-align: center;">There seems to be an error with your request, please try again later.</h2>';
                      }
                 }
            ?>
            <div class="newbook-form">
                <h2 style="margin-bottom: 0;">Enter an ISBN below</h2>
                <h6 style="margin-top: 0;">It'll autofill the form below.</h6>
                <form class="form" method="post" action="">
                    <input type="number" name="isbn-fetch" placeholder="Enter the ISBN here">
                    <button type="submit" name="submit-isbn">Search</button>
                </form>
                <img src="css/res/or.png" style="width: 100%; margin-top: 20px;">
            </div>
            <div class="newbook-form">
                <h2 style="text-align: right;">Enter it manually here</h2>
                <?php
                    error_reporting(0);
                    require 'includes/db.inc.php';

                    $permissions = $_SESSION['permissions'];

                    $select = "<select required name='channel'><option selected='true' disabled='true' value=''>Pick a Channel</option>";



                    foreach($permissions as $channelID) {
                      $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT channelName FROM channels WHERE channelID = ".$channelID.""));
                      $channelName = $row['channelName'];

                      $string = "<option value='".$channelID."'>".$channelName."</option>";
                      $select = $select.$string;
                    }

                      $select = $select."</select>";


                    if (isset($_POST['submit-isbn'])) {
                        $isbn = $_POST['isbn-fetch'];
                        $isbnLen = mb_strlen($isbn);
                        if(!empty($isbn) && ($isbnLen == 10 || $isbnLen == 13)) {
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn);
                            $result = curl_exec($ch);
                            curl_close($ch);

                            $obj = json_decode($result, true);
                            $title=$obj['items'][0]['volumeInfo']['title'];
                            $author=$obj['items'][0]['volumeInfo']['authors'][0];
                            $publisher=$obj['items'][0]['volumeInfo']['publisher'];
                            $publishingDate=$obj['items'][0]['volumeInfo']['publishedDate'];

                            echo "<form class='form' method='post' action='newbook-confirm.php'>
                                <input required name='title' placeholder='Title' value='".$title."'>
                                <input required name='author' placeholder='Author' value='".$author."'>
                                <input required type='number' name='isbn' placeholder='ISBN' value='".$isbn."'>
                                <input required name='publisher' placeholder='Publisher' value='".$publisher."'>
                                <input required name='date' placeholder='Publishing Date/Year' value='".$publishingDate."'>
                                ".$select."
                                <button name='submit' type='submit' style='margin-bottom: 25px;'>Submit</button>
                            </form>";

                        } else {
                            echo "<form class='form' method='post' action='newbook-confirm.php'>
                                <input required name='title' placeholder='Title'>
                                <input required name='author' placeholder='Author'>
                                <input required type='number' name='isbn' placeholder='ISBN'>
                                <input required name='publisher' placeholder='Publisher'>
                                <input required name='date' placeholder='Publishing Date/Year'>
                                ".$select."
                                <button name='submit' type='submit' style='margin-bottom: 25px;'>Submit</button>
                            </form>";
                        }
                    } else {
                        echo "<form class='form' method='post' action='newbook-confirm.php'>
                            <input required name='title' placeholder='Title'>
                            <input required name='author' placeholder='Author'>
                            <input required type='number' name='isbn' placeholder='ISBN'>
                            <input required name='publisher' placeholder='Publisher'>
                            <input required name='date' placeholder='Publishing Date/Year'>
                            ".$select."
                            <button name='submit' type='submit' style='margin-bottom: 25px;'>Submit</button>
                        </form>";
                    }
                ?>
        </div>
    </div>
<?php
    require 'footer.php'
?>
