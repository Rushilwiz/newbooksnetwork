<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['reset-submit'])) {

     $selector = bin2hex(random_bytes(8));
     $token = random_bytes(32);

     $url = 'http://localhost/newbooksnetwork/create-new-password.php?selector='.$selector.'&validator='.bin2hex($token);

     $expires = date('U') + 1800;

     require('db.inc.php');

     $userEmail = $_POST['email'];

     $sql = 'DELETE FROM pwdReset WHERE pwdResetEmail=?';
     $stmt = mysqli_stmt_init($conn);

     if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../reset-password.php?error=sqlerror");
     } else {
          mysqli_stmt_bind_param($stmt, 's', $userEmail);
          mysqli_execute($stmt);
     }

     $sql = "INSERT INTO pwdReset(pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";

     $stmt = mysqli_stmt_init($conn);

     if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../reset-password.php?error=sqlerror");
     } else {
          $hashed_token = password_hash($token, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, 'ssss', $userEmail, $selector, $hashed_token, $expires);
          mysqli_execute($stmt);

     }

     mysqli_stmt_close($stmt);
     mysqli_close($conn);

     $subject = "Reset your password for NewBooksNetwork";

     $msg = '<p>We have recieved your request for a password reset. The link to reset your password is below.';
     $msg .= "<p>Here is the password reset link:<br>";
     $msg .= '<a href ="' . $url . '">'.$url.'</a></p>';



     // Load Composer's autoloader
     require '../vendor/autoload.php';

     // Instantiation and passing `true` enables exceptions
     $account = 'rushilwiz@outlook.com';
     $password = '!Riya2011';
     $from = 'rushilwiz@outlook.com';
     $from_name = 'NewBooksNetwork';

     $mail = new PHPMailer();
     $mail->IsSMTP();
     $mail->CharSet = 'UTF-8';
     $mail->Host = "smtp.live.com";
     $mail->SMTPAuth= true;
     $mail->Port = 587;
     $mail->Username= $account;
     $mail->Password= $password;
     $mail->SMTPSecure = 'tls';
     $mail->From = $from;
     $mail->FromName= $from_name;
     $mail->isHTML(true);
     $mail->Subject = $subject;
     $mail->Body = $msg;
     $mail->addAddress($userEmail);

     if(!$mail->send()){
          header('Location: ../reset-password.php?error=emailerror');
     } else {
          header('Location: ../reset-password.php?reset=success');
     }

} else {
     header('Location: ../index.php');
}
