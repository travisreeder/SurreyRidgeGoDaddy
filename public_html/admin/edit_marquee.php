<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

$marquee_row1 = Marquee::find_by_id(1);
$marquee_row2 = Marquee::find_by_id(2);

include_layout_template('header3.php');
include_layout_template('admin_navigation.php'); 

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    
    $marquee_row1->marquee_text = $_POST["marquee_text1"];
    $marquee_row1->visible = (int) ($_POST["visible1"]);    
    
    $marquee_row2->marquee_text = $_POST["marquee_text2"];    
    $marquee_row2->visible = (int) ($_POST["visible2"]);
    
    $error_occurred = false;
    $error_message = "";
    
    if(!$marquee_row1->save()) {
        $error_occurred = true;
        $error_message = "Marquee information for row 1 update failed.";
    } 
    
    
    if(!$marquee_row2->save()) {
        if ($error_occurred) {
            $error_message .= "<br>Marquee information for row 2 update failed.";
        } else {
            $error_message = "Marquee information for row 2 update failed.";
        }
        $error_occurred = true;
    }
    
    if ($error_occurred) {
        $session->message($error_message);
        redirect_to("edit_marquee.php");
    } else {
        $session->message("Marquee information updated successfully.");
        redirect_to("edit_marquee.php");
    }
}
?>   

<div class="container-fluid" id="container">
    <div class="display_content">
        

        <div class="row">
            <div class="col-xs-12">
                <?php echo output_message($message); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h2>Edit Marquee</h2>
            </div>
            <div class="col-xs-12">
                <p>You can have up to two (2) lines of information being displayed in the marquee; if you want to hide the marquee set the both lines visible property to 'No'</p>
            </div>
        </div>
            
        <form class="form-horizontal" action="edit_marquee.php" method="post">
                        
            <div class="form-group">
                <label class="col-xs-12" for="marquee_text1">Marquee Line 1:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="marquee_text1" value="<?php echo $marquee_row1->marquee_text ?>"/>
                </div>
            </div>
                    
            <div class="form-group">
                <label class="col-xs-12" for="visible1">Marquee Line 1 Visible:</label>

                <div class="col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="visible1" value="0"<?php if($marquee_row1->visible ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible1" value="1" <?php if($marquee_row1->visible ==1 ) { echo "checked"; } ?>/> Yes
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="marquee_text2">Marquee Line 2:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="marquee_text2" value="<?php echo $marquee_row2->marquee_text ?>"/>
                </div>
            </div>
                    
            <div class="form-group">
                <label class="col-xs-12" for="visible1">Marquee Line 2 Visible:</label>

                <div class="col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="visible2" value="0"<?php if($marquee_row2->visible ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible2" value="1" <?php if($marquee_row2->visible ==1 ) { echo "checked"; } ?>/> Yes
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-xs-12" >
                    <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                    <a class="btn btn-info" href="manage_content.php">Cancel</a>
                </div>
            </div>

        </form>    


    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  