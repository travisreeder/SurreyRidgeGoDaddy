<?php

//echo "QUERY_STRING: ". $_SERVER['QUERY_STRING'] ."<br />";

$form_parameters = "";
if(isset($_SESSION['form_parameters'])) {
    //echo $_SESSION['form_parameters'];
    $form_parameters = $_SESSION['form_parameters'];
}

//include_layout_template('header.php'); 
//include_layout_template('navigation2.php'); 
?>

                            <?php if(!$form_parameters || strpos($form_parameters, ",")) { ?>
                                <table id="view_documents" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                            <?php } else { ?>
                                <table id="view_documents2" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                            <?php } ?>
                                <thead>
                                    <tr>
                                        <?php if(!$form_parameters || strpos($form_parameters, ",")) { ?>
                                            <th>Document Type</th>
                                        <?php } ?>
                                        <th>Fiscal Year</th>
                                        <th>Document Title</th>
                                        <th>Filename</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo Document::get_document_list($form_parameters,true); ?>
                                </tbody>

                            </table>
                            


