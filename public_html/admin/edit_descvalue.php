<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
include_layout_template('header3.php');
include_layout_template('admin_navigation.php');

$desc_id = $_GET["id"];
$current_description = DescriptionValue::find_by_id($desc_id);
$current_list = DescriptionList::find_by_id($current_description->desclist_id);
    
//var_dump($current_list);
if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
        
    $current_description->desclist_id = $_POST["desclist_id"];
    $current_description->desclist_shortvalue = $database->escape_value($_POST["desclist_shortvalue"]);
    $current_description->desclist_longvalue = $database->escape_value($_POST["desclist_longvalue"]);
    
    if($current_description->save()) {
            // Success
            $session->message("Description edited successfully.");
            redirect_to('manage_desclists.php?nav=5&selected_list='.urlencode($current_description->desclist_id));
        } else {
            // Failure
            //echo "Failure...";
            $session->message("Description creation failed.");
            redirect_to("edit_descvalue.php?nav=5&id=".urlencode($desc_id));
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
                <h2>Edit Description</h2>
            </div>
        </div>

            <form class="form-horizontal" action="edit_descvalue.php?nav=5&id=<?php echo $desc_id; ?>" method="post">
                        
                <div class="form-group">
                    <label class="col-xs-12" for="desclist_id">List:</label>
                    <div class="col-xs-12">
                        <select class="form-control input-sm" name="desclist_id">
                            <?php
                                $desclists = DescriptionList::find_all();
                                foreach($desclists as $list_item){
                                echo "<option value=\"{$list_item->id}\"";
                                if ($list_item->id == $current_description->desclist_id) {                             
                                   echo " selected";
                                }
                                echo ">{$list_item->list_name}</option>";   
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                <label class="col-xs-12" for="desclist_shortvalue"><?php echo $current_list->short_col_description; ?>:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="desclist_shortvalue" value = "<?php echo $current_description->desclist_shortvalue; ?>"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="desclist_longvalue"><?php echo $current_list->long_col_description; ?>:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="desclist_longvalue" value="<?php echo $current_description->desclist_longvalue; ?>"/>
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