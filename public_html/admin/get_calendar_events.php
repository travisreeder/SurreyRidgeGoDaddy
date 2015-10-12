<?php
require_once("../../sr_includes/initialize.php");
$events = new Calendar_Event();

echo $events->get_calendar_events();
exit;
?>