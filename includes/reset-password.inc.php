<?php
if(isset($_POST['reset-submit'])) {
     
     $selector = $_POST['selector'];
     $validator = $_POST['validator'];
     $pwd = $_POST['pwd'];
     $verify_pwd = $_POST['verify-pwd'];
     
     if (empty($pwd) || empty($verify_pwd)) {
          header('Location: ../create-new-password.php?newpwd=empty');
          exit();
     } else if ($pwd != $verify_pwd) {
          header('Location: ../create-new-password.php?newpwd=passwordmatch');
          exit();
     }
     
     $currentDate = date('U');
     
     require 'db.inc.php';
     
     $sql = 'SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?';
     
     $stmt = mysqli_stmt_init($conn);
     
     if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../create-new-password.php?newpwd=sqlerror");
          exit();
     } else {
          mysqli_stmt_bind_param($stmt, 'ss', $selector, $currentDate);
          mysqli_execute($stmt);
          
          $result = mysqli_stmt_get_result($stmt);
          
          if  (!$row = mysqli_fetch_assoc($result)) {
               header("Location: ../create-new-password.php?newpwd=sqlerror");
               exit();
          } else {
               $tokenBin = hex2bin($validator);
               $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);
               
               if ($tokenCheck == false) {
                    header("Location: ../create-new-password.php?newpwd=sqlerror");
                    exit();
               } else if ($tokenCheck == true) {
                    $tokenEmail = $row['pwdResetEmail'];
                    
                    $sql = 'SELECT * FROM users WHERE uidUsers=?';
                    
                    $stmt = mysqli_stmt_init($conn);
     
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                         header("Location: ../create-new-password.php?newpwd=sqlerror");
                         exit();
                    } else {
                         mysqli_stmt_bind_param($stmt, 's', $tokenEmail);
                         mysqli_execute($stmt);
                         
                         $result = mysqli_stmt_get_result($stmt);
          
                         if  (!$row = mysqli_fetch_assoc($result)) {
                              header("Location: ../create-new-password.php?newpwd=sqlerror");
                              exit();
                         } else {
                              
                              $sql = 'UPDATE users SET pwdUsers=? WHERE uidUsers=?';
                              
                              $stmt = mysqli_stmt_init($conn);
     
                              if (!mysqli_stmt_prepare($stmt, $sql)) {
                                   header("Location: ../create-new-password.php?newpwd=sqlerror");
                                   exit();
                              } else {
                                   $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                                   
                                   mysqli_stmt_bind_param($stmt, 'ss', $hashedPwd, $tokenEmail);
                                   mysqli_execute($stmt);
                              
                                   $sql = 'DELETE FROM pwdReset WHERE pwdResetEmail=?';
                                   
                                   $stmt = mysqli_stmt_init($conn);
     
                                   if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        header("Location: ../create-new-password.php?newpwd=sqlerror");
                                        exit();
                                   } else {
                                        mysqli_stmt_bind_param($stmt, 's', $tokenEmail);
                                        mysqli_execute($stmt);
                                        header("Location: ../create-new-password.php?newpwd=success");
                                        
                                   }
                              }
                         }
                    }
               }
          }
     }
     
} else {
     header('Location: ../index.php');
}