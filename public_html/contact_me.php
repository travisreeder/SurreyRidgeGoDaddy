<?php
require_once("../sr_includes/initialize.php");

include_layout_template('header.php'); 
include_layout_template('navigation2.php');
$contact_message = "";
    
if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    //var_dump($_POST);
    //var_dump($_SESSION{"real"});
    $visitor = new Visitor();
    
    //$id = $visitor->id;
    $visitor->name = $database->escape_value($_POST["name"]);
    $visitor->email = $database->escape_value($_POST["email"]);
    $visitor->mobile = $database->escape_value($_POST["mobile"]);
    $visitor->subject = $database->escape_value($_POST["subject"]);
    $visitor->message = $database->escape_value($_POST["message"]);
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($database->escape_value($_POST["captcha"]) == $_SESSION{"real"}) {
        if($visitor->save()) {
                // Success
                // send email notice
                $time = strftime("%H:%M:%S",time());
            
                $subject = "Visitor requested contact at {$time}";
                $message ="Visitor '{$visitor->name}' has requested contact; the email provided was: {$visitor->email} with the following message: ".$visitor->message;
   
                $message = wordwrap($message, 70);

                //$from_name "Travis";
                $from = $visitor->email;

                $mail = new PHPMailer();

                $mail->IsSendmail(); // telling the class to use SendMail transport
                $mail->AddReplyTo("surreyridgehoa@gmail.com","Surrey Ridge HOA");
                $mail->SetFrom($visitor->email,$visitor->name);
                $address = "travis@travisreeder.com";
                $mail->AddAddress($address, "Travis Reeder");

                $mail->Subject = $subject;
                $mail->MsgHTML($message);


                $result = $mail->Send();
                echo $result ? 'Sent' : 'Error';
            
                redirect_to('thank_you.php');
            } else {
                // Failure
                echo "Failure...";
                $contact_message = "Oops, something failed; try again";
                //redirect_to("contact_me.php");
            }
    } else {
        $contact_message = "Captcha doesn't match!";
        //$redirect_url = 'view_content.php?subject=8';
        //var_dump($redirect_url);
        //redirect_to($redirect_url);
    }
}
?>

<!--<div class="container-fluid" id="container">-->
<!--    <div class="display_content col-md-5">-->
    
    <div class="form-area col-md-5">
        <?php echo "<p class=\"message\">{$contact_message}</p>"; ?>
        <form role="form" action="contact_me.php" method="post" >
                    <h3 style="margin-bottom: 25px; text-align: center;">Contact Us</h3>

                    <div class="form-group">
						<input type="text" class="form-control" name="name" placeholder="Name" required value="<?php echo isset($_POST['name']) ? $_POST['name'] : ""; ?>" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ""; ?>" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : ""; ?>" />
					</div>
                    <div class="form-group">
                    <textarea class="form-control" type="textarea" id="message" name="message" placeholder="Message" maxlength="250" rows="7"><?php echo isset($_POST['message']) ? $_POST['message'] : ""; ?></textarea>
                        <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>                    
                    </div>
                    <div class="form-group">
                        <label for="captcha" class="required"><img src="captcha.php"></label>&nbsp;<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter Captcha from above" required>
                    </div>
        
        <input class="btn btn-primary pull-right" type="submit" name="submit" value="Submit" />
        </form>
    </div>
<!--</div>-->
<!--</div>-->
