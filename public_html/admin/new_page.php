<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_subject = Subject::find_selected_subject(false);

//echo "Current subject id: ".$current_subject->id;"<br \>";

if(!$current_subject) {
    // subject ID was missing or invalid or
    // subject couldn't be found in databgase
    redirect_to("manage_content.php?nav=1");
}

//var_dump($current_subject);

include_layout_template('header3.php');
include_layout_template('admin_navigation.php');

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    $page = new Page();
    
    $id = $current_subject->id;
    $page->subject_id = $id;
    
    //var_dump($current_subject->id);
    //echo "Current subject id for new page: ".$id;"<br \>";
    
    $page->menu_name = $_POST["menu_name"];
    $page->show_menu = (int) $_POST["show_menu"];
    $page->position = (int) $_POST["position"];
    $page->visible = (int) $_POST["visible"];
    $page->content = $_POST["content"]; 
    $page->url = $_POST["url"]; 
    $page->form_parameters = $_POST["form_parameters"]; 
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($page->save()) {
            // Success
            $session->message("Page created successfully.");
            redirect_to('manage_content.php?nav=1&subject='.urlencode($current_subject->id));
        } else {
            // Failure
            echo "Failure...";
            $session->message("Page creation failed.");
            redirect_to("new_page.php?nav=1");
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
                <h2>Create Page under Subject: <?php echo $current_subject->menu_name; ?></h2>
            </div>
        </div>

            <form class="form-horizontal" action="new_page.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>" method="post">
                <div class="form-group">
                <label class="col-xs-12" for="subject_id">Menu Name:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="menu_name" value = ""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="show_menu">Show Menu Name:</label>
                    <div class="col-xs-12">
                        <label class="radio-inline">
                            <input type="radio" name="show_menu" value="0" > No&nbsp;
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="show_menu" value="1" checked> Yes
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="position">Position:</label>
                    <div class="col-xs-12">
                        <select class="form-control input-sm" name="position">
                            <?php
                                $page_set = Page::find_pages_for_subject($current_subject->id,false);
                                $page_count = count($page_set);
                                for($count=1; $count <= $page_count + 1; $count++) {
                                    echo "<option value=\"{$count}\"";
                                    if ($count == $page_count + 1) {
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
                        <input class="form-control input-sm" type="text" name="url" value=""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="form_parameters">Form Parameters:</label>
                    <div class="col-xs-12">
                        <input class="form-control input-sm" type="text" name="form_parameters" value=""/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12" for="content">Content:</label>
                    <div class="col-xs-12">
                        <textarea name="content" id="editor1" rows="20" cols="80"></textarea>
                        <script>
                            // Replace the <textarea id="editor1" with a CKEditor
                            // instance, using default configuration
                            CKEDITOR.replace('editor1');
                        </script>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-12" >
                        <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                        <a class="btn btn-info" href="manage_content.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>">Cancel</a>
                    </div>
                </div>
            </form>
                

    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  