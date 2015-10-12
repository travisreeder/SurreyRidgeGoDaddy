<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 
?>

            <div class="container-fluid" id="container">
                <div class="display_content">
                    
                    <div class="row">
                        <div class="col-xs-12"> 
                            <?php echo output_message($message); ?>
                            <h1>Manage Documents</h1>

                            <table id="documents" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Fiscal Year</th>
                                        <th>Document Title</th>
                                        <th>Filename</th>
                                        <th>Visible</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo Document::get_document_list("",false); ?>
                                </tbody>

                            </table>

                            <p><a href="new_document.php?nav=3" class="btn btn-info" role="button">Add new document</a></p>
                            
                        </div>
                    </div>
                </div>
            </div>

<?php include_layout_template('footer2.php');  ?>  