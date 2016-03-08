<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Calendar_Event extends DatabaseObject {
	
	protected static $table_name="calendar_events";
	protected static $db_fields = array('id', 'event_title', 'event_description', 'event_class', 'start', 'end', 'event_location');
    protected static $order_by = "start";
    
//    public $event_classes = array(
//        "event-info"      => "Blue",
//        "event-success"   => "Green",
//        "event-warning"   => "Yellow",
//        "event-important" => "Red",
//        "event-special"   => "Purple",
//        "event-inverse"   => "Black"
//        );
    	
	public $id;
	public $event_title;
	public $event_description;
	public $event_class;
	public $start;
    public $end;
    public $event_location;

    public static function get_event_classes() {
        $event_classes = DescriptionValue::find_by_list_id(3);
        return $event_classes;
    }
    
    public static function get_event_list() {
    $event_list = self::find_all();
    $output = "";
        
    $event_classes = self::get_event_classes();
        
    foreach($event_list as $event) {
        $output .= "<tr>" ;
        $output .= "<td>" ;
        $output .= $event->event_title;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $event->event_location;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $event->event_description;
        $output .= "</td>";
        $output .= "<td>" ;
        
        
        
        foreach($event_classes as $event_class) {
            if($event_class->desclist_shortvalue == $event->event_class) {
                $output .= $event_class->desclist_longvalue;
            }
        }
        
        //$output .= $event->event_classes[$event->event_class];
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= date('d-M-Y g:i a', $event->start);
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= date('d-M-Y g:i a', $event->end);
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= "<a class=\"btn btn-info btn-xs\" href=\"edit_calendar_event.php?id=";
        $output .= urlencode($event->id);
        $output .= "\">";    
        $output .= "edit"; 
        $output .= "</a>&nbsp";
        $output .= "<a class=\"btn btn-danger btn-xs\" href=\"delete_calendar_event.php?id=";
        $output .= urlencode($event->id);
        $output .= "\" onclick=\"return confirm('Are you sure?');";
        $output .= "\">";    
        $output .= "delete"; 
        $output .= "</a>";
        $output .= "</td>";

        $output .= "</tr>";
    }
    return $output;
    }
    
    public static function get_next_board_meeting() {
        $event_list = self::find_next_board_meeting();
        $output = "";
        
        foreach($event_list as $event) {
            $output .= "<p>";
            $output .= "<a href=\"#\" data-toggle=\"modal\" data-target=\"#test-modal\"";
//            $output .= "href=\"show_calendar_event.php?id=";
//            
//            $output .= urlencode($event->id);
            $output .= "\">";
            $output .= "<span class='glyphicon glyphicon-calendar' style='color:brown' aria-hidden='true'></span>";
            $output .= "</a>";
            $output .= "<b>"." ".$event->event_title."</b>";
            $output .= ": ";
            $output .= "<i>";
            $output .= date('D, M j, Y', $event->start);
            $output .= ": ";
            $output .= date('g:ia', $event->start);
            $output .= "</i>";
            $output .= "; at: ";
            if($event->event_location) {
                $output .= strip_tags($event->event_location);
            } else {
                $output .= "TBD";
            }
            $output .= "</p>";
        }
        
        return $output;
    }
    
    public static function get_calendar_events() {
        $event_list = self::find_all();
        $out = array();
        foreach($event_list as $event) {
            $out[] = array(
                'id' => $event->id,
                'title' => $event->event_title,
                'url' => 'show_calendar_event.php?id='.$event->id,
                'class' => $event->event_class,
                'start' => $event->start.'000',
                'end' => $event->end.'000'
            );
        }
        return json_encode(array('success' => 1, 'result' => $out));   
    }
    
    public static function find_next_board_meeting() {
        // Returns the next closest calendar entry where the event_class is 'event-success' (Board Meeting)
        global $database;

        $query = "SELECT * ";
        $query .= "FROM calendar_events ";
        $query .= "WHERE start = (SELECT min(start) from calendar_events WHERE event_class='event-success' and end > ".time().")";

		//var_dump($query);
        return self::find_by_sql($query);
    }
}

?>