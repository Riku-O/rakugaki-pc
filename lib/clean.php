<?php 

/* 絵文字用のJSとCSSを削除
-------------------------------------------------------------------*/
remove_action('wp_head','print_emoji_detection_script',7);
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('wp_print_styles','print_emoji_styles');
remove_action('admin_print_styles','print_emoji_styles');

/* 短縮URLの削除 
-------------------------------------------------------------------*/
remove_action('wp_head', 'wp_shortlink_wp_head');

/* Edit URI 削除
-------------------------------------------------------------------*/
remove_action('wp_head','rsd_link');

/* wlwmanifest 削除 
-------------------------------------------------------------------*/
remove_action('wp_head','wlwmanifest_link');

/* Generator 削除
-------------------------------------------------------------------*/
remove_action('wp_head','wp_generator');

/* canonical 削除
-------------------------------------------------------------------*/
remove_action('wp_head', 'rel_canonical');

/* Embed 削除
-------------------------------------------------------------------*/
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

/* autop 削除
-------------------------------------------------------------------*/
add_action('init', function() {
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_content', 'wpautop');
});
add_filter('tiny_mce_before_init', function($init) {
    $init['wpautop'] = false;
    $init['apply_source_formatting'] = ture;
    return $init;
});

/* body_class 不要なクラス 削除
-------------------------------------------------------------------*/
function _remove_body_class( $wp_classes, $extra_classes ) {
    $wp_classes = preg_grep( "/template|\d/", $wp_classes, PREG_GREP_INVERT );
    return array_merge( $wp_classes, (array) $extra_classes );
}
add_filter( 'body_class', '_remove_body_class' , 10, 2 );

/* nav_menu 不要なIDとクラス 削除
-------------------------------------------------------------------*/
function karakuri_optimize_menu_id() {
    return '';
}
add_filter('nav_menu_item_id', 'karakuri_optimize_menu_id');

function theme_optimize_menu_class($classes, $item) { 
    return array('menu-item');
}
add_filter('nav_menu_css_class', 'theme_optimize_menu_class', 10, 2);

/* WPバージョン表記をソースから削除
-----------------------------------------*/
function vc_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
