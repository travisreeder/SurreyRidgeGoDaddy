<?php
require_once("../../sr_includes/initialize.php");

include_layout_template('header.php'); 
include_layout_template('navigation2.php');
?>

<div class="container-fluid" id="container">
    <div class="row" style="background-color: blue; color: white">
      <div class="col-sm-9">
        Level 1: .col-sm-9
        <div class="row" style="background-color: green; color: white">
          <div class="col-xs-8 col-sm-6">
            Level 2: .col-xs-8 .col-sm-6
          </div>
          <div class="col-xs-4 col-sm-6">
            Level 2: .col-xs-4 .col-sm-6
          </div>
        </div>
      </div>
    </div>    
</div>
    
    
<?php include_layout_template('footer.php'); ?>