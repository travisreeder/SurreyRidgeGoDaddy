<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
include_layout_template('header3.php');
include_layout_template('admin_navigation.php');

$list_id = $_GET["list_id"];
    $current_list = DescriptionList::find_by_id($list_id);
    
//var_dump($current_list);
if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    $description = new DescriptionValue();
    
    $description->desclist_id = $list_id;
    $description->desclist_shortvalue = $database->escape_value($_POST["desclist_shortvalue"]);
    $description->desclist_longvalue = $database->escape_value($_POST["desclist_longvalue"]);
    
    if($description->save()) {
            // Success
            $session->message("Description created successfully.");
            redirect_to('manage_desclists.php?nav=5&selected_list='.urlencode($list_id));
        } else {
            // Failure
            //echo "Failure...";
            $session->message("Description creation failed.");
            redirect_to("new_descvalue.php?nav=5&list_id=".urlencode($list_id));
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
                <h2>Create New Description For List: <?php echo $current_list->list_name; ?></h2>
            </div>
        </div>

            <form class="form-horizontal" action="new_descvalue.php?nav=5&list_id=<?php echo $current_list->id; ?>" method="post">
                <div class="form-group">
                <label class="col-xs-12" for="desclist_shortvalue"><?php echo $current_list->short_col_description; ?>:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="desclist_shortvalue" value = ""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="desclist_longvalue"><?php echo $current_list->long_col_description; ?>:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="desclist_longvalue" value=""/>
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