<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_subject = Subject::find_selected_subject(false);
//$current_page = Page::find_selected_page(false);

//var_dump($current_page);

include_layout_template('header3.php');
include_layout_template('admin_navigation.php');

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    $subject = new Subject();
    
    $subject->menu_name = $_POST["menu_name"];    
    $subject->position = (int) $_POST["position"];
    $subject->visible = (int) $_POST["visible"];
    $subject->url = $_POST["url"];
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($subject->save()) {
            // Success
            $session->message("Subject created successfully.");
            redirect_to('manage_content.php?nav=1');
        } else {
            // Failure
            $session->message("Subject creation failed.");
            redirect_to("new_subject.php?nav=1");
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
                <h2>Create Subject</h2>
            </div>
        </div>

        <form class="form-horizontal" action="new_subject.php?nav=1" method="post">
            <div class="form-group">
                <label class="col-xs-12" for="manu_name">Menu Name:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="menu_name" value = ""/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="position">Position:</label>
                <div class="col-xs-12">
                    <select class="form-control input-sm" name="position">
                    <?php
                        $subject_count = Subject::count_all();
                        for($count=1; $count <= $subject_count + 1; $count++) {
                            echo "<option value=\"{$count}\"";
                            if ($count == $subject_count + 1) {
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
                        <input type="radio" name="visible" value="0"> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="1" checked> Yes
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="url">URL:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="url" value = ""/>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-xs-12" >
                    <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                    <a class="btn btn-info" href="manage_content.php?nav=1">Cancel</a>
                </div>
            </div>
        </form>
                

        
    </div> <!-- End display_content -->
</div> <!-- End container -->


<?php include_layout_template('footer2.php');  ?>  