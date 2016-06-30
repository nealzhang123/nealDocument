<?php
function vc_orane_custom_textarea($settings, $value) {

   $dependency = vc_generate_dependencies_attributes($settings);

   return '<textarea name="'.$settings['param_name']
             .'" class="orane_custom_text_class wpb_vc_param_value '
             .$settings['param_name'].' '.$settings['type'].'_field" type="textarea"  '.$dependency.'>'.$value.'</textarea>';

}
add_shortcode_param('orane_textfield', 'vc_orane_custom_textarea');

?>