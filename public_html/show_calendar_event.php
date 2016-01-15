<?php
require_once("../sr_includes/initialize.php");

$current_event = Calendar_Event::find_by_id($_GET["id"]);

if(!$current_event) {
        // subject ID was missing or invalid or
        // subject couldn't be found in databgase
        redirect_to("view_content.php");
}
?>

<div class="container-fluid" id="container">
    <div class="display_content">
        
        <p><b>Location: </b><?php echo $current_event->event_location ?></p>
        
        <table style="border-spacing 0px; border: 0; padding: 0; margin: 0">
            <tr>
                <td>
                    <b>Start:</b>
                </td>
                <td>
                     <?php echo date('d-M-Y', $current_event->start); ?>
                </td>
                <td>
                     at <?php echo date('g:ia', $current_event->start); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>End:</b>
                </td>
                <td>
                    <?php echo date('d-M-Y', $current_event->end); ?>
                </td>
                <td>
                     at <?php echo date('g:ia', $current_event->end); ?>
                </td>
            </tr>
        </table>
        
        <p><?php echo $current_event->event_description ?></p>
        
        
    </div>
</div>
