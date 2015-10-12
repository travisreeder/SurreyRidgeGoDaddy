<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Subject extends DatabaseObject {
	
	protected static $table_name="subjects";
	protected static $db_fields = array('id', 'menu_name', 'position', 'visible','url');
    protected static $order_by="position";
	
	public $id;
	public $menu_name;
	public $position;
	public $visible;
	public $url;

    public static function find_selected_subject($public=false) {
        $current_subject;
        if(isset($_GET["subject"])) {
            //TODO: make find_by_id take the public parameter
            $current_subject = self::find_by_id($_GET["subject"]);
        } else {
            $current_subject = null;
        }
        return $current_subject;
    }
    
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
	// Inherited from DatabaseObject

}

?>