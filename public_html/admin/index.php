<?php $layout_context = "admin" ?>
<?php require_once("../../sr_includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php include_layout_template('header3.php'); ?>
<?php include_layout_template('admin_navigation.php'); ?>

<?php redirect_to("manage_content.php"); ?>
<!--
            <div class="container-fluid" id="container">
                <div class="display_content">
                <h1>Administration</h1>
                <h2>Welcome to my administration site!</h2>
                <h3>This is the H3 line</h3>
                <h4>This is the H4 line</h4>
                <h4>This another the H4 line</h4>
                <div id="example">
                </div>
                </div>
            </div>
-->

 <?php include_layout_template('footer2.php'); ?>      
