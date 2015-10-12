<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_subject = Subject::find_selected_subject(false);

if(!$current_subject) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_content.php");
}

$pages_set = Page::find_pages_for_subject($current_subject->id, false);
if (mysqli_num_rows($pages_set) > 0) {
    $session->message("Cannot delete a subject with pages");
    redirect_to("manage_content.php?subject={$current_subject->id}");
}

if($current_subject->delete()) {
    $session->message("Subject deletion succeeded.");
    redirect_to("manage_content.php");
} else
{
    $session->message("Subject deletion failed.");
    redirect_to("manage_content.php?subject={$current_subject->id}");
}
?>