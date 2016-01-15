<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

include_layout_template('header3.php'); 
include_layout_template('admin_navigation.php'); 
?>

<div class="container-fluid" id="container">
    <div class="display_content">

        <?php echo output_message($message); ?>
        <div class="row">
            <div class="col-xs-12">
            <div class="col-xs-10"> 
                <h1>Manage Calendar Events</h1>
            </div>
            <div class="col-xs-2" style="margin-top: 15px;">
                <a href="create_calendar_event.php?nav=5" class="btn btn-info pull-right" role="button">Add new calendar event</a>
            </div>
            </div>
        </div>

        <table id="calendar_events" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Event Location</th>
                    <th>Event Description</th>
                    <th>Event Type</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php echo Calendar_Event::get_event_list(); ?>
            </tbody>

        </table>

        <p><a href="create_calendar_event.php?nav=5" class="btn btn-info" role="button">Add new calendar event</a></p>



    </div>
</div>

<?php include_layout_template('footer2.php');  ?>  