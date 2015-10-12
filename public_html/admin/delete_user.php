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

if($current_user->delete()) {
    $session->message("User deletion succeeded.");
    redirect_to("manage_users.php");
} else
{
    $session->message("User deletion failed.");
    redirect_to("manage_users.php");
}
?>