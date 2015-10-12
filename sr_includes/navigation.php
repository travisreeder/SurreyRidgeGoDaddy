<?php
require_once(LIB_PATH.DS.'database.php');

class Navigation {
    public $subjects;
    public $pages;
    
    public static function admin_navigation($current_subject, $current_page, $public=false) {
        $output = "<div class=\"row\">";
        $output .= "<ul class=\"subjects\">";
        //$subject_object = new Subject;
        $subjects = Subject::find_all($public);
        
        //var_dump($subjects);
        
        foreach($subjects as $subject) {
            //$output .= "<div class=\"row\">";
            //$output .= "<div class=\"col-xs-2\">";
            $output .= "<li";
	        if ($current_subject && $subject->id == $current_subject->id) {
	            $output .= " class=\"selected\"";
	        }
            //area to set selected class
            $output .= ">";
            $output .= "<a href=\"manage_content.php?nav=1&subject=";
            $output .= urlencode($subject->id);
            $output .= "\">";
            $output .= htmlentities($subject->menu_name);
            $output .= "</a>";
            
            $output .= self::page_navigation($subject->id, $current_page, $public);
			$output .= "</li>";
            //$output .= "</div>";
            //$output .= "</div>";
        }
		$output .= "</ul>";
        $output .= "</div>";
		
        return $output;
    }
    
    public static function page_navigation($subject_id, $current_page, $public=true) {
        //$output = "<ul class=\"pages\">";
        //$output = "<div class=\"row\">";
		if($public) {
        	$output = "<ul class=\"dropdown-menu\">";
		} else {
			$output = "<ul class=\"dropdown-menu\">";
		}
        //$page_object = new Page;
        $pages = Page::find_pages_for_subject($subject_id, $public);
        
        //var_dump($pages);
        
        foreach($pages as $page) {
            $output .= "<li" ;
            //area to set selected class
	        if ($current_page && $page->id == $current_page->id) {
				if($public) {
	            	$output .= " class=\"active\"";
				} else {
					$output .= " class=\"selected\"";
				}
	        }
            $output .= ">";
			if($public) {
            	$output .= "<a href=\"view_content.php?page=";
			} else {
				$output .= "<a href=\"manage_content.php?nav=1&page=";
			}
            $output .= urlencode($page->id);
            $output .= "&subject=";
            $output .= urlencode($subject_id);
            $output .= "\">";    
            $output .= htmlentities($page->menu_name);
            $output .= "</a>";
            $output .= "</li>";
            }
        $output .= "</ul>";
        //$output .= "</div>";
        return $output;
    }
	
	public static function navigation_bar($current_subject, $fromroot=true) {
		$subjects = Subject::find_all(true);
        //$selected_subject = (int)$_SESSION['selected_subject'];
        $selected_subject;
        if(isset($_GET['subject'])) {
            $selected_subject = $_GET['subject'];
        }
        //var_dump($selected_subject);
        
		$output = "<ul class=\"nav_bar\">";
		foreach($subjects as $subject) {
            $output .= "<li" ;
			if (!empty($selected_subject) && $subject->id == $selected_subject) {
	            $output .= " class=\"active\"";
	        }
            $output .= ">";
			if($fromroot) {
				$output .= "<a href=\"public_html".DS."view_content.php?subject=";
			} else {
				$output .= "<a href=\"view_content.php?subject=";
			}
	        $output .= urlencode($subject->id);
	        $output .= "\">";    
	        $output .= htmlentities($subject->menu_name);
			$output .= "</a> ";
            $output .= "</li>";
		}
		//var_dump($subjects);
        $output .= "</ul>";
		return $output;	
	}
    
    public static function navigation_bar_w_children($current_subject, $current_page, $fromroot=true) {
		$subjects = Subject::find_all(true);
        //$selected_subject = (int)$_SESSION['selected_subject'];
        $selected_subject;
        if(isset($_GET['subject'])) {
            $selected_subject = $_GET['subject'];
        }
        $output = "<div class=\"row\" id=\"wrapper\">";
        $output .= "<nav class=\"navbar navbar-default navbar-fixed-top navbar-inverse navbar-custom gradient\">";
        
        $output .= "<div class=\"navbar-header\">";
        
        $output .= "<a class=\"navbar-brand\" href=\"view_content.php?subject=1\">";
        $output .= "<img class=\"avatar\" alt=\"Surrey Ridge Logo\" src=\"images/surrey_logo.png\">";
        $output .= "</a>";
        
               
        $output .= "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#collapse\">";
        $output .= "<span class=\"sr-only\">Toggle navigation</span>";
        $output .= "<span class=\"glyphicon glyphicon-arrow-down\"></span>";
        $output .= "MENU";
        $output .= "</button>";
        $output .= "</div>";
        
        $output .= "<div class=\"collapse navbar-collapse\" id=\"collapse\">";
        
        
		$output .= "<ul class=\"nav navbar-nav\">";
		foreach($subjects as $subject) {
            $output .= "<li" ;
			if (!empty($selected_subject) && $subject->id == $selected_subject) {
	            $output .= " class=\"dropdown\"";
	        }
            $output .= ">";
			if($fromroot) {
				$output .= "<a href=\"public_html".DS."view_content.php?subject=";
			} else {
				$output .= "<a href=\"view_content.php?subject=";
			}
	        $output .= urlencode($subject->id)."\"";
			        
            if(Page::count_pages_for_subject($subject->id) > 0) {
                $output .= " data-toggle=\"dropdown\""; 
                $output .= ">";
                $output .= htmlentities($subject->menu_name);
                $output .= "<span class=\"caret\"></span> </a> ";
                $output .= self::page_navigation($subject->id, $current_page, $public=true);
            } else {
                $output .= ">";
                $output .= htmlentities($subject->menu_name);
                $output .= "</a>";
            }
            
            $output .= "</li>";
		}
		//var_dump($subjects);
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</nav>";
        $output .= "</div>";
		return $output;	
	}
    
    public static function manage_content_navigation() {
		$subjects = Subject::find_all(false);
        
		$output = "<ul class=\"dropdown-menu\">";
        $output .= "<li><a href=\"new_subject.php\">Add a Subject</a></li>";
        $output .= "<li class=\"divider\"></li>";
		foreach($subjects as $subject) {    
            
            if(Page::count_pages_for_subject($subject->id) > 0) {
                $output .= "<li class=\"dropdown-submenu\">";
                $output .= "<a href=\"manage_content.php?subject=";
                $output .= urlencode($subject->id)."\"";
                $output .= ">"; 

                $output .= htmlentities($subject->menu_name);
                $output .= "</a> ";
                $output .= self::page_navigation($subject->id, null, $public=false);
            } else {
                $output .= "<li>";
                $output .= "<a href=\"manage_content.php?subject=";
                $output .= urlencode($subject->id)."\"";
                $output .= ">";
                $output .= htmlentities($subject->menu_name);
                $output .= "</a>";
            }
            
            $output .= "</li>";
		}
		//var_dump($subjects);
        $output .= "<li class=\"divider\"></li>";
        $output .= "<li><a href=\"edit_marquee.php\">Edit Marquee</a></li>";
        $output .= "<li class=\"divider\"></li>";
        $output .= "<li><a href=\"manage_calendar_events.php\">Calendar Events</a></li>";
        
        $output .= "</ul>";
		return $output;	
	}
}
?>