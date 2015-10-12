<?php
require_once("../../sr_includes/initialize.php");

include_layout_template('header.php'); 
include_layout_template('navigation2.php');
?>

    <div class="container">
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</div>
    
    
<?php include_layout_template('footer.php'); ?>