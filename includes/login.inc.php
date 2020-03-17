<?php

if (isset($_POST['login-submit'])) {

    require 'db.inc.php';

    $uid = $_POST['uid'];
    $password = $_POST['pwd'];

    $sql = "SELECT uidUsers FROM newusers WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=sqlerror");
        exit();
    } else {
              mysqli_stmt_bind_param($stmt, "s", $uid);
              mysqli_stmt_execute($stmt);
              mysqli_stmt_store_result($stmt);
              $resultCheck = mysqli_stmt_num_rows($stmt);
              if ($resultCheck > 0) {
                   header("Location: ../create/index.php?original=".$uid);
                   exit();
              }

    else {

         if (empty($uid) || empty($password)) {
              header("Location: ../login.php?error=emptyfields");
              exit();
         }

         else {
              $sql = "SELECT * FROM users WHERE uidUsers=?;";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                   header("Location: ../login.php?error=sqlerror");
                   exit();
              } else {
                   mysqli_stmt_bind_param($stmt, "s", $uid);
                   mysqli_stmt_execute($stmt);
                   $result = mysqli_stmt_get_result($stmt);

                   if ($row = mysqli_fetch_assoc($result)) {
                        $pwdCheck = password_verify($password, $row['pwdUsers']);
                        if ($pwdCheck == false) {
                             header("Location: ../login.php?error=wrongpwd");
                             exit();
                        }

                        elseif ($pwdCheck == true) {

                             if(!isset($_SESSION)) {
                                session_start();
                             }

                             $_SESSION['permissions'] = json_decode($row['permissionUsers']);
                             $_SESSION['userId'] = $row['idUsers'];
                             $_SESSION['userUid'] = $row['uidUsers'];
                             $_SESSION['firstname'] = $row['firstUsers'];
                             $_SESSION['lastname'] = $row['lastUsers'];

                             header("Location: ../host");
                             exit();

                        }

                        else {
                             header("Location: ../login.php?error=wrongpwd");
                             exit();
                        }
                   }

                   else {
                        header("Location: ../login.php?error=nouser");
                        exit();
                   }
              }

         }
    }
}
}

else {
     header("Location: ../login.php");
     exit();
}
