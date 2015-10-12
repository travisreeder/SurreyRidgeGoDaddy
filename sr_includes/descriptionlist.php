<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DescriptionList extends DatabaseObject {
	
	protected static $table_name="desclists";
	protected static $db_fields = array('id', 'list_name','short_col_description', 'long_col_description');
    protected static $order_by = "list_name";
    	
	public $id;
	public $list_name;
    public $short_col_description;
    public $long_col_description;
    
	// Common Database Methods
	// Inherited from DatabaseObject

}
?>