<?php
require_once("../sr_includes/initialize.php");

//$subjects = Subject::find_all();
$current_subject = "";
$current_page = "";
$current_subject = Subject::find_selected_subject(false);
$current_page = Page::find_selected_page(false);

if($current_page && $current_page->form_parameters) {
    $_SESSION['form_parameters'] = $current_page->form_parameters;
}

$checked = 0;
if(isset($_SESSION['checked'])) {
    $checked = $_SESSION['checked'];
}

//if($current_subject) {
//    $current_page = Page::find_default_page_for_subject($current_subject->id, false);
//} 



//var_dump($current_page);
//var_dump($current_subject);

include_layout_template('header.php'); 
include_layout_template('navigation2.php');
?>
            <!--
            <div id="main">
            -->

            <?php
            $marquee = Marquee::find_all(true);
            if ($marquee) {
                //echo "<div id=\"alert-marquee\" class=\"alert alert-info\">";
                
//                    echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
                    echo "<div id=\"alert-marquee\" class=\"marquee\">";
                        foreach($marquee as $marquee_row) {
                            echo "<p>{$marquee_row->marquee_text}</p>";
                        }
                    echo "</div>";
                //echo "</div>";
                //var_dump($_SESSION);
            }
            echo "<div class=\"row pull-right\" style=\"margin-right: 10px;\">";
            if($checked) {
                echo "<input id=\"toggle-event\" type=\"checkbox\" data-toggle=\"toggle\" data-on=\"Show Marquee\" data-off=\"Hide Marquee\" data-size=\"mini\" data-width=\"100\" checked>";
                } else {
                    echo "<input id=\"toggle-event\" type=\"checkbox\" data-toggle=\"toggle\" data-on=\"Show Marquee\" data-off=\"Hide Marquee\" data-size=\"mini\" data-width=\"100\">";
                }
            echo "</div>";
            ?>

            
    
<!--
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Simple collapsible</button>
            <input type="checkbox" checked data-toggle="toggle" data-target="#demo" data-size="mini">
            <div id="demo" class="collapse">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
-->
            


            <div class="container-fluid" id="container">
                <div class="display_content">
		    
            
		        <?php echo output_message($message); ?>
				<?php
		        if ($current_page) { ?>
                    <?php if ($current_page->show_menu == 1) { ?>
                        <div class="row">
                            <div class="col-xs-12">
                               <h2> <?php echo $current_page->menu_name; ?></h2>
                            </div>
                        </div>
                    <?php } ?>
		            <div class="row">
                        <div class="col-xs-12">
                            <?php echo ($current_page->content); ?>
		                  </div>
                    </div>
					<!-- <div class="dynamic_page"> -->
						<?php if($current_page->url != "") { include($current_page->url); } ?>
					<!-- </div> -->
		         <?php } else { ?>
 						<?php if($current_subject && $current_subject->url != "") { include($current_subject->url); } ?>
		        <?php } ?>
            
		      </div>
            </div>
            <!--
            </div>
            -->
<?php include_layout_template('footer.php'); ?>
<script>
        function hide_marquee() {
            //alert('inside hide marquee');
            $('#alert-marquee').hide();
            $('body').css('padding-bottom', '53px');
            //$('.footer').css('color', 'green');
        };

        function show_marquee() {
            //alert('inside show marquee');
            $('#alert-marquee').show();
            $('body').css('padding-bottom', '105px');
            //$('.footer').css('color', 'red');
        };
</script>

<?php unset($_SESSION['form_parameters']); ?>

<?php 
if(!$checked) {
    echo "<script>show_marquee()</script>";
} else {
    echo "<script>hide_marquee()</script>";
}
?>