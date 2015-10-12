<?php
require_once("../sr_includes/phpMailer/class.phpmailer.php");
require_once("../sr_includes/phpMailer/class.smtp.php");

$time = strftime("%H:%M:%S",time());
            
$subject = "Visitor requested contact at {$time}";
$message ="Visitor TEST has requested contact; the email provided was: TEST with the following message: TEST";
   
$message = wordwrap($message, 70);

//$from_name "Travis";
$from = "test@test.com";

$mail = new PHPMailer();

$mail->IsSendmail(); // telling the class to use SendMail transport
$mail->AddReplyTo("surreyridgehoa@gmail.com","Surrey Ridge HOA");
$mail->SetFrom($from,'Test User');
$address = "travis@travisreeder.com";
$mail->AddAddress($address, "Travis Reeder");

$mail->Subject = $subject;
$mail->MsgHTML($message);

$result = $mail->Send();
echo $result ? 'Sent' : 'Error';
?>