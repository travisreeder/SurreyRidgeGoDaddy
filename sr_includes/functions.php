<?php
function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
//  if ($location != NULL) {
//    //var_dump($location);
//    header("Location: {$location}");
//    exit;
//  }
    if(!headers_sent()) {
        //If headers not sent yet... then do php redirect
        header('Location: '.$location);
        exit;
    } else {
        //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$location.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
        echo '</noscript>';
        exit;
    }
}

function output_message($message="") {
    if (!empty($message)) { 
        //return "<p class=\"message\">{$message}</p>";
        $output = "<div class=\"alert alert-info fade in\">";
        $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
        $output .= "<strong>Message:</strong> {$message}";
        $output .= "</div>";
        return $output;
    } else {
        return "";
    }
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'layouts'.DS.$template);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function datetime_to_short_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%m/%d/%Y %I:%M %p", $unixdatetime);
}

function get_gmail_password() {
    return "tr19av65";
}

function get_timestamp($date_str, $hour, $min, $ampm) {
    if ($ampm == "PM" && ((int) $hour < 12)) {
        $hour = (int) $hour + 12;
    }
    else if ($ampm == "AM" && (int) $hour == 12) {
        $date_str = date('Y-m-d', strtotime('-1 day', strtotime($date_str)));
        $hour = (int) $hour + 12;
    }
    
    $datetime_string = $date_str." ".$hour.":".$min;
    
    //var_dump($datetime_string);
    
    $date_to_convert = date($datetime_string);
    //var_dump($date_to_convert);
    
    $time = strtotime($date_to_convert);
    
    //echo "Date to convert: ".$date_to_convert."</br>";
    //echo "Time: ".$time."</br>";
    return $time;
}

?>