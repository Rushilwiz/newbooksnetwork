<?php

if(!isset($_SESSION))
{
   session_start();
}

if (isset($_POST['submit'])) {
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';

    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id = $_SESSION['userId'];

    require 'db.inc.php';
    $sql = "UPDATE users SET uidUsers = ? WHERE idUsers = ".$id;
    $stmt = mysqli_stmt_init($conn);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('Location: ../profile.php?error=invalidemail');
      exit();
    }

    elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
         header("Location: ../profile.php?error=firstname");
         exit();
    }

    elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
         header("Location: ../profile.php?error=lastname");
         exit();
    }

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('Location: ../profile.php?error=sqlerror');
      exit();
      echo 'emailerrro\n';
    } else {
      mysqli_stmt_bind_param($stmt, 's', $email);
      mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE users SET firstUsers = ? WHERE idUsers = ".$id;
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('Location: ../profile.php?error=sqlerror');
      exit();
      echo 'firstnameerror\n';
    } else {
      mysqli_stmt_bind_param($stmt, 's', $firstname);
      mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE users SET lastUsers = ? WHERE idUsers = ".$id;
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('Location: ../profile.php?error=sqlerror');
      exit();
      echo 'lastnameerror';
    } else {
      mysqli_stmt_bind_param($stmt, 's', $lastname);
      mysqli_stmt_execute($stmt);
    }

    $_SESSION['uidUsers'] = $email;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;

    header("Location: ../profile.php?email=".$email."&firstname=".$firstname."&lastname=".$lastname);
    exit();

} else {
  header("Location: ../index.php");
}
