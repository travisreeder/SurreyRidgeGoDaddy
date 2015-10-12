<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_subject = Subject::find_selected_subject(false);

if(!$current_subject) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_content.php");
}

include_layout_template('header3.php');
include_layout_template('admin_navigation.php'); 

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
        
    $current_subject->menu_name = $_POST["menu_name"];    
    $current_subject->position = (int) $_POST["position"];
    $current_subject->visible = (int) $_POST["visible"];
    $current_subject->url = $_POST["url"];
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($current_subject->save()) {
            // Success
            $session->message("Subject updated successfully.");
            redirect_to("manage_content.php?subject={$current_subject->id}");
        } else {
            // Failure
            $session->message("Subject update failed.");
            redirect_to("edit_subject.php?nav=1");
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
                <h2>Edit Subject: <?php echo htmlentities($current_subject->menu_name); ?></h2>
            </div>
        </div>
            
        <form class="form-horizontal" action="edit_subject.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>" method="post">
            <div class="form-group">
                <label class="col-xs-12" for="manu_name">Menu Name:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="menu_name" value="<?php echo htmlentities($current_subject->menu_name); ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="position">Position:</label>
                <div class="col-xs-12">
                    <select class="form-control input-sm" name="position">
                        <?php
                            $subject_count = Subject::count_all();
                            for($count=1; $count <= $subject_count; $count++) {
                                echo "<option value=\"{$count}\"";
                                if ($current_subject->position == $count) {
                                    echo " selected";
                                }
                                echo ">{$count}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="visible">Visible:</label>

                <div class="col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="0"<?php if($current_subject->visible ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="1" <?php if($current_subject->visible ==1 ) { echo "checked"; } ?>/> Yes
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="url">URL:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="url" value="<?php echo htmlentities($current_subject->url); ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-xs-12" >
                    <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                    <a class="btn btn-info" href="manage_content.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>">Cancel</a>
                    <a class="btn btn-danger" href="delete_subject.php?subject=<?php echo urlencode($current_subject->id); ?>" onclick="return confirm('Are you sure?');">Delete subject</a>
                </div>
            </div>

        </form>    


    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  