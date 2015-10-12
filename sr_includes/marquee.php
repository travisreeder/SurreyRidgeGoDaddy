<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Marquee extends DatabaseObject {
	
	protected static $table_name="marquee";
	protected static $db_fields = array('id', 'marquee_text','visible');
    	
	public $id;
	public $marquee_text;
    public $visible;

    public static function find_all($public=false) {
        $sql = "SELECT * FROM ".self::$table_name;
        if($public) {
            $sql .= " WHERE visible = 1 ";
        }
        if (!empty(self::$order_by)) {
            $sql .= " ORDER BY ".self::$order_by;
        }
		return self::find_by_sql($sql);
    }
	// Common Database Methods
    
    public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
        
        //var_dump($sql);
        
	  $database->query($sql);
        //var_dump($database->affected_rows());
	  return ($database->affected_rows() >= 0) ? true : false;
	}
	// Inherited from DatabaseObject
}
?>