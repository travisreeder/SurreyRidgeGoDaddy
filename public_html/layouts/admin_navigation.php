<?php    
echo "<div class=\"row\" id=\"wrapper\">";
echo "<nav class=\"navbar navbar-default navbar-fixed-top navbar-inverse navbar-custom gradient\">";
echo "<div class=\"navbar-header\">";
echo "<a class=\"navbar-brand\" href=\"manage_content.php\"><img class=\"avatar\" alt=\"Surrey Ridge Logo\" src=\"../images/surrey_logo.png\"></a>";
echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#collapse\">";
echo "<span class=\"sr-only\">Toggle navigation</span>MENU";
echo "</button>";
echo "</div>";
echo "<div class=\"collapse navbar-collapse\" id=\"collapse\">";
echo "<ul class=\"nav navbar-nav\">";
if(isset($_GET["nav"])) {$selected_nav = $_GET["nav"];} else {$selected_nav="";}
echo "<li class=\"dropdown\"><a href=\"#\" data-toggle=\"dropdown\">Content<span class=\"caret\"></span></a>";
echo Navigation::manage_content_navigation();                                 
echo "</li>";
if($selected_nav == 2) {
    echo "<li class=\"active\">";
} else {
    echo "<li>";
}   
echo "<a href=\"../admin/manage_users.php?nav=2\" title=\"Users\">Users</a></li>";                       
if($selected_nav == 3) {
    echo "<li class=\"active\">";
} else {
    echo "<li>";
}   
echo "<a href=\"../admin/manage_documents.php?nav=3\" title=\"Documents\">Documents</a></li>";
if($selected_nav == 4) {
    echo "<li class=\"active\">";
} else {
    echo "<li>";
}   
echo "<a href=\"../admin/manage_visitors.php?nav=4\" title=\"Visitors\">Visitors</a></li>";
if($selected_nav == 5) {
    echo "<li class=\"active\">";
} else {
    echo "<li>";
}   
echo "<a href=\"../admin/manage_desclists.php?nav=5\" title=\"Lists\">Lists</a></li>";
echo "<li><a href=\"../admin/logout.php\">Logout</a></li>";
echo "</ul>";
echo "</div>";
echo "</nav>";
echo "</div>";
?>