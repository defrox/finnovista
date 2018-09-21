<?php
header("Content-type: text/css");

if(file_exists('../../../../wp-load.php')) :
  include '../../../../wp-load.php';
else:
  include '../../../../../wp-load.php';
endif;

@ob_flush();
?>

/*==========================================================================================

This file contains styles related to the user settings of the theme

==========================================================================================*/

body{
    <?php if(stag_get_option('style_custom_font') != ''){
        $fontname = stag_get_font_face(stag_get_option('style_custom_font'));
        echo 'font-family: "'.$fontname.'";';
    } ?>
}


<?php @ob_end_flush(); ?>