<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
$current_description = DescriptionValue::find_by_id($_GET["id"]);
$list_id = $current_description->desclist_id;

if(!$current_description) {
    redirect_to("manage_desclists.php?nav=5");
}

if($current_description->delete()) {
    $session->message("Description deletion succeeded.");
    redirect_to("manage_desclists.php?nav=5&selected_list={$list_id}");
} else
{
    $session->message("List deletion failed.");
    redirect_to("manage_desclists.php?nav=5&selected_list={$list_id}");
}
?>