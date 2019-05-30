<?php 

/* contact form7 でPHPファイルの読み込みを行う
-------------------------------------------------------------------*/
if (function_exists('wpcf7_add_form_tag')) {
    function wpcf7_inc() {
        ob_start();
        include(STYLESHEETPATH . "/filename.php");
        return ob_get_clean();
    }
    wpcf7_add_form_tag( 'cf7inc', 'wpcf7_inc' );
}

/* ホームURLを出力
-------------------------------------------------------------------*/
function home() {
    return esc_url(home_url( '/' ));
}
add_shortcode('home', 'home');


/* テーマパスを出力
-------------------------------------------------------------------*/
function path() {
    return get_template_directory_uri();
}
add_shortcode('path', 'path');