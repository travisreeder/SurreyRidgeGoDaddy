<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
	
	protected static $table_name="users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name');
    protected static $order_by="username";
	
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	
    public function full_name() {
        if(isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public function password_encrypt($password) {
        return (password_hash($password, PASSWORD_DEFAULT));
    }
    
	public static function authenticate($username="", $password="") {
        global $database;
        
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);      

        $sql  = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        //$sql .= "AND password = '{$hashed_password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        
        $row = array_shift($result_array);
        
        //var_dump($row);
        
        //echo $row->password."<br />";
        //echo $password."<br />";
        //echo password_verify($password, $row->password)."<br />";
        
        if(!empty($row)) {
            if (password_verify($password, $row->password)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}

    public static function get_user_list() {
    $user_set = self::find_all();
    $output = "";
    foreach($user_set as $user) {
        $output .= "<tr>" ;
        $output .= "<td>" ;
        $output .= $user->first_name;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $user->last_name;
        $output .= "</td>";
        $output .= "<td id=\"username\">" ;
        $output .= $user->username;
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= "<a class=\"btn btn-info btn-xs\" href=\"edit_user.php?nav=2&id=";
        $output .= urlencode($user->id);
        $output .= "\">";    
        $output .= "edit"; 
        $output .= "</a>&nbsp";
        $output .= "<a class=\"btn btn-danger btn-xs\" href=\"delete_user.php?id=";
        $output .= urlencode($user->id);
        $output .= "\" onclick=\"return confirm('Are you sure?');";
        $output .= "\">";    
        $output .= "delete"; 
        $output .= "</a>";
        $output .= "</td>";
        $output .= "</tr>";
    }
    return $output;
}
	// Common Database Methods
	// Inherited from DatabaseObject

}

?>