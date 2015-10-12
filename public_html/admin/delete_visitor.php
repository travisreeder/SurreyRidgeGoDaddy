<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_visitor = Visitor::find_by_id($_GET["id"]);

if(!$current_visitor) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_visitors.php");
}

if($current_visitor->delete()) {
    $session->message("Visitor deletion succeeded.");
    redirect_to("manage_visitors.php");
} else
{
    $session->message("User deletion failed.");
    redirect_to("manage_visitors.php");
}
?>