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
    $visitor->message = ($_POST["message"]);
    $visitor->visit_date = strftime("%Y-%m-%d %H:%M:%S", time());
    
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
            
                $subject = "Visitor Contact: {$visitor->subject}";
                $message = "Visitor {$visitor->name} has requested contact.<br /><br />The email provided was: {$visitor->email}<br /><br />Message: {$visitor->message}";
   
                $message = wordwrap($message, 70);

                //$from_name "Travis";
                $from = $visitor->email;

                $mail = new PHPMailer();

                $mail->IsSendmail(); // telling the class to use SendMail transport
                $mail->AddReplyTo($visitor->email,$visitor->name);
                $mail->SetFrom($visitor->email,$visitor->name);
                
                $address = "admin@surreyridge.co";
                $mail->AddAddress($address, "SRHOA Admin");

                $mail->Subject = $subject;
                $mail->MsgHTML($message);


                if(!$mail->Send()){
                    $contact_message = "Visitor contact was recorded successfully, but the mail send FAILED; you may want to retry sending this message again.";
                } else {
                    redirect_to('thank_you.php');
                }
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
    
    <div class="form-area">
        <?php echo output_message($contact_message); ?>
        <form role="form" action="contact_me.php" method="post" >
                    <h3 style="margin-bottom: 25px; text-align: center;">Contact Us</h3>

                    <div class="well well-sm">
                    <b>PLEASE REMEMBER</b>, our HOA Board is comprised of <i>&quot;working stiffs&quot;</i> who have volunteered their precious time away from family to serve the community.  We really encourage others to get to know our community, serve and love others within the community, and extend grace and patience to us that are serving. We will try to answer all of your questions in a timely manner, but we cannot guarantee a fast response.
                        <footer><h6>- Surrey Ridge HOA</h6></footer>
                    </div>
            
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
        
        <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
        </form>
    </div>
<!--</div>-->
<!--</div>-->
