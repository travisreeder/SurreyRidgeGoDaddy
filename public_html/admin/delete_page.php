<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_page = Page::find_selected_page(false);

if(!$current_page) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_content.php");
}

if($current_page->delete()) {
    $session->message("Page deletion succeeded.");
    redirect_to("manage_content.php");
} else
{
    $session->message("Page deletion failed.");
    redirect_to("manage_content.php?page={$current_page->id}");
}
?>