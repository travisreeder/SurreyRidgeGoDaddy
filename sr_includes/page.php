<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Page extends DatabaseObject {
	
	protected static $table_name="pages";
	protected static $db_fields = array('id', 'subject_id', 'menu_name', 'show_menu', 'position', 'visible', 'content', 'url','form_parameters');
    protected static $order_by="position";
	
	public $id;
	public $subject_id;
	public $menu_name;
    public $show_menu;
	public $position;
	public $visible;
	public $content;
	public $url;
    public $form_parameters;

    public static function find_pages_for_subject($subject_id, $public=true) {
        global $database;
        $safe_subject_id = $database->escape_value($subject_id);

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE subject_id = {$safe_subject_id} ";
        if ($public) {
            $query .= "AND visible = 1 ";
        }
        $query .= "ORDER BY position ASC";

		//var_dump($query);
        return self::find_by_sql($query);
    }
    
    public static function count_pages_for_subject($subject_id, $public=true) {
        global $database;
        $safe_subject_id = $database->escape_value($subject_id);
        
        $sql = "SELECT COUNT(*) FROM pages ";
        $sql .= "WHERE subject_id = {$safe_subject_id} ";
        if ($public) {
            $sql .= "AND visible = 1 ";
        }
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
	}
    
    public static function find_default_page_for_subject($subject_id) {
        $page_set = self::find_pages_for_subject($subject_id, true);
        
        //var_dump($page_set);
        
        $first_page = array_shift($page_set);
        
        //var_dump($first_page);
        
        if($first_page) {
            return $first_page;
        } else {
            return null;
        }
    }
    public static function find_selected_page($public=false) {
        $current_page;
        if(!isset($_GET["page"])) {
            // Main nav_bar is selected; find the default page for this subject (if it exists)
            if(isset($_GET["subject"])) {
                $current_page = self::find_default_page_for_subject($_GET["subject"]);
            } else {
                $current_page = "";
            }
        } else {
            if(isset($_GET["page"])) {
                $current_page = self::find_by_id($_GET["page"]);
            } else {
                $current_page = "";
            }
        }
        /*
        if(isset($_GET["subject"])) {
            //TODO: make find_by_id take the public parameter
            $current_page = self::find_default_page_for_subject($_GET["subject"]);
        } else {
        	$current_page = "";
        }
        */
		return $current_page;
    }
    
	// Common Database Methods
	// Inherited from DatabaseObject

}

?>