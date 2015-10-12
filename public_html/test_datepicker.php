<?php
require_once("../../sr_includes/initialize.php");

include_layout_template('header.php'); 
include_layout_template('navigation2.php');


if (isset($_POST['submit'])) {
    $date_str = $_POST["fromdate"];
    $hour = $_POST["fromhour"];
    $min = $_POST["frommin"];
    $ampm = $_POST["fromampm"];
    
    //var_dump($date_str);
    //var_dump($hour);
    //var_dump($min);
    //var_dump($ampm);
    
    $time = get_timestamp($date_str, $hour, $min, $ampm);
//    if ($ampm == "AM") {
//        $datetime_string = $date_str." ".$hour.":".$min;
//    } else {
//        $hour = (int) $hour + 12;
//        $datetime_string = $date_str." ".$hour.":".$min;
//    }
    
    //var_dump($datetime_string);
    
//    $date_to_convert = date($datetime_string);
//    //var_dump($date_to_convert);
//    
//    $time = strtotime($date_to_convert)."</br>";
//    
//    echo "Date to convert: ".$date_to_convert."</br>";
    echo "Time: ".$time."</br>";
    
    //$date = DateTime::createFromFormat($format, 
    
    
}

?>
<div class="container-fluid" id="container">
    <div class="form-area">
        <form role="form" action="test_datepicker.php" method="post" >
        <div class="row">
            <p></p>
        </div>


            <div class="row">
                <div class="col-xs-5 date_size_fixed">
                    <div class="form-group">
                        <div class='input-group date'>
                            <input type='text' class="form-control" name="fromdate" placeholder="Select Date" required value="<?php echo isset($_POST['fromdate']) ? $_POST['fromdate'] : ""; ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>

                        </div> 
                    </div>
                </div>

                    <div class="col-xs-7">

                        <div class="col-xs-4 time_size_fixed">

                            <select class="selectpicker form-control" name="fromhour" required>
<!--                                <option value="H">H</option>-->
                                <?php for($i=1; $i<=12; $i++) {
                                    if(!isset($_POST["fromhour"])) {
                                        if($i==12) {
                                            echo "<option value=\"$i\" selected>{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\">{$i}</option>";
                                        }
                                    } else {
                                        if((int) $_POST["fromhour"] == $i) {
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
<!--                                <option value="M">M</option>-->
                                <?php for($i=0; $i<=59; $i += 15) {
                                    if(!isset($_POST["frommin"])) {
                                        if($i==0) {
                                            echo "<option value=\"$i\" selected>:0{$i}</option>";
                                        } else {
                                            echo "<option value=\"$i\">:{$i}</option>";
                                        }
                                    } else {
                                        if((int) $_POST["frommin"] == $i) {
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

                            <select class="selectpicker form-control" name="fromampm" data-size="3">
                                <?php 
                                if(!isset($_POST["fromampm"])) {
                                    echo "<option value=\"AM\" selected>AM</option>";
                                    echo "<option value=\"PM\">PM</option>";
                                } else {
                                    if($_POST["fromampm"] == "AM") {
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
                    </div>


    <!--
                <div class="col-xs-4">
                    <input type="time" class="form-control" />
                </div>
    -->
            </div>
            <input class="btn btn-info" type="submit" name="submit" value="Submit Form" />
        </form>
    </div>

</div>
    
    
<?php include_layout_template('footer.php'); ?>