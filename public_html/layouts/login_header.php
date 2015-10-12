<?php
// FOR pages on SITE ROOT/public_html/admin
if (!isset($layout_context)) {
    $layout_context = "public";
}
?>
<?php require_once("../../sr_includes/initialize.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="description" content="Surrey Ridge HOA Administration Page">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        
        <script src="../script/respond.js"></script>
        
		<link rel="stylesheet" type="text/css" href="../css/index_theme.css"/>
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="../ckeditor/ckeditor.js"></script>
        
        <title>Travis' Site - Administration</title>
	</head>
    
    <body style="padding-top: -50px">
		
        