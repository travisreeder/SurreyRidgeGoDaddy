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
                            <h1>Manage Visitors</h1>

                            <table id="visitors" class="display">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo Visitor::get_visitor_list(); ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>

<?php include_layout_template('footer2.php');  ?>  