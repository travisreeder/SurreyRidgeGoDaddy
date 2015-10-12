<?php
require_once("../../sr_includes/initialize.php");

$document_types = DescriptionValue::find_by_list_id(1); //List ID for Document Type is 1
$fiscal_years = DescriptionValue::find_by_list_id(2); //List ID for Fiscal years is 2

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_document = Document::find_by_id($_GET["id"]);

if(!$current_document) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_documents.php");
}

include_layout_template('header3.php');
include_layout_template('admin_navigation.php'); 

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    
    // get the current path and filename for move/rename
    $current_path = $current_document->image_path();
    //var_dump($current_path);
    
    $current_document->document_type = $database->escape_value($_POST["document_type"]);    
    $current_document->document_title = $database->escape_value($_POST["document_title"]);
    $current_document->filename = $database->escape_value($_POST["filename"]);
    $current_document->visible = (int) $_POST["visible"];   
    //$document->document_date = $_POST["document_date"];
    $current_document->fiscal_year = $database->escape_value($_POST["fiscal_year"]);  
    
    // get the new path and filename for move/rename
    $new_path = $current_document->image_path();
    
    //var_dump($new_path);
    
    if($current_document->save()) {
        // Success
        
        // See if file pathing meta-data changed and if so move the file
        if($current_path <> $new_path) {
            // Check for the existence of the new directory, if it doesn't exist, create it
            $path_test = pathinfo($new_path);
            //var_dump($path_test['dirname']);
            if(!file_exists($path_test['dirname'])) {
                 mkdir($path_test['dirname'], 0777, true);
            }
            // Move document
            rename($current_path, $new_path);
        }
        
        $session->message("Document information updated successfully.");
        redirect_to("manage_documents.php");
    } else {
        // Failure
        $session->message("Document information update failed.");
        redirect_to("edit_document.php?id={$current_document->id}");
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
                <h2>Edit Document: <?php echo htmlentities($current_document->document_title); ?></h2>
            </div>
            <div class="col-xs-12">
                <p>Use this to update the document meta-data, to replace the physical document, delete and reupload.</p>
            </div>
        </div>
            
        <form class="form-horizontal" action="edit_document.php?id=<?php echo urlencode($current_document->id); ?>" method="post">
            <div class="form-group">
                <label class="col-xs-12" for="document_type">Document Type:</label>
                <div class="col-xs-12">
                    <select class="form-control input-sm" name="document_type">
                        <?php
                        foreach($document_types as $document_type){
                            echo "<option value=\"{$document_type->desclist_shortvalue}\"";
                            if ($current_document->document_type == $document_type->desclist_shortvalue) {
                                echo " selected";
                            }
                            echo ">{$document_type->desclist_shortvalue}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="fiscal_year">Fiscal Year:</label>
                <div class="col-xs-12">
                    <select class="form-control input-sm" name="fiscal_year">
                        <?php
                        foreach($fiscal_years as $fiscal_year){
                            echo "<option value=\"{$fiscal_year->desclist_shortvalue}\"";
                            if($fiscal_year->desclist_shortvalue == $current_document->fiscal_year) {
                                echo " selected";
                            }
                            echo ">{$fiscal_year->desclist_longvalue}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="filename">Filename:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="filename" value="<?php echo $current_document->filename ?>" readonly/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="document_title">Title:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="document_title" value="<?php echo $current_document->document_title ?>"/>
                </div>
            </div>
                    
            <div class="form-group">
                <label class="col-xs-12" for="visible">Visible:</label>

                <div class="col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="0"<?php if($current_document->visible ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="1" <?php if($current_document->visible ==1 ) { echo "checked"; } ?>/> Yes
                    </label>
                </div>
            </div>
                    
            <div class="form-group">
                <div class="col-xs-12" >
                    <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                    <a class="btn btn-info" href="manage_documents.php">Cancel</a>
                    <a class="btn btn-danger" href="delete_document.php?id=<?php echo urlencode($current_document->id); ?>" onclick="return confirm('Are you sure?');">Delete document</a>
                </div>
            </div>

        </form>    


    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  