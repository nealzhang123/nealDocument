<?php  
function lineToSpanColor($title){

     $title1 = preg_replace("/\|(.+?)\|/", "<span class='color'>$1</span>", $title);
     //print_r($match);

  /*   if( !empty($match) ){
      $tt = $match[1];
     // $title = str_replace("|{$tt}|", "<span class='color'>{$tt}</span>", $title);
     } */

     return $title1;

}

function lineToBold($title){
     $title1 = preg_replace("/\|(.+?)\|/", "<b>$1</b>", $title);
     return $title1;
}


function orane_add_inline_css($selector, $css, $value){
        $value_out = get_theme_mod( $value ); //E.g. #FF0000
        echo 1;
        $custom_css = "
                {$selector}{
                        {$css}: {$value_out};
                }";
        wp_add_inline_style('orane-css-compile', $custom_css );
}

?>