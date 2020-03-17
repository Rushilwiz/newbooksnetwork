<?php
     require 'header.php';
     require 'includes/db.inc.php';
     $host = $_SESSION['userId'];
     $query = "SELECT * FROM books WHERE bookHost = ".$host." ORDER BY bookID DESC";
     $result = mysqli_query($conn, $query);
?>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">



<div class='main-page'>
     <div class="row-20">
          <div class="row-50">
               <?php
                         echo '<h1 class="header">NewBooksNetwork Database</h1>
                                <h2 class="subheader">Host: '.$_SESSION["firstname"].' '.$_SESSION["lastname"].'</h2>';
                    ?>
          </div>
          <div class="row-50">
               <ul class="navbar">
                    <li><a class="navlink" href="channels.php">My Channels</a></li>
                    <li><a class="navlink" href="newbook.php">New Book</a></li>
                    <li><a class="navlink active" href="index.php">Home</a></li>
                    <li><a class="navlink" href="profile.php">Profile</a></li>
                    <li><a class="navlink" href="help.php">Help</a></li>
                    <li><a class="navlink" href="../includes/logout.inc.php">Logout</a></li>
               </ul>
          </div>
     </div>

     <div style="height: 100vh;background: #fff">

              <div class="col-90" style="float: center; margin: 0 auto; background: #fff;">
                <table id="book-table" class="table table-striped table-bordered display">
                  <thead>
                      <tr>
                          <th>Title</th>
                          <th>Author</th>
                          <th>ISBN</th>
                          <th>Publisher</th>
                          <th>Publishing Date/Year</th>
                          <th>Channel</th>
                      </tr>
                  </thead>
                  <tbody
                    <?php
                        while($row = mysqli_fetch_array($result)) {
                            $channelRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT channelName FROM channels WHERE channelID = ".$row['bookChannel'].""));
                            echo "
                                <tr>
                                    <td>".$row['bookTitle']."</td>
                                    <td>".$row['bookAuthor']."</td>
                                    <td>".$row['bookISBN']."</td>
                                    <td>".$row['bookPublisher']."</td>
                                    <td>".$row['bookDate']."</td>
                                    <td>".$channelRow['channelName']."</td>
                                </tr>
                            ";
                        }
                     ?>
                  </tbody>
                </table>
            </div>

               <p class='main-notice' style="margin-top: 50px;">Welcome to the NBN forthcoming interview book database. Please enter books that you are DEFINITELY going to cover. Only enter books AFTER you have arranged the interviews with the authors. DO NOT include books that you eventually want to do. This database reflects only books actually in production. It is not a wish list.</p>

     </div>
</div>

<script>
    $(document).ready(function() {
        $("#book-table").DataTable({
            "bLengthChange": false
        });
    });
</script>
<?php
     require 'footer.php'
?>
