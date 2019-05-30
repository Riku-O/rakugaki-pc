<?php 

/* 外部JSおよびCSSファイルの読み込み
-------------------------------------------------------------------*/
if(!function_exists('insert_files')) {
    function insert_files() {

        define("TEMPLATE_DIRE", get_template_directory_uri());
        define("TEMPLATE_PATH", get_template_directory());

        function wp_local_css($css_name, $file_path){
            wp_enqueue_style($css_name,TEMPLATE_DIRE.$file_path, array(), date('YmdGis', filemtime(TEMPLATE_PATH.$file_path)));
        }
        function wp_local_script($script_name, $file_path, $bool = true){
            wp_enqueue_script($script_name,TEMPLATE_DIRE.$file_path, array(), date('YmdGis', filemtime(TEMPLATE_PATH.$file_path)), $bool);
        }

        wp_deregister_script('jquery');// WordPress提供のjquery.jsを読み込まない
      
        // CDN JS
        wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', "", "", true );
      
        // CDN CSS
        wp_enqueue_style( 'font-awesome', '//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), "" );
      wp_enqueue_style( 'font-noto', 'https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,500,700&amp;subset=japanese', array(), "" );
      
      // テーマ内のJS
      wp_local_script('theme-js','/assets/js/theme.js');
      wp_local_script('swiper-js','/assets/js/swiper/swiper.min.js');
	  if (is_front_page()) {
        wp_local_script('top-js','/assets/js/top.js');
      }
	  if (is_single() || is_singular('column')) {
        wp_local_script('single-js','/assets/js/load-single.js');
      }

      // テーマ内のCSS
      wp_local_css('style','/style.css');
      wp_local_css( 'swiper-css', '/assets/js/swiper/swiper.min.css', array(), "" );
    }
}
add_action('wp_enqueue_scripts', 'insert_files');

/* ログインユーザーはAnalytics非表示
-------------------------------------------------------------------*/
if(!function_exists('insert_ga_code')) {
    function insert_ga_code() {
        if( !is_user_logged_in() ) {
          $ga = get_option_val("ga");
?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', '<?php echo $ga; ?>', 'auto');
        ga('send', 'pageview');
    </script>
    <?php 
        }
    }
}
add_action('wp_head','insert_ga_code');

/* ログインユーザーの管理バーが表示している場合
-------------------------------------------------------------------*/
if(!function_exists('insert_admin_bar')) {
  function insert_admin_bar() {
    if( is_admin_bar_showing() ) {
?>

<style>
  html {
   padding-top: 32px !important;
  }

  @media screen and (max-width: 600px) {
    html {
      padding-top: 0 !important;
    }
    #wpadminbar {
      position: fixed !important;
    }
  }
</style>

<?php 
    }
  }
}
add_action('wp_head','insert_admin_bar');

/* canonical prev next
-------------------------------------------------------------------*/
if(!function_exists('insert_canonical')) {
    function insert_canonical() {
        global $page, $paged, $wp_query;
        if(is_home()||is_front_page()){
            if ( is_paged() ) {
                $paged_url = "/page/{$paged}/";
                $canonical_url = home_url() . $paged_url;
            } else {
                $canonical_url = home_url();
            }
        } else if (is_category()){
            if ( is_paged() ) {
                $paged_url = "page/{$paged}/";
                $canonical_url = get_category_link(get_query_var('cat')) . $paged_url;
            } else {
                $canonical_url = get_category_link(get_query_var('cat'));
            }
        } else if (is_page()||is_single()) {
            $canonical_url = get_permalink();
        } else if (is_search()){
            $encode_s_word = urlencode(get_search_query());
            $canonical_url = home_url().'?s='.$encode_s_word;
        } else if(is_tag()){
            $encode_tag = urlencode(single_tag_title( '', false ));
            $canonical_url = home_url().'/archives/tag/'.$encode_tag;
        } else {
            $canonical_url = null;
        }
        if ($canonical_url == !null) { ?><link rel="canonical" href="<?php echo $canonical_url; ?>" />
<?php }

        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        if (!$paged)
            $paged = 1;
        $nextpage = intval($paged) + 1;

        if (!is_singular() && ($nextpage <= $max_page)) { ?>
<link rel="next" href="<?php echo next_posts( $max_page, false ); ?>" />
<?php } 
        if(!is_singular() && $paged > 1){ ?>
<link rel="prev" href="<?php echo previous_posts( false ); ?>" />
<?php }
    }
}
add_action('wp_head','insert_canonical');

/* OGP
-------------------------------------------------------------------*/
if(!function_exists('insert_ogp')) {
    
    function insert_ogp() {
        global $post;
        $desc = get_field('description');
        $ttl = $post->post_title . ' | ' . get_bloginfo('site_name');
        $sitename = get_bloginfo('site_name');
        $url = get_the_permalink();
        $fb = get_option_val("fb");
        $fb_app = get_option_val("fb_id");
        $tw = get_option_val("tw");
        $web_type = 'website';
        $og_image = get_option_val("ogp_image");
        $og_image = esc_url($og_image);
        
        if( empty( !get_field('ogp_image') ) ) {
            $og_image = get_field('ogp_image');
            $og_image = esc_url(wp_get_attachment_url($og_image));
        }
        
        if (is_front_page()) {
            $desc = get_bloginfo('description');
            $ttl = get_bloginfo('site_name');
            $url = home_url();
        }
        
    ?>

    <meta name="description" content="<?php echo $desc; ?>">
    <meta property='og:locale' content="ja_JP">
    <meta property="fb:app_id" content="<?php echo $fb_app; ?>" />
    <meta property='og:site_name' content="<?php echo $sitename; ?>">
    <meta property='og:title' content="<?php echo $ttl; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo $tw; ?>">
    <meta property="og:description" content="<?php echo $desc; ?>">
    <meta property="og:url" content="<?php echo $url; ?>">
    <meta property="og:type" content="<?php echo $web_type; ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    
    <?php
    }
}
add_action('wp_head','insert_ogp');

/* JSON-LD schema.org
-------------------------------------------------------------------*/
if(!function_exists('insert_json_ld')) {
    function insert_json_ld() {
      if ( is_front_page() && !is_paged() ) {
?>
        <script type="application/ld+json">
          {
              "@context": "http://schema.org/",
              "@type": "WebSite",
              "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
              "name": "<?php bloginfo('name'); ?>"
          }
        </script>
        <?php
      } else if( is_single() ) {
?>

<?php 
    global $post;
    $img_url = get_thumbnail();
    $img_size =  get_image_width_and_height($img_url);
    $img_height = $img_size['height'];
    $img_width = $img_size['width'];
    $author_id = $post->post_author;
    $author_name = get_the_author_meta('display_name', $author_id);
    $organization = get_option_val("cp");
    $corp_logo = get_option_val("corp_logo");
    $desc = get_field( 'description' );
    $corp_size = get_image_width_and_height($corp_logo);
    $corp_height = $corp_size['height'];
    $corp_width = $corp_size['width'];
?>

<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "Article",
  "@id": "<?php esc_url(the_permalink()); ?>",
  "mainEntityOfPage": {
    "@type": "WebSite",
    "@id": "<?php echo esc_url(home_url('/')); ?>",
    "name": "<?php bloginfo('name'); ?>"
  },
  "headline": "<?php single_post_title(); ?>",
  "image": {
    "@type": "ImageObject",
    "url": "<?php echo esc_url($img_url); ?>",
    "height": <?php echo $img_height; ?>,
    "width": <?php echo $img_width; ?>
  },
  "datePublished": "<?php echo esc_attr( get_the_date( 'c' ) );?>",
  "dateModified": "<?php echo esc_attr( the_modified_date( 'c' ) );?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo $author_name; ?>"
  },
   "publisher": {
    "@type": "Organization",
    "name": "<?php echo $organization; ?>",
    "logo": {
        "@type": "ImageObject",
        "url": "<?php echo $corp_logo; ?>",
        "width": <?php echo $corp_width; ?>,
        "height": <?php echo $corp_height; ?>
        }
    },
  "description": "<?php echo $desc; ?>"
}
</script>

<?php
        }
    }
}
add_action('wp_head','insert_json_ld');

/* titleタグ
-----------------------------------------*/
add_theme_support( 'title-tag' );

function change_title_separator( $sep ){
  $sep = ' | ';
  return $sep;
}
add_filter( 'document_title_separator', 'change_title_separator' );

function wp_document_title_parts( $title ) {
  if ( is_home() || is_front_page() ) {
    unset( $title['tagline'] ); // キャッチフレーズを出力しない
  } else if ( is_category() ) {
    $title['title'] = '「' . $title['title'] . '」カテゴリーの記事一覧';
  } else if ( is_tag() ) {
    $title['title'] = '「' . $title['title'] . '」タグの記事一覧';
  } else if ( is_archive() ) {
    $title['title'] = $title['title'] . 'の記事一覧';
  } else if ( is_search() ) {
    if ( is_url('author=') ) {
      $url = $_SERVER['REQUEST_URI'];
      preg_match('/author=([^&]+)/', $url, $match);
      $user_name = urldecode($match[1]);
      $user = get_user_by( 'login', $user_name );
      $title['title'] = $user->writer_name . 'の連載記事一覧';
    } else if (is_url('term=')) {
      $url = $_SERVER['REQUEST_URI'];
      preg_match('/term=([^&]+)/', $url, $match);
      $column_name = urldecode($match[1]);
      $title['title'] = $column_name . 'の連載記事一覧';
    } else {
      $title['title'] = $title['title'];
    }
  }
  return $title;
}
add_filter( 'document_title_parts', 'wp_document_title_parts', 10, 1 );