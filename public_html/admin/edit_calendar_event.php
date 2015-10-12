<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

$current_event = Calendar_Event::find_by_id($_GET["id"]);

if(!$current_event) {
    redirect_to("manage_calendar_events.php");
}

$current_from_date = date('m/d/Y', $current_event->start);
$current_from_hour = date('h', $current_event->start);
$current_from_min = date('i', $current_event->start);
$current_from_ampm = date('A', $current_event->start);

$current_to_date = date('m/d/Y', $current_event->end);
$current_to_hour = date('h', $current_event->end);
$current_to_min = date('i', $current_event->end);
$current_to_ampm = date('A', $current_event->end);
 
//var_dump($current_from_date);
//var_dump($current_from_hour);
//var_dump($current_from_min);
//var_dump($current_from_ampm);   

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php');

if (isset($_POST['submit'])) {
    $date_str = $_POST["fromdate"];
    $hour = $_POST["fromhour"];
    $min = $_POST["frommin"];
    $ampm = $_POST["fromampm"];
    
    $start = get_timestamp($date_str, $hour, $min, $ampm);
    
    $date_str = $_POST["todate"];
    $hour = $_POST["tohour"];
    $min = $_POST["tomin"];
    $ampm = $_POST["toampm"];
    
    $end = get_timestamp($date_str, $hour, $min, $ampm);

    //var_dump($start);
    //var_dump($end);
    
    
    $current_event->event_title = $database->escape_value($_POST["event_title"]);
    $current_event->event_description = $_POST["event_description"];
    $current_event->event_class = $database->escape_value($_POST["event_class"]);    
    $current_event->start = (int) $start;
    $current_event->end = (int) $end; 
    
    if($current_event->save()) {
        // Success
        $session->message("Event saved successfully.");
        redirect_to("manage_calendar_events.php");
    } else {
        // Failure
        $session->message("Event save failed.");
    }
    //echo "Time: ".$time."</br>";
    
}
?>
<div class="container-fluid" id="container">
    <div class="display_content">
        <div class="row">
            <div class="col-sx-12">
                <?php echo output_message($message); ?>
                <h2>Edit Calendar Event</h2>
            </div>
        </div>
        
        <form class="form-horizontal" role="form" action="edit_calendar_event.php?id=<?php echo urlencode($current_event->id); ?>" method="post" >
       
            <div class="form-group">
                <label class="col-xs-12" for="event_title">Event Title:</label>
                <div class="col-xs-12">
                    <input class="form-control" type="text" name="event_title" placeholder="Event Title" required value="<?php echo $current_event->event_title ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12" for="event_class">Event Type:</label>
                    <div class="col-xs-12">
                        <select class="form-control" name="event_class">
                            <?php
                            $local_event = new Calendar_Event();
                            //var_dump($local_event->event_classes);
                            while (list($key, $val) = each($local_event->event_classes)) {
                                echo "$key => $val\n";
                                echo "<option value=\"{$key}\"";
                                if($key == $current_event->event_class) {
                                    echo " selected"; 
                                }
                                echo ">{$val}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="event_description">Event Description:</label>
                <div class="col-xs-12">
                    <textarea name="event_description" id="editor1" rows="10" cols="80"><?php echo htmlentities($current_event->event_description); ?></textarea>
                    <script>
                        // Replace the <textarea id="editor1" with a CKEditor
                        // instance, using default configuration
                        CKEDITOR.replace('editor1');
                    </script>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12" for="event_start">Event Start Date/Time:</label>
                <div class="col-xs-5 date_size_fixed">
                    <div class='input-group date'>
                        <input type='text' class="form-control" name="fromdate" placeholder="Select Date" required value="<?php echo $current_from_date ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div> 
                </div>

                <div class="col-xs-7">
                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control" name="fromhour" required>
                            <?php for($i=1; $i<=12; $i++) {
                                if(!isset($current_from_hour)) {
                                    if($i==12) {
                                        echo "<option value=\"$i\" selected>{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">{$i}</option>";
                                    }
                                } else {
                                    if((int) $current_from_hour == $i) {
                                        echo "<option value=\"$i\" selected>{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">{$i}</option>";
                                    }
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control" name="frommin" required>
                            <?php for($i=0; $i<=59; $i += 15) {
                                if(!isset($current_from_min)) {
                                    if($i==0) {
                                        echo "<option value=\"$i\" selected>:0{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">:{$i}</option>";
                                    }
                                } else {
                                    if((int) $current_from_min == $i) {
                                        if($i==0) {
                                            echo "<option value=\"$i\" selected>:0{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\" selected>:{$i}</option>";
                                        }
                                    } else {
                                        if($i==0) {
                                            echo "<option value=\"$i\">:0{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\">:{$i}</option>";
                                        }
                                    }
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control input-sm" name="fromampm" data-size="3">
                            <?php 
                            if(!isset($current_from_ampm)) {
                                echo "<option value=\"AM\" selected>AM</option>";
                                echo "<option value=\"PM\">PM</option>";
                            } else {
                                if($current_from_ampm == "AM") {
                                    echo "<option value=\"AM\" selected>AM</option>";
                                    echo "<option value=\"PM\">PM</option>";
                                } else {
                                    echo "<option value=\"AM\">AM</option>";
                                    echo "<option value=\"PM\" selected>PM</option>";
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div> <!-- End Div class="col-xs-7" for Date/Time Grouping -->
            </div> <!-- Emd Div class="form-group" for Start Date/Time Grouping -->
            
                        <div class="form-group">
                <label class="col-xs-12" for="event_end">Event End Date/Time:</label>
                <div class="col-xs-5 date_size_fixed">
                    <div class='input-group date'>
                        <input type='text' class="form-control" name="todate" placeholder="Select Date" required value="<?php echo $current_to_date ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div> 
                </div>

                <div class="col-xs-7">
                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control" name="tohour" required>
                            <?php for($i=1; $i<=12; $i++) {
                                if(!isset($current_to_hour)) {
                                    if($i==12) {
                                        echo "<option value=\"$i\" selected>{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">{$i}</option>";
                                    }
                                } else {
                                    if((int) $current_to_hour == $i) {
                                        echo "<option value=\"$i\" selected>{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">{$i}</option>";
                                    }
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control" name="tomin" required>
                            <?php for($i=0; $i<=59; $i += 15) {
                                if(!isset($current_to_min)) {
                                    if($i==0) {
                                        echo "<option value=\"$i\" selected>:0{$i}</option>";
                                    } else {
                                        echo "<option value=\"$i\">:{$i}</option>";
                                    }
                                } else {
                                    if((int) $current_to_min == $i) {
                                        if($i==0) {
                                            echo "<option value=\"$i\" selected>:0{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\" selected>:{$i}</option>";
                                        }
                                    } else {
                                        if($i==0) {
                                            echo "<option value=\"$i\">:0{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\">:{$i}</option>";
                                        }
                                    }
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col-xs-4 time_size_fixed">
                        <select class="selectpicker form-control input-sm" name="toampm" data-size="3">
                            <?php 
                            if(!isset($current_to_ampm)) {
                                echo "<option value=\"AM\" selected>AM</option>";
                                echo "<option value=\"PM\">PM</option>";
                            } else {
                                if($current_to_ampm == "AM") {
                                    echo "<option value=\"AM\" selected>AM</option>";
                                    echo "<option value=\"PM\">PM</option>";
                                } else {
                                    echo "<option value=\"AM\">AM</option>";
                                    echo "<option value=\"PM\" selected>PM</option>";
                                }
                            } 
                            ?>
                        </select>
                    </div>
                </div> <!-- End Div class="col-xs-7" for Date/Time Grouping -->
            </div> <!-- Emd Div class="form-group" for End Date/Time Grouping -->
            <input class="btn btn-primary" type="submit" name="submit" value="Save" />
            <a class="btn btn-info" href="manage_calendar_events.php">Cancel</a>
        </form>
    </div>    

</div>
    
    
<?php include_layout_template('footer2.php'); ?>