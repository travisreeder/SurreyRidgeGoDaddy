<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
include_layout_template('header3.php');
include_layout_template('admin_navigation.php');

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    $list = new DescriptionList();
    
    $list->list_name = $_POST["list_name"];
    $list->short_col_description = $database->escape_value($_POST["short_col_description"]);
    $list->long_col_description = $database->escape_value($_POST["long_col_description"]); 
        
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($list->save()) {
            // Success
            $session->message("List created successfully.");
            redirect_to('manage_desclists.php?nav=5&selected_list='.urlencode($list->id));
        } else {
            // Failure
            //echo "Failure...";
            $session->message("List creation failed.");
            redirect_to("new_desclist.php?nav=5");
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
                <h2>Create New List</h2>
            </div>
        </div>

            <form class="form-horizontal" action="new_desclist.php?nav=5" method="post">
                <div class="form-group">
                <label class="col-xs-12" for="list_name">List Name:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="list_name" value = ""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="short_col_description">Short Column Description:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="short_col_description" value=""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="long_col_description">Long Column Description:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="long_col_description" value=""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-12" >
                        <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                        <a class="btn btn-info" href="manage_desclists.php?nav=5">Cancel</a>
                    </div>
                </div>
            </form>
                

    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  