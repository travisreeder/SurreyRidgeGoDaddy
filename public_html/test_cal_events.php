<?php
require_once("../../sr_includes/initialize.php");
$out = array();


//strftime("%Y-%m-%d %H:%M:%S", time())
    
 for($i=1; $i<=15; $i++){   //from day 01 to day 15
    $start = date('Y-m-d', strtotime("+".$i." days"));
    
    //$end = date('Y-m-d', strtotime("+".$i." days"));
     
   // echo "TEST START: ".datetime_to_text($start)."<br />";
   //  echo "TEST END: ".datetime_to_text($end)."<br />";
     
    $out[] = array(
        'id' => $i,
        'title' => 'Event name '.$i,
        'url' => 'show_calendar_event.php?id='.$i,
        'class' => 'event-important',
        'start' => strtotime($start).'000'
       // 'end' => strtotime($end).'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;
?>