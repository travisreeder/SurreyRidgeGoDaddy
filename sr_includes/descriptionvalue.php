<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DescriptionValue extends DatabaseObject {
	
	protected static $table_name="descvalues";
	protected static $db_fields = array('id', 'desclist_id','desclist_shortvalue', 'desclist_longvalue');
    protected static $order_by = "desclist_shortvalue";
    	
	public $id;
	public $desclist_id;
    public $desclist_shortvalue;
    public $desclist_longvalue;
    
	// Common Database Methods
	// Inherited from DatabaseObject
    
    public static function count_by_list_id($list_id) {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
      $sql .= " WHERE 1=1 ";
      $sql .= " AND desclist_id = {$list_id}";
      $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
    
    public static function find_by_list_id($list_id) {
        $sql = "SELECT * FROM ".self::$table_name;
        $sql .= " WHERE 1=1 ";
        $sql .= " AND desclist_id = {$list_id}";
        if (!empty(self::$order_by)) {
            $sql .= " ORDER BY ".self::$order_by;
        }
        //var_dump($sql);
		return self::find_by_sql($sql);
    }
    
    public static function get_description_list($list_id) {
        $description_set = self::find_by_list_id($list_id);
        $output = "";
        foreach($description_set as $description) {
            $output .= "<tr>" ;
             $output .= "<td>" ;
            $output .= $description->id;
            $output .= "</td>";
            $output .= "<td>" ;
            $output .= $description->desclist_shortvalue;
            $output .= "</td>";
            $output .= "<td>" ;
            $output .= $description->desclist_longvalue;
            $output .= "</td>";
            $output .= "<td>" ;
            $output .= "<a class=\"btn btn-info btn-xs\" href=\"edit_descvalue.php?nav=5&id=";
            $output .= urlencode($description->id);
            $output .= "\">";    
            $output .= "edit"; 
            $output .= "</a>&nbsp";
            $output .= "<a class=\"btn btn-danger btn-xs\" href=\"delete_descvalue.php?nav=5&id=";
            $output .= urlencode($description->id);
            $output .= "\" onclick=\"return confirm('Are you sure?');";
            $output .= "\">";    
            $output .= "delete"; 
            $output .= "</a>";
            $output .= "</td>";
            }
        $output .= "</tr>";
        return $output;
    }
    
}
?>