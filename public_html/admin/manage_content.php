<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
//$current_subject = Subject::find_selected_subject(false);
//$current_page = Page::find_selected_page(false);

if(!isset($_GET["page"])) {
    $current_subject = Subject::find_selected_subject(false);
    $current_page = "";
} else {
    $current_subject = "";
    $current_page = Page::find_selected_page(false);
}

//var_dump($current_page);

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 
?>

<div class="container-fluid" id="container">
    <div class="display_content">
                    
        <div class="row">
            <div class="col-xs-12">
                <?php echo output_message($message); ?>
            </div>
        </div>
        <?php if ($current_subject) { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h2>Manage Subject: <?php echo htmlentities($current_subject->menu_name); ?></h2>
                </div>
            </div>
            <table class="table table-condensed">
                <tr>
                <th>Field</th>
                <th>Value</th>
                </tr>
                <tr>
                    <td width="5%">Menu name:</td>
                    <td width="95%"><?php echo htmlentities($current_subject->menu_name); ?></td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td><?php echo $current_subject->position; ?></td>
                </tr>
                <tr>
                    <td>Visible:</td>
                    <td><?php echo $current_subject->visible == 1 ? 'Yes' : 'No' ; ?></td>
                </tr>
                <tr>
                    <td>URL:</td>
                    <td><?php echo $current_subject->url?></td>
                </tr>
            </table>

            <div class="row">
                <div class="col-xs-12">
                    <a href="edit_subject.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>" class="btn btn-info" role="button">Edit Subject</a>
                </div>
            </div>

            <hr class="thin-hr gradient">
            <div class="row">
                <div class="col-xs-12">
                    <h3>Pages in this subject:</h3>
                </div>
            </div>
            <ul>
            <?php 
                $subject_pages = Page::find_pages_for_subject($current_subject->id,null);
                foreach($subject_pages as $page) {
                    echo "<li>";
                    $safe_page_id = urlencode($page->id);
                    echo "<a href=\"manage_content.php?nav=1&page={$safe_page_id}\">";
                    echo htmlentities($page->menu_name);
                    echo "</a>";
                    echo "</li>";
                }
            ?>
            </ul>
            <div class="row">
                <div class="col-xs-12">
                    <p><a href="new_page.php?nav=1&subject=<?php echo urlencode($current_subject->id); ?>" class="btn btn-info" role="button">Add a new page to this subject</a></p>
                </div>
            </div>

        <?php } elseif ($current_page) { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h2>Manage Page: <?php echo htmlentities($current_page->menu_name); ?></h2>
                </div>
            </div>
                        
            <!-- get the Subject for this page to display the Subject Menu name. -->
            <?php $subject_for_this_page = Subject::find_by_id($current_page->subject_id); ?>
                        
            <table class="table table-condensed">
                <tr>
                <th>Field</th>
                <th>Value</th>
                </tr>
                <tr>
                    <td width="5%">Subject:</td>
                    <td width="95%"><?php echo htmlentities($subject_for_this_page->menu_name); ?></td>
                </tr>
                <tr>
                    <td>Menu name:</td>
                    <td><?php echo htmlentities($current_page->menu_name); ?></td>
                </tr>
                <tr>
                    <td>Show Menu on Page:</td>
                    <td><?php echo $current_page->show_menu == 1 ? 'Yes' : 'No' ; ?></td>
                </tr>
                <tr>
                    <td>Position:</td>
                    <td><?php echo $current_page->position; ?></td>
                </tr>
                <tr>
                    <td>Visible:</td>
                    <td><?php echo $current_page->visible == 1 ? 'Yes' : 'No' ; ?></td>
                </tr>
                <tr>
                    <td>URL:</td>
                    <td><?php echo $current_page->url?></td>
                </tr>
                <tr>
                    <td>Form Parameters:</td>
                    <td><?php echo $current_page->form_parameters?></td>
                </tr>
            </table>
                                               
            <div class="row">
                <div class="col-xs-12">
                    <p>Content:</p>
                        <div class="view-content">
                            <?php echo ($current_page->content); ?>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-info" href="edit_page.php?nav=1&page=<?php echo urlencode($current_page->id); ?>">Edit Page</a>
                </div>
            </div>
                       
        <?php } else { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h1>Manage Content</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">        
                    <p>Please select a subject or a page from the Manage Content menu/drop-down.</p>
                </div>
            </div>
        <?php } ?>
    </div> <!-- End display_content -->
</div> <!-- End container -->

<?php include_layout_template('footer2.php');  ?>  