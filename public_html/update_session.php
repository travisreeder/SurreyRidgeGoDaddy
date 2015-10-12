<?php
session_start();
$_SESSION['checked'] = $_GET['checked'] ? 1 : 0;
//var_dump($_SESSION);
?>