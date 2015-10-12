<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_event = Calendar_Event::find_by_id($_GET["id"]);

if(!$current_event) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("manage_calendar_events.php");
}

if($current_event->delete()) {
    $session->message("Event deletion succeeded.");
    redirect_to("manage_calendar_events.php");
} else
{
    $session->message("Event deletion failed.");
    redirect_to("manage_calendar_events.php");
}
?>