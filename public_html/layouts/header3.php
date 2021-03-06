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
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" >
        <link rel="stylesheet" type="text/css" href="../css/calendar.min.css">
        
        <script src="../script/respond.js"></script>
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
        
        <link rel="stylesheet" type="text/css" href="../css/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap-select.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/index_theme.css"/>
		
        
        <script src="../ckeditor/ckeditor.js"></script>
        <title>Surrey Ridge HOA - Administration</title>
	</head>
    
    <body>
		
        