<?php
require_once("../../sr_includes/initialize.php");
$max_file_size = 15728640; // expressed in bytes

//if(!$session->is_logged_in()) {
//  redirect_to("login.php");
//}

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 

$document_types = DescriptionValue::find_by_list_id(1); //List ID for Document Type is 1
$fiscal_years = DescriptionValue::find_by_list_id(2); //List ID for Fiscal years is 2
//var_dump($fiscal_years);

if (
    isset( $_SERVER['REQUEST_METHOD'] )      &&
    ($_SERVER['REQUEST_METHOD'] === 'POST' ) &&
    isset( $_SERVER['CONTENT_LENGTH'] )      &&
    ( empty( $_POST ) )
) {
    $max_post_size = ini_get('post_max_size');
    $content_length = $_SERVER['CONTENT_LENGTH'];
    $size_mb = round($content_length/1048576, 0);
    
    $content_length = $content_length / 1024 /1024;
    
    if ($content_length > $max_post_size ) {
        echo output_message('It appears you tried to upload '.$size_mb.'MB of data but the PHP post_max_size is '.$max_post_size.'B');
    }
}

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    $document = new Document();  
    
    $document->document_type = $database->escape_value($_POST["document_type"]);    
    $document->document_title = $database->escape_value($_POST["document_title"]);
    $document->attach_file($_FILES['filename']);
    $document->visible = (int) $_POST["visible"];   
    $document->document_date = strftime("%Y-%m-%d %H:%M:%S", time());
    $document->fiscal_year = $database->escape_value($_POST["fiscal_year"]);
    
    if($document->save()) {
        // Success
        $session->message("Document uploaded successfully.");
        redirect_to("manage_documents.php");
    } else {
        // Failure
        $message = join("<br />", $document->errors);
    }
    
}
?>        
<div class="container-fluid" id="container">
    <div class="display_content">
        <div class="row">
            <div class="col-xs-12"> 		    
                <?php echo output_message($message); ?>
                <h2>Document Upload</h2>
                <h5>Document Type and Fiscal Year determine where the file is uploaded on the server and also serve as addtional meta-data.</h5>
                

                <form class="form-horizontal" enctype="multipart/form-data" action="new_document.php" method="post">
                <div class="form-group">
                <label class="col-xs-12" for="document_type">Document Type:</label>
                    <div class="col-xs-12">
                        <select class="form-control input-sm" name="document_type">
                            <?php 
                            foreach($document_types as $document_type){
                                echo "<option value=\"{$document_type->desclist_shortvalue}\">{$document_type->desclist_shortvalue}</option>";
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
                                if($fiscal_year->desclist_shortvalue == "N/A") {
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
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                        <input type="file" name="filename" />
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-xs-12" for="document_title">Title:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="document_title" value=""/>
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
                    <div class="col-xs-12" >
                        <input class="btn btn-primary" type="submit" name="submit" value="Create/Upload Document" />
                        <a class="btn btn-info" href="manage_documents.php">Cancel</a>
                    </div>
                </div>
            </form>
            

            </div>
        </div>
    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  