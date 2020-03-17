<?php
if(!isset($_SESSION))
{
   session_start();
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $publisher = $_POST['publisher'];
    $publishingDate = $_POST['date'];
    $channelID = $_POST['channel'];
    $host = $_SESSION['userId'];

    require 'db.inc.php';

    $sql = "SELECT * FROM books WHERE bookISBN = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $isbn);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 0) {
            $sql = "INSERT INTO books (bookTitle, bookAuthor, bookISBN, bookPublisher, bookDate, bookChannel, bookHost) VALUES (?,?,?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: ../newbook.php');
                exit();

            } else {
                mysqli_stmt_bind_param($stmt, 'ssissii', $title, $author, $isbn, $publisher, $publishingDate, $channelID, $host);
                mysqli_stmt_execute($stmt);
                header('Location: ../index.php?error=success');
            }
        } else {
            header('Location: ../newbook.php?error=duplicate');
            exit();
        }
    } else {
        header('Location: ../newbook.php?error=sqlerror');
        exit();
    }
} else {
    header('Location: ../index.php');
}
