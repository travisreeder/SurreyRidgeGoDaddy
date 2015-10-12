<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_page = Page::find_selected_page(false);

//echo "Current page id: ".$current_page->id;"<br \>";

if(!$current_page) {
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
    //$page = new Page();
    
    //var_dump($current_subject->id);
    //echo "Current subject id for new page: ".$id;"<br \>";
    
    //var_dump($_POST);
    $current_page->subject_id = (int) $_POST["subject_id"];
    $current_page->menu_name = $_POST["menu_name"];
    $current_page->show_menu = (int) $_POST["show_menu"];
    $current_page->position = (int) $_POST["position"];
    $current_page->visible = (int) $_POST["visible"];
    //$current_page->content = $database->escape_value($_POST["content"]); 
    $current_page->content = $_POST["content"]; 
    $current_page->url = $_POST["url"]; 
    $current_page->form_parameters = $_POST["form_parameters"];
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    	if($current_page->save()) {
            // Success
			//echo "Success...";
            $session->message("Page updated successfully.");
            redirect_to('manage_content.php?nav=1&page='.urlencode($current_page->id));
        } else {
            // Failure
            //echo "Failure...";
            $session->message("Page update failed.");
            redirect_to("new_page.php");
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
                <h2>Edit Page: <?php echo htmlentities($current_page->menu_name); ?></h2>
            </div>
        </div>

        <form class="form-horizontal" action="edit_page.php?nav=1&page=<?php echo urlencode($current_page->id); ?>" method="post">
            
            <div class="form-group">
                <label class="col-xs-12" for="subject_id">Subject:</label>

                <div class="col-xs-12">
                <select class="form-control input-sm" name="subject_id">
                    <?php 
                        $subject_list = Subject::find_all(false); 
                        foreach($subject_list as $this_subject) {
                            echo "<option value=\"{$this_subject->id}\"";
                            if($this_subject->id == $current_page->subject_id) {
                                echo " selected";
                            }
                            echo ">{$this_subject->menu_name}</option>";
                        }
                    ?>
                </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="subject_id">Menu Name:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="menu_name" value="<?php echo htmlentities($current_page->menu_name); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="show_menu">Show Menu Name:</label>
                <div class="col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="show_menu" value="0" <?php if($current_page->show_menu ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="show_menu" value="1" <?php if($current_page->show_menu ==1 ) { echo "checked"; } ?>/> Yes
                    </label>

                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="position">Position:</label>
                <div class="col-xs-12">
                    <select class="form-control input-sm" name="position">
                        <?php
                            $page_set = Page::find_pages_for_subject($current_page->subject_id,false);
                            $page_count = count($page_set);

                            //$page_count = 2;
                            for($count=1; $count <= $page_count; $count++) {
                                echo "<option value=\"{$count}\"";
                                if ($current_page->position == $count) {
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
                        <input type="radio" name="visible" value="0" <?php if($current_page->visible ==0 ) { echo "checked"; } ?> /> No&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="visible" value="1" <?php if($current_page->visible ==1 ) { echo "checked"; } ?>/> Yes
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="url">URL:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="url" value="<?php echo htmlentities($current_page->url); ?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="form_parmeters">Form Parameters:</label>
                <div class="col-xs-12">
                    <input class="form-control input-sm" type="text" name="form_parameters" value="<?php echo htmlentities($current_page->form_parameters); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="content">Content:</label>
                <div class="col-xs-12">
                    <textarea name="content" id="editor1" rows="20" cols="80"><?php echo htmlentities($current_page->content); ?></textarea>
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
                        <a class="btn btn-info" href="manage_content.php?nav=1&page=<?php echo urlencode($current_page->id); ?>">Cancel</a>
                        <a class="btn btn-danger" href="delete_page.php?page=<?php echo urlencode($current_page->id); ?>" onclick="return confirm('Are you sure?');">Delete page</a>
                </div>
            </div>

        </form>
    </div>
</div>

	        
			

<?php include_layout_template('footer2.php');  ?>  