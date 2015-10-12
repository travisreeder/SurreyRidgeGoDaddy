<?php
//echo "Running search_kbco.php...<br />";
require_once("../includes/PHPMailer/class.phpmailer.php");
//echo "Done with require once PHPMailer/class.phpmailer.php...<br />";
require_once("../includes/PHPMailer/class.smtp.php");
//echo "Done with require once PHPMailer/class.smtp.php...<br />";
require_once("../includes/PHPMailer/PHPMailerAutoload.php");
//echo "Done with require once PHPMailer/PHPMailerAutoload.php...<br />";
require_once("../includes/functions.php");
//echo "Done with require once functions.php...<br />";

$url = "http://www.kbco.com/pages/lookforyourname.html";
$page = file_get_contents($url);
$find_string = "Travis Reeder";
$pos = strpos($page, $find_string);

$to_name = "Travis Reeder";
$to = "travisreeder@msn.com";
$time = strftime("%H:%M:%S",time());

//echo "Time is: ".$time."<br />";



if($pos === false) {
    $subject = "Search KBCO at {$time}: NO LUCK!";
    $message ="NO LUCK: '{$find_string}' was not found on KBCO look for your name";
    // Optional: Wrap lines for old email programs
    // Wrap at 70/72/75/78

    $message = wordwrap($message, 70);

    //$from_name "Travis";
    $from = "traviswreeder@gmail.com";

    $mail = new PHPMailer();

    $mail->IsSendmail(); // telling the class to use SendMail transport
    $mail->AddReplyTo("travisreeder@msn.com","Travis Reeder");
    $mail->SetFrom('traviswreeder@gmail.com','Travis Reeder');
    $address = "travisreeder@msn.com";
    $mail->AddAddress($address, "Travis Reeder");
    
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    
    
    //$mail->IsSMTP();
    //$mail->Host = "smtp.gmail.com";
    //$mail->Port = 587;
    //$mail->SMTPAuth = true;
    //$mail->Username = "traviswreeder@gmail.com";
    //$mail->Password = get_gmail_password();

    //$mail->FromName = 'Travis Reeder';
    //$mail->From = $from;
    //$mail->AddAddress($to, $to_name);
    //$mail->Subject = $subject;
    //$mail->Body = $message;


    $result = $mail->Send();
    echo $result ? 'Sent<br />' : 'Error sending mail - no luck<br />'.$mail->ErrorInfo;;
    //echo "NO LUCK: '{$find_string}' was not found on KBCO look for your name";
} else {
    $subject = "Search KBCO at {$time}: YEAH BABY!!";

    //echo $subject;

    $message ="YEAH BABY!! '{$find_string}' was found on KBCO look for your name!!";
    // Optional: Wrap lines for old email programs
    // Wrap at 70/72/75/78

    $message = wordwrap($message, 70);

    //$from_name "Travis";
    $from = "traviswreeder@gmail.com";

    $mail = new PHPMailer();

    $mail->IsSendmail(); // telling the class to use SendMail transport
    $mail->AddReplyTo("travisreeder@msn.com","Travis Reeder");
    $mail->SetFrom('traviswreeder@gmail.com','Travis Reeder');
    $address = "travisreeder@msn.com";
    $mail->AddAddress($address, "Travis Reeder");
    
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    
    //$mail->IsSMTP();
    //$mail->Host = "smtp.gmail.com";
    //$mail->Port = 587;
    //$mail->SMTPAuth = true;
    //$mail->Username = "traviswreeder@gmail.com";
    //$mail->Password = get_gmail_password();

    //$mail->FromName = 'Travis Reeder';
    //$mail->From = $from;
    //$mail->AddAddress($to, $to_name);
    //$mail->Subject = $subject;
    //$mail->Body = $message;


    $result = $mail->Send();
    echo $result ? 'Sent<br />' : 'Error sending mail - Yeah Baby<br />'.$mail->ErrorInfo;
    
    //echo "YEAH BABY!! '{$find_string}' was found on KBCO look for your name!!";
}

    
?>