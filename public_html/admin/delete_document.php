<?php
require_once("../../sr_includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}
//$subjects = Subject::find_all();
$current_document = Document::find_by_id($_GET["id"]);

if(!$current_document) {
        redirect_to("manage_documents.php");
}

if($current_document && $current_document->destroy()) {
    $session->message("The document {$current_document->filename} was deleted.");
    redirect_to("manage_documents.php");
} else
{
    $session->message("Document deletion failed.");
    redirect_to("manage_documents.php");
}
?>