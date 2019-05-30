<?php 

/* body classへpage-slugクラスも追加
-------------------------------------------------------------------*/
function pagename_class($classes = '') {
    if (is_page()) {
        $page = get_post(get_the_ID());
        $classes[] = $page->post_name;
        if ($page->post_parent) {
            $classes[] = 'page-' . get_page_uri($page->post_parent) . '-child';
        }
    }
    return $classes;
}
add_filter('body_class', 'pagename_class');

/* excerptの省略文字および文字数
-------------------------------------------------------------------*/
function my_excerpt_more($more) {
    return '…';
}
add_filter('excerpt_more', 'my_excerpt_more');

function twpp_change_excerpt_length( $length ) {
  return 70; 
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );

/* Feedをサポート
-------------------------------------------------------------------*/
add_theme_support( 'automatic-feed-links' );

/* アイキャッチを利用可能にする
-------------------------------------------------------------------*/
add_theme_support( 'post-thumbnails' );

/* ウィジェットでショートコードを利用可能にする
-------------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');

/* wp_nav_menu 位置の追加
-------------------------------------------------------------------*/
register_nav_menus(array(
    'header_menu' => 'ヘッダーメニュー',
    'footer_menu' => 'フッターメニュー',
));

/* WP コアからの出力されるタグをHTML5へ
-------------------------------------------------------------------*/
add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
) );

/* カスタマイザーでfaviconを設定可能に
-------------------------------------------------------------------*/
function my_site_icon_meta_tags($meta_tags) {
    $meta_tags = array(
        sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( get_site_icon_url( 32 ) ) ),
        sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( get_site_icon_url( 192 ) ) )
    );
    return $meta_tags;
}
add_filter( 'site_icon_meta_tags', 'my_site_icon_meta_tags' );

/* カスタマイザーでapple touch icon を設定可能に
-------------------------------------------------------------------*/
function rakugaki_app_icon($wp_customize) {

    $wp_customize->get_control('site_icon')->description = sprintf(
        'ファビコン用の画像を設定して下さい。縦横%spx以上である必要があります。',
        '<strong>512</strong>'
    );

    $wp_customize->add_setting( 'ys_apple_touch_icon', array(
        'type'       => 'option',
        'capability' => 'manage_options',
        'transport'  => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Site_Icon_Control( $wp_customize, 'ys_apple_touch_icon', array(
        'label'       => 'apple touch icon',
        'description' => sprintf(
            'apple touch icon用の画像を設定して下さい。縦横%spx以上である必要があります。',
            '<strong>512</strong>'
        ),
        'section'     => 'title_tagline',
        'priority'    => 61,
        'height'      => 512,
        'width'       => 512,
    ) ) );
}
add_action('customize_register', 'rakugaki_app_icon');

/* 不要なページを404へ（is_●●●を追加していく）
-------------------------------------------------------------------*/
if(!function_exists('custom_handle_404')) {
  function add404($callback) {
    foreach ($callback as &$func) {
      if ( $func ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
      }
    }
  }
  function custom_handle_404() {
    // 404にする条件分岐を追加
    $callback = array(
      is_attachment(), is_month(), is_date(), is_singular('apps'), is_singular('column_cover'), is_singular('special'),
    );
    add404($callback);
  }
}
add_action( 'template_redirect', 'custom_handle_404' );

/* noindex
-------------------------------------------------------------------*/
if(!function_exists('insert_noindex')) {
  function insert_noindex() {
    if( 
      is_search() || is_404()
    ):?>
<meta name="robots" content="noindex,follow"/>
<?php endif;
  }
}
add_action('wp_head','insert_noindex');

/* 投稿一覧のアーカイブを有効化 /newsを作成
-----------------------------------------*/
function post_has_archive( $args, $post_type ) {
  if ( 'post' == $post_type ) {
    $args['rewrite'] = true;
    $args['has_archive'] = 'news'; // ページ名
  }
  return $args;
}
add_filter( 'register_post_type_args', 'post_has_archive', 10, 2 );

/* AndroidのChromeからアプリに飛べない問題へのアプローチ
   ビジュアルエディターでrel="noopener noreferrer"自動付加の解除
-----------------------------------------*/
function tinymce_allow_unsafe_link_target_demo( $mce_init ) {
 $mce_init['allow_unsafe_link_target']=true;
 return $mce_init;
}
add_filter('tiny_mce_before_init','tinymce_allow_unsafe_link_target_demo');
 
/* 本文からnoopener noreferrerを取り除く
-----------------------------------------*/
function remove_noopener_and_noreferrer_demo($the_content){
  $the_content = str_replace(' rel="nofollow noopener noreferrer"', ' rel="nofollow"', $the_content);
  $the_content = str_replace(' rel="noopener noreferrer"', '', $the_content);
  $the_content = str_replace(' rel="noopener"', '', $the_content);
  return $the_content;
}
add_filter('the_content', 'remove_noopener_and_noreferrer_demo', 9999);

