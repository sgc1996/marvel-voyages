<?php
//index.php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

error_reporting(0);
$msg='';

if (isset($_POST['submit'])) {
$message = '
  <h3 align="center">New Inquiry Details</h3>
  <table border="1" width="100%" cellpadding="5" cellspacing="5">
   <tr>
    <td width="30%">Name</td>
    <td width="70%">'.$_POST["name"].'</td>
   </tr>
   <tr>
    <td width="30%">Email Address</td>
    <td width="70%">'.$_POST["email"].'</td>
   </tr>
   <tr>
    <td width="30%">Phone NNumber</td>
    <td width="70%">'.$_POST["phone"].'</td>
   </tr>
   <tr>
    <td width="30%">Message</td>
    <td width="70%">'.$_POST["message"].'</td>
   </tr>
  </table>
 ';


   $secretKey = "6LcLRlUqAAAAAMqu1pyIML5oNLxFnKobDvF0Wyhn";
   $responseKey = $_POST['g-recaptcha-response'];

   $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";

   $response = file_get_contents($url);
   $response = json_decode($response);

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    $mail = new PHPMailer;
    $mail->IsSMTP();        //Sets Mailer to send message using SMTP
    $mail->Host = 'mail.marvelvoyages.lk';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = '465';        //Sets the default SMTP server port
    $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'webmail@marvelvoyages.lk';     //Sets SMTP username
    $mail->Password = 'iiuWF%.Z_8WW';     //Sets SMTP password
    $mail->SMTPSecure = 'ssl';       //Sets connection prefix. Options are "", "ssl" or "tls"
    $mail->From = $_POST["email"];     //Sets the From email address for the message
    $mail->FromName = $_POST["name"];    //Sets the From name of the message
    //$mail->AddAddress('contact@itechs.lk', 'Marvel Voyages'); //Adds a "To" address
    $mail->AddAddress('gayanc@aitech.lk', 'Marvel Voyages'); //Adds a "To" address
    $mail->AddAddress('gayanchathuranga1992@gmail.com', 'Marvel Voyages'); //Adds a "To" address
    //$mail->AddAddress('ameshm@aitech.lk', 'Marvel Voyages'); //Adds a "To" address
    $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
    $mail->IsHTML(true);       //Sets message type to HTML
    // $mail->AddAttachment($path);     //Adds an attachment from a path on the filesystem
    $mail->Subject = $_POST["subject"];    //Sets the Subject of the message
    $mail->Body = $message;       //An HTML or plain text message body

   if ($response->success) {
      if ($mail->Send()) {
         $msg='<div class="alert alert-success" style="text-align: center;">Email Sent Successfully</div>';
      }
      else{
         $msg='<div class="alert alert-danger" style="text-align: center;">Failed to send the message</div>';
      }
   }
   else{
      $msg='<div class="alert alert-danger" style="text-align: center;">Verification failed</div>';
   }
}

?>