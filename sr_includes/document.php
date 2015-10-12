<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class Document extends DatabaseObject {
	
	protected static $table_name="documents";
	protected static $db_fields = array('id', 'document_type', 'document_title', 'filename', 'visible', 'document_date', 'fiscal_year');
    protected static $order_by = "document_type,fiscal_year, document_title";
    
    // eventually replace this with a lookup from the database to populate
    //public $fiscal_years = array("N/A","2010-2011","2011-2012","2012-2013","2013-2014","2014-2015","2015-2016","2016-2017");
    
    // eventually replace this with a lookup from the database to populate
    //public $document_types = array("Articles of Incorporation", "By Laws", "Covenants", "Financials", "Legal", "Meeting Minutes", "Miscellaneous", "Plats", "Surrey Ridge Sentinel");
    	
	public $id;
	public $document_type;
	public $document_title;
	public $filename;
	public $visible;
    public $document_date;
    public $fiscal_year;

    
    
    private $temp_path;
    protected $upload_dir="documents";
    public $errors = array();
    
    protected $upload_errors = array(
        UPLOAD_ERR_OK 			=> "No errors.",
        UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE 	=> "Attachment is than max size of 15MB.",
        UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
        UPLOAD_ERR_NO_FILE 		=> "No file selected, please choose a file.",
        UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
    );
    
    public static function get_fiscal_years() {
        $fiscal_years = DescriptionValues::find_by_list_id(2);
        return $fiscal_years;
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
    
    public static function find_by_document_type($document_types="", $public=false) {
        $sql = "SELECT * FROM ".self::$table_name;
        $sql .= " WHERE 1=1 ";
        if($document_types) {
            $sql .= " AND document_type in ({$document_types})";
        }
        if($public) {
            $sql .= " AND visible = 1 ";
        }
        if (!empty(self::$order_by)) {
            $sql .= " ORDER BY ".self::$order_by;
        }
        //var_dump($sql);
		return self::find_by_sql($sql);
    }
    
    public static function get_document_list($document_types="",$public=false) {
    $document_set = self::find_by_document_type($document_types,$public);
    $output = "";
        
    $document_type_descriptions = DescriptionValue::find_by_list_id(1); //List ID for Document Type is 1
    $fiscal_years = DescriptionValue::find_by_list_id(2); //List ID for Fiscal Years is 2
    //var_dump($document_type_descriptions);

    foreach($document_set as $document) {
        $output .= "<tr>" ;
        if(!$document_types || strpos($document_types, ",")) {
            $output .= "<td>" ;
            $output .= $document->document_type;
            $output .= "</td>";
        }
        $output .= "<td>" ;
        
        //$output .= $document->fiscal_year;
        foreach($fiscal_years as $fiscal_year) {
            if($fiscal_year->desclist_shortvalue == $document->fiscal_year) {
                $output .= $fiscal_year->desclist_longvalue;
            }
        }
        
        $output .= "</td>";
        $output .= "<td>" ;
        $output .= $document->document_title;
        $output .= "</td>";
        $output .= "<td>" ;
        if(!$public) {
            $output .= "<a href=\"..".DS."documents";
        } else {
            $output .= "<a href=\"documents";
        }
        
        //search the document_type_descriptions array to find the desclist_longvalue; that is the path the file is stored
        foreach($document_type_descriptions as $document_type_desc) {
            if($document_type_desc->desclist_shortvalue == $document->document_type) {
                $sub_path = $document_type_desc->desclist_longvalue;
            }
        }
        $output .= DS.$sub_path;
        
        //Add the fiscal year as part of the file pathing
        if($document->fiscal_year <> "N/A" && !empty($document->fiscal_year)) {
            $output .= DS.$document->fiscal_year.DS.$document->filename;
        } else {
            $output .= DS.$document->filename;
        }
        
        $output .= "\">";
        
        $output .= $document->filename;
        $output .= "</td>";
        if(!$public) {
            $output .= "<td>" ;
            if($document->visible) {
                $output .= "Yes";
            } else {
                $output .= "No";
            }
            $output .= "</td>";
            $output .= "<td>" ;
            $output .= datetime_to_short_text($document->document_date);
            $output .= "<td>" ;
            $output .= "<a class=\"btn btn-info btn-xs\" href=\"edit_document.php?nav=3&id=";
            $output .= urlencode($document->id);
            $output .= "\">";    
            $output .= "edit"; 
            $output .= "</a>&nbsp";
            $output .= "<a class=\"btn btn-danger btn-xs\" href=\"delete_document.php?id=";
            $output .= urlencode($document->id);
            $output .= "\" onclick=\"return confirm('Are you sure?');";
            $output .= "\">";    
            $output .= "delete"; 
            $output .= "</a>";
            $output .= "</td>";
        }
        $output .= "</tr>";
    }
    return $output;
    }
    
    public function attach_file($file) {
        // Perform error checking on the form parameters
        if(!$file || empty($file) || !is_array($file)) {
            // error: nothing uploaded or wrong argument usage
            $this->errors[] = "No file was uploaded.";
            return false;
        } elseif($file['error'] != 0) {
            // error: report what PHP says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            // Set object attributes to the form parameters
            $this->temp_path = $file['tmp_name'];
            $this->filename  = basename($file['name']);
            $this->type      = $file['type'];
            $this->size      = $file['size'];
        }
        // Don't worry about saving anythign to the database yet.
        return true;
    }
   
    public function image_path() {
        $document_type_descriptions = DescriptionValue::find_by_list_id(1); //List ID for Document Type is 1
        
        $target_path = "";
        
        //search the document_type_descriptions array to find the desclist_longvalue; that is the path the file is stored
        foreach($document_type_descriptions as $document_type_desc) {
            if($document_type_desc->desclist_shortvalue == $this->document_type) {
                $sub_path = $document_type_desc->desclist_longvalue;
            }
        }
        $target_path = SITE_ROOT.DS.$this->upload_dir.DS.$sub_path;
        
//        switch ($this->document_type) {
//            case "Articles of Incorporation":
//            case "Covenants":
//            case "Plats":
//            case "By Laws":
//                $target_path = SITE_ROOT.DS.$this->upload_dir.DS."FoundingDocuments";
//                break;
//            case "Financials":
//                $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Financials";
//                break;
//            case "Legal":
//                $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Legal";
//                break;
//            case "Meeting Minutes":
//                $target_path = SITE_ROOT.DS.$this->upload_dir.DS."MeetingMinutes";
//                break;
//            case "Miscellaneous":
//                $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Miscellaneous";
//                break;
//            case "Surrey Ridge Sentinel":
//                $target_path = SITE_ROOT.DS.$this->upload_dr.DS."Sentinel";
//                break;
//            default:
//                $target_path = SITE_ROOT.DS.$this->upload_dir;
//        }
            
        //Add the fiscal year as part of the file pathing
        if($this->fiscal_year <> "N/A") {  
            $target_path .= DS.$this->fiscal_year.DS.$this->filename;
        } else {
            $target_path .= DS.$this->filename;
        }
        
        return $target_path;
    }
    
    public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
    
    // currently overrides the parent save()
    public function save() {
        // maybe fix this later to user parent::save()
        //parent::save();
        $document_type_descriptions = DescriptionValue::find_by_list_id(1); //List ID for Document Type is 1
        
        // A new record won't have an id yet.
        if(isset($this->id)) {
            // Really just to update the caption
            $this->update();
            return true;
        } else {
            // Make sure theare are no errors
            
            // Can't sve if there are any pre-existing errors
            if(!empty($this->errors)) { return false; }
            
            
            // Can't save without filename and temp location
            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return false;
            }
            
            //search the document_type_descriptions array to find the desclist_longvalue; that is the path the file is stored
            foreach($document_type_descriptions as $document_type_desc) {
                if($document_type_desc->desclist_shortvalue == $this->document_type) {
                    $sub_path = $document_type_desc->desclist_longvalue;
                }
            }
            $target_path = SITE_ROOT.DS.$this->upload_dir.DS.$sub_path;
            
//            switch ($this->document_type) {
//                case "Articles of Incorporation":
//                case "Covenants":
//                case "Plats":
//                case "By Laws":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."FoundingDocuments";
//                    break;
//                case "Financials":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Financials";
//                    break;
//                case "Legal":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Legal";
//                    break;
//                case "Meeting Minutes":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."MeetingMinutes";
//                    break;
//                case "Miscellaneous":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Miscellaneous";
//                    break;
//                case "Surrey Ridge Sentinel":
//                    $target_path = SITE_ROOT.DS.$this->upload_dir.DS."Sentinel";
//                    break;
//                default:
//                    $target_path = SITE_ROOT.DS.$this->upload_dir;
//            }
            
            //Add the fiscal year as part of the file pathing
            if($this->fiscal_year <> "N/A") {
                $path_test = $target_path.DS.$this->fiscal_year;
                //var_dump($path_test);
                if(!file_exists($path_test)) {
                    mkdir($path_test, 0777, true);
                }    
                $target_path .= DS.$this->fiscal_year.DS.$this->filename;
            } else {
                if(!file_exists($target_path)) {
                    mkdir($target_path, 0777, true);
                }
                $target_path .= DS.$this->filename;
            }
            
            //Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists.";
                return false;
            }
            
            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)) {
                // change the files permissions so it can be moved later
                chmod($target_path, 0777);
                // Sucess
                // Save a corresponding entry to the database
                if($this->create()) {
                    // We are done with temp_path, the file isn't there anymore
                    unset($this->temp_path);
                    return true;
                }
            } else {
                // Failure
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }
            
            
        }
    }
    
    public function destroy() {
        // First remove the database entry
        if($this->delete()) {
            // then remove the file
            $target_path = $this->image_path();
            //var_dump($target_path);
            return (unlink($target_path)) ? true : false;
        } else {
            return false;
        }
        
    }
}

?>