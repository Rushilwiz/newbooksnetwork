<?php
     if(!isset($_SESSION))
    {
        session_start();
    }

     if(isset($_SESSION['userId'])) {
          header('Location: host');
     }

?>

<!DOCTYPE html>
<html>

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">

<head>
     <title>NewBooksNetwork Database</title>
     <link href="css/styles.css" type="text/css" rel="stylesheet">
</head>
     <body>
