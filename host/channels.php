<?php
     require 'header.php';
     require 'includes/db.inc.php';

?>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">



<div class='page' style="background:#fff; height: 100%; ">
    <div style="margin-top: 25px;">
        <ul class="navbar">
            <li><a class="navlink active" href="channels.php">My Channels</a></li>
            <li><a class="navlink" href="newbook.php">New Book</a></li>
            <li><a class="navlink" href="index.php">Home</a></li>
            <li><a class="navlink" href="profile.php">Profile</a></li>
            <li><a class="navlink" href="help.php">Help</a></li>
            <li><a class="navlink" href="../includes/logout.inc.php">Logout</a></li>
        </ul>
    </div>

    <div style="background: #fff; border: 20px #fff solid;">
        <?php
        $permissions = $_SESSION['permissions'];

        foreach($permissions as $channelID) {
            $query = "SELECT * FROM books WHERE bookChannel = ".$channelID." ORDER BY bookID DESC";
            $result = mysqli_query($conn, $query);
            $channelRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT channelName FROM channels WHERE channelID = ".$channelID.""));
            $tableData = "";
            while ($row = mysqli_fetch_array($result)) {
                $hostRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT firstUsers, lastUsers FROM users WHERE idUsers = ".$row['bookHost'].""));
                $tableData = $tableData."
                    <tr>
                        <td>".$row['bookTitle']."</td>
                        <td>".$row['bookAuthor']."</td>
                        <td>".$row['bookISBN']."</td>
                        <td>".$row['bookPublisher']."</td>
                        <td>".$row['bookDate']."</td>
                        <td>".$channelRow['channelName']."</td>
                        <td>".$hostRow['lastUsers'].", ".$hostRow['firstUsers']."</td>
                    </tr>
                ";
            }

            echo "
            <h1 style='margin-top:50px;'>".$channelRow['channelName']."</h1>
            <table id='".$channelID."-table' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Publisher</th>
                        <th>Publishing Date/Year</th>
                        <th>Channel</th>
                        <th>Host</th>
                    </tr>
                </thead>
                <tbody>
                    ".$tableData."
                 </tbody>
             </table>
            ";
        }
        ?>
     </div>
</div>
<script>
$(document).ready(function() {
    <?php
    foreach($permissions as $channelID) {
        echo "
        $('#".$channelID."-table').DataTable({
            'bLengthChange': false
        });
        ";
    }
    ?>
});
</script>
<?php
     require 'footer.php'
?>
