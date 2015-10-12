<?php
// FOR pages on SITE ROOT/public
if (!isset($layout_context)) {
    $layout_context = "public";
}
?>
<?php require_once("../sr_includes/initialize.php"); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="description" content="Surrey Ridge HOA Home Page">
        <meta name="viewport" content="width=device-width">
        
		<link rel="stylesheet" type="text/css" href="../public_html/css/index_theme.css"/>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

        <title>Surrey Ridge HOA</title>
	</head>
    
    <body>
        <header>
            <div id="headline" class="gradient">
                <img class="avatar" src="../public_html/images/surrey_logo.png" alt="Surrey Ridge Logo">
                <a href="view_content.php"><h2 class="opposite gradient">Welcome to Surrey Ridge HOA's Site</h2></a>
            </div>
        </header>
		
        