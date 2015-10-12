<?php require_once("../../sr_includes/initialize.php"); ?>
<?php	
    $session->logout();
    redirect_to("login.php");
?>
