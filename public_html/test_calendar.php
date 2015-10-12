<?php
require_once("../../sr_includes/initialize.php");

include_layout_template('header.php'); 
include_layout_template('navigation2.php');
?>
        <div class="container-fluid" id="container">
            <div class="display_content">
            <h1>Community Calendar</h3><br />
            <p>Navigate this calendar to view upcoming community events.</p>
        
            <div id="date-popover" class="popover top">
                <div id="date-popover-content" class="popover-content"></div>
            </div>
            <!-- define the calendar element -->
            <div id="community-calendar"></div>
            </div>
        </div>

        <!-- initialize the calendar on ready -->
        <script type="application/javascript">
            $(document).ready(function () {
                $("#community-calendar").zabuto_calendar();
            });
        </script>

<?php include_layout_template('test_footer.php'); ?>