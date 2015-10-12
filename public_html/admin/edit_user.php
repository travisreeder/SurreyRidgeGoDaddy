<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_user = User::find_by_id($_GET["id"]);

if(!$current_user) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_users.php");
}

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 

if (isset($_POST['submit'])) {
    // Process the form
    // Often these are form values in $_POST
    
    $current_user->first_name = $database->escape_value($_POST["first_name"]);    
    $current_user->last_name = $database->escape_value($_POST["last_name"]);    
    $current_user->user_name = $database->escape_value($_POST["username"]);    
    $hashed_password = $current_user->password_encrypt($_POST["password"]);
    $current_user->password = $hashed_password;
    
    //echo "Hashed password: {$hashed_password}<br />";
    
    // validations
    //$required_fields = array("menu_name","position","visible");
    //validate_presences($required_fields);
    
    //$fields_with_max_lengths = array("menu_name" => 30);
    //validate_max_lengths($fields_with_max_lengths);
    
    if($current_user->save()) {
        // Success
        $session->message("User updated successfully.");
        redirect_to("manage_users.php");
    } else {
        // Failure
        $session->message("User update failed.");
        redirect_to("edit_user.php?nav=2&id={$current_user->id}");
    }
    
}
?>        
<div class="container-fluid" id="container">
    <div class="display_content">
        <div class="row">
            <div class="col-xs-12"> 
            <?php echo output_message($message); ?>
            <h2>Edit User: <?php echo htmlentities($current_user->full_name()); ?></h2>
        
            <form action="edit_user.php?nav=2&id=<?php echo urlencode($current_user->id); ?>" method="post">
                <table class="table table-condensed table-responsive borderless">
                    <tr>
                        <td width="10%">
                            First Name:
                        </td>
                        <td width="90%">
                            <input type="text" name="first_name" value="<?php echo htmlentities($current_user->first_name); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Last Name:
                        </td>
                        <td>
                            <input type="text" name="last_name" value="<?php echo htmlentities($current_user->last_name); ?>" />
                        </tr>
                    </tr>
                    <tr>
                        <td>
                            Username:
                        </td>
                        <td>
                            <input type="text" name="username" value="<?php echo htmlentities($current_user->username); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>	
                            Password:
                        </td>
                        <td>
                            <input type="password" name="password" value = ""/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="btn btn-primary" type="submit" name="submit" value="Save" />
                            <a href="manage_users.php?nav=2" class="btn btn-info">Cancel</a>
                        </td>
                    </tr>
                </table>
                </form>
      
            </div>
        </div>
    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  