<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_list = DescriptionList::find_by_id($_GET["id"]);

if(!$current_list) {
        redirect_to("manage_desclists.php");
}

include_layout_template('header3.php');
include_layout_template('admin_navigation.php'); 

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    
    $current_list->list_name = $_POST["list_name"];
    $current_list->short_col_description = $_POST["short_col_description"];
    $current_list->long_col_description = $_POST["long_col_description"]; 
    
    if($current_list->save()) {
        // Success
        $session->message("List information updated successfully.");
        redirect_to("manage_desclists.php");
    } else {
        // Failure
        $session->message("Document information update failed.");
        redirect_to("edit_desclist.php?id={$current_list->id}");
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
                <h2>Edit List: <?php echo htmlentities($current_list->list_name); ?></h2>
            </div>
        </div>
            
        <form class="form-horizontal" action="edit_desclist.php?id=<?php echo urlencode($current_list->id); ?>" method="post">
            
            <div class="form-group">
                <label class="col-xs-12" for="list_name">List Name:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="list_name" value="<?php echo $current_list->list_name ?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="short_col_description">Short Column Description:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="short_col_description" value="<?php echo $current_list->short_col_description ?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="long_col_description">Long Column Description:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="long_col_description" value="<?php echo $current_list->long_col_description ?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-xs-12" >
                    <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                    <a class="btn btn-info" href="manage_desclists.php">Cancel</a>
                    <a class="btn btn-danger" href="delete_desclist.php?id=<?php echo urlencode($current_list->id); ?>" onclick="return confirm('Are you sure?');">Delete List</a>
                </div>
            </div>

        </form>    


    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  