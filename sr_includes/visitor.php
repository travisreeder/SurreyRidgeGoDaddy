<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Visitor extends DatabaseObject {
	
	protected static $table_name="visitors";
	protected static $db_fields = array('id', 'name', 'email', 'mobile','subject','message');
    	
	public $id;
	public $name;
	public $email;
	public $mobile;
	public $subject;
    public $message;

    public static function get_visitor_list() {
    $visitor_set = self::find_all();
    $output = "";
    foreach($visitor_set as $visitor) {
        $output .= "<tr>" ;
        $output .= "<td>" ;
        $output .= $visitor->name;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $visitor->email;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $visitor->mobile;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $visitor->subject;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $visitor->message;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= "<a class=\"btn btn-danger btn-xs\" href=\"delete_visitor.php?id=";
        $output .= urlencode($visitor->id);
        $output .= "\" onclick=\"return confirm('Are you sure?');";
        $output .= "\">";    
        $output .= "delete"; 
        $output .= "</a>";
        $output .= "</td>";
        $output .= "</tr>";
    }
    return $output;
	// Common Database Methods
	// Inherited from DatabaseObject
    }
}

?>