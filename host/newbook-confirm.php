<?php
     require "header.php"
?>
          <div class="login-page">
               <div class="form">
                    <form class="login-form" action="includes/create-book.inc.php" method="post">
                         <h3>Please confirm that this information is correct.</h3>
                        <?php
                            require 'includes/db.inc.php';

                            if (isset($_POST['submit'])) {
                                $title = $_POST['title'];
                                $author = $_POST['author'];
                                $isbn = $_POST['isbn'];
                                $publisher = $_POST['publisher'];
                                $publishingDate = $_POST['date'];
                                $channel = $_POST['channel'];

                                $permissions = $_SESSION['permissions'];
                                $select = "<select required name='channel'>";

                                foreach($permissions as $channelID) {
                                  $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT channelName FROM channels WHERE channelID = ".$channelID.""));
                                  $channelName = $row['channelName'];

                                  if ($channel == $channelID) {
                                    $string = "<option selected value='".$channelID."'>".$channelName."</option>";
                                  } else {
                                    $string = "<option value='".$channelID."'>".$channelName."</option>";
                                  }

                                  $select = $select.$string;
                                }

                                $select = $select."</select>";

                                echo "'<input required name='title' placeholder='Title' value='".$title."'>
                                <input required name='author' placeholder='Author' value='".$author."'>
                                <input required type='number' name='isbn' placeholder='ISBN' value='".$isbn."'>
                                <input required name='publisher' placeholder='Publisher' value='".$publisher."'>
                                <input required name='date' placeholder='Publishing Date/Year' value='".$publishingDate."'>'".$select;
                             } else {
                                header('Location: newbook.php');
                            }
                        ?>
                         <button type="submit" name="submit">submit</button>
                    </form>
               </div>
          </div>
<?php
     require "footer.php"
?>
