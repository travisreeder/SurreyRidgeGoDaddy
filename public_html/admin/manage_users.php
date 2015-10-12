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
                            <h1>Manage Users</h1>

                            <table class="table table-condensed table-striped">
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </tr>
                                <?php echo User::get_user_list(); ?>

                            </table>

                            <p><a href="new_user.php?nav=2" class="btn btn-info" role="button">Add new user</a></p>

                        </div>
                    </div>
                </div>
            </div>

<?php include_layout_template('footer2.php');  ?>  