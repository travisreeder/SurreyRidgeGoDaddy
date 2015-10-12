<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

$desclists = DescriptionList::find_all();
//var_dump($desclists);
include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 

$selectedListID = 1;
if (isset($_POST['selected_list'])) {
    // Process the form
    // Often these are form values in $_POST
    $selectedListID = $_POST['selected_list'];   
    //echo $selectedListID;
} else {
    if(isset($_GET['selected_list'])) {
        $selectedListID = $_GET['selected_list'];
    }
}

$selected_list = DescriptionList::find_by_id($selectedListID);
if(!$selected_list) {
    redirect_to("manage_desclists.php?nav=5");
}
?> 

<div class="container-fluid" id="container">
    <div class="display_content">

        <div class="row">
            <div class="col-xs-12"> 
                <?php echo output_message($message); ?>
                <h1>Manage Description Lists</h1>
            </div>
        </div>
        <form class="form-horizontal" action="manage_desclists.php?nav=5&listid=<?php echo urlencode($selectedListID); ?>" method="post">
            
        
            <div class="form-group">  
                <div class="col-xs-12">
                    <label for="selected_list">Select List:</label>
                </div>
                <div class="col-xs-6">
                    <select class="form-control input-sm" name="selected_list" onchange="this.form.submit()">
                    <?php
                        foreach($desclists as $list_item){
                        echo "<option value=\"{$list_item->id}\"";
                        if ($list_item->id == $selectedListID) {                             
                           echo " selected";
                        }
                        echo ">{$list_item->list_name}</option>";   
                    }
                    ?>
                    </select>
                </div>
                <div class="col-xs-6">
                    <p><a href="new_desclist.php?nav=5" class="btn btn-info btn-sm" role="button">Add new list</a>
                    <a href="edit_desclist.php?nav=5&id=<?php echo $selectedListID; ?>" class="btn btn-info btn-sm" role="button">Edit list Details</a></p>
                </div>
            </div>
            
            
                <table id="descriptionlist" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo $selected_list->short_col_description ?></th>
                            <th><?php if($selected_list->long_col_description) { echo $selected_list->long_col_description; } else { echo "N/A"; } ?></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo DescriptionValue::get_description_list($selectedListID); ?>
                    </tbody>
                </table>
           
            
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <p><a href="new_descvalue.php?nav=5&list_id=<?php echo $selectedListID ?>" class="btn btn-info" role="button">Add new description</a></p>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  