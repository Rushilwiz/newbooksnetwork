<?php

if (isset($_POST['newuser-submit'])) {

    require 'db.inc.php';

    $uid = $_POST['uid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $permissions = $_POST['permissions'];
    $original = $_POST['original'];
    $pwd = $_POST['pwd'];
    $verifypwd = $_POST['verify-password'];

    if (!filter_var($uid, FILTER_VALIDATE_EMAIL)) {
          header("Location: ../index.php?error=invaliduid&original=".$original."&uid=&firstname=".$firstname."&lastname=".$lastname);
         exit();
    }

    elseif (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
         header("Location: ../index.php?error=firstname&original=".$original."&firstname=&uid=".$uid."&lastname=".$lastname);
         exit();
    }

    elseif (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
         header("Location: ../index.php?error=lastname&original=".$original."&lastname=&uid=".$uid."&firstname=".$firstname);
         exit();
    }

    elseif ($pwd !== $verifypwd) {
         header("Location: ../index.php?error=passwordcheck&original=".$original."&uid=".$uid."&firstname=".$firstname."&lastname=".$lastname);
         exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror&original=".$original);
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 's', $uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../index.php?error=duplicate&original=".$original);
                exit();
            } else {
                $sql = "INSERT INTO users (uidUsers, firstUsers, lastUsers, pwdUsers, permissionUsers) VALUES (?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror&original=".$original);
                    exit();
                } else {
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, 'sssss', $uid, $firstname, $lastname, $hashedPwd, $permissions);
                    mysqli_stmt_execute($stmt);

                    $sql = "DELETE FROM newusers WHERE uidUsers = ?";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../login.php?error=sqlerror&original=".$original);
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, 's', $original);
                        mysqli_stmt_execute($stmt);

                        header("Location: ../page2.php?permissions=".$permissions."&firstname=".$firstname);
                    }
                }
            }

        }

    }
} else {
    header("Location: ../../login.php");
    exit();
}
