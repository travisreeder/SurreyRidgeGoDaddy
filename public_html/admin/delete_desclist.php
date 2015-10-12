<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
$current_list = DescriptionList::find_by_id($_GET["id"]);

if(!$current_list) {
    redirect_to("manage_desclists.php?nav=5");
}

if (DescriptionValue::count_by_list_id($current_list->id) > 0) {
    $session->message("Cannot delete a list with descriptions! Delete each description first, then delete the list");
    redirect_to("manage_desclists.php?nav=5&selected_list={$current_list->id}");
}

if($current_list->delete()) {
    $session->message("List deletion succeeded.");
    redirect_to("manage_desclists.php?nav=5");
} else
{
    $session->message("List deletion failed.");
    redirect_to("manage_desclists.php?nav=5&selected_list={$current_list->id}");
}
?>