<?php
    require_once("../sr_includes/initialize.php");

    $local_event = new Calendar_Event();
    echo $local_event->get_next_board_meeting();
    
?>