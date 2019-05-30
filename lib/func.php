<?php 

/* カスタム設定ページの値を呼び出す-----------------------------------------*/
function get_option_val($value) {
  $options=get_option(rakugakiSetting::getKey());
  return $options[$value];
}

/* モバイル 分岐
-------------------------------------------------------------------*/
if (!function_exists('is_mobile')) {
    function is_mobile(){
        $useragents = array(
            'iPhone', // iPhone
            'iPod', // iPod touch
            'Android.*Mobile', // 1.5+ Android *** Only mobile
            'Windows.*Phone', // *** Windows Phone
            'dream', // Pre 1.5 Android
            'CUPCAKE', // 1.5+ Android
            'blackberry9500', // Storm
            'blackberry9530', // Storm
            'blackberry9520', // Storm v2
            'blackberry9550', // Storm v2
            'blackberry9800', // Torch
            'webOS', // Palm Pre Experimental
            'incognito', // Other iPhone browser
            'webmate' // Other iPhone browser

        );
        $pattern = '/'.implode('|', $useragents).'/i';
        return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
    }
}

/* URL判定
-----------------------------------------*/
if (!function_exists('is_url')) {
  function is_url($text){
    $url = $_SERVER['REQUEST_URI'];
    return strstr($url,$text);
  }
}

/* 投稿者の画像取得
-------------------------------------------------------------------*/
if (!function_exists('get_author_img')) {
    function get_author_img($id) {
      if ( $id ) {
        $author_img = get_avatar($id, '1000');
        $imgtag = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
        if(preg_match($imgtag, $author_img, $imgurl)){
          $authorimg = $imgurl[2];
        }
        return $authorimg;
      } else {
        global $post;
        $author_id = $post->post_author;
        $author_img = get_avatar($author_id, '1000');
        $imgtag= '/<img.*?src=(["\'])(.+?)\1.*?>/i';
        if(preg_match($imgtag, $author_img, $imgurl)){
          $authorimg = $imgurl[2];
        }
        return $authorimg;
      }
    }
}

/* 投稿者の前後の記事を取得
-------------------------------------------------------------------*/
if(!function_exists('get_author_prev_next_post')) {
    function get_author_prev_next_post($post_prev_next) {
        $this_post = get_post();
        $order = 'DESC';
        $next_prev = 'before';
        
        if($post_prev_next == 'next') {
            $order = 'ASC';
            $next_prev = 'after';
        }

        $args = array(
            'author'        =>  $this_post->post_author,
            'post_type'     =>  $this_post->post_type,
            'orderby'       =>  'post_date',
            'order'         =>  $order,
            'date_query' => array(
                $next_prev => $this_post->post_date
            ),
        );

        $author_posts = get_posts( $args );
        $author_post = $author_posts[0];
        return $author_post;
    }
}

/* imgタグを除去しURLのみ取得
-------------------------------------------------------------------*/
if(!function_exists('get_format_img_url')) {
    function get_format_img_url($img) {
        $pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';
        preg_match( $pattern, $img, $img_after );
        return $img_after[1];
    }
}

/* アイキャッチを取得
-------------------------------------------------------------------*/
if(!function_exists('get_thumbnail')) {
    function get_thumbnail() {
        if (has_post_thumbnail()) {
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), true);
            $image = $image_url[0];
            return $image;
        } else {
            $image = get_template_directory_uri() . "/assets/img/no-img.png";
            return $image;
        }
    }
}

/* アイキャッチのalt（代替テキスト）を取得
-------------------------------------------------------------------*/
if(!function_exists('get_thumbnail_alt')) {
  function get_thumbnail_alt() {
    if (has_post_thumbnail()) {
      $thumbID = get_post_thumbnail_id( $postID );
      $alt = get_post_meta($thumbID, '_wp_attachment_image_alt', true);
      return $alt;
    }
  }
}

/* 画像のURLから幅と高さを取得する
-------------------------------------------------------------------*/
if(!function_exists('get_image_width_and_height')) {
    function get_image_width_and_height($image_url){
        if (!empty($image_url)) {
            $wp_upload_dir = wp_upload_dir();
            $uploads_dir = $wp_upload_dir['basedir'];
            $uploads_url = $wp_upload_dir['baseurl'];
            $image_file = str_replace($uploads_url, $uploads_dir, $image_url);
            $imagesize = getimagesize($image_file);
            if ($imagesize) {
                $res = array();
                $res['width'] = $imagesize[0];
                $res['height'] = $imagesize[1];
                return $res;
            }
        }
    }
}

/* ファイルの更新日を取得
-------------------------------------------------------------------*/
if(!function_exists('file_date')) {
    function file_date($filename){
        if (file_exists($filename)) {
            return date('Y-m-d-His', filemtime($filename));
        }
    }
}

/* それが何記事目かを取得
-----------------------------------------*/
if(!function_exists('getPostThNumber')) {
    function getPostThNumber($post_type) {
        global $wpdb, $post;

        $number = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $wpdb->posts
    WHERE post_status = 'publish'
    AND post_type = $post_type
    AND post_date <= '$post->post_date'
  ");
        return $number;
    }
}

/* カスタム設定の設定値を取得
-----------------------------------------*/
if(!function_exists('getOptionValue')) {
  function getOptionValue($val) {
    $options=get_option(rakugakiSetting::getKey());
    return esc_html($options[$val]);
  }
}

/* 指定した○日以内の記事か判定
-----------------------------------------*/
function is_newest_post($the_post, $days) {

  $today = date_i18n('U');
  $posted = get_the_time('U',$the_post->ID);
  $elapsed = date('U',($today - $posted)) / (60*60*24) ;

  if( $days > $elapsed ){
    return true;
  } else {
    return false;
  }
}

/* 最初の記事を判定
-----------------------------------------*/
function is_first(){
  global $wp_query;
  return ($wp_query->current_post === 0);
}

/* Facebook Share Count
-----------------------------------------*/
// アクセストークンからリアクションカウント数を取得 8時間おきにキャッシュ更新
function getFacebookCount($url, $cache){
  $res = get_transient( $cache );
  if ( $res === false ) {
    $access_token = '608191899629055|6eVfZ-Bd6CaLwAZCUlCLLp7hpCM';
    $encoded_url = rawurlencode( $url );
    $request_url = 'https://graph.facebook.com/?id='.$encoded_url.'&fields=engagement&access_token='.$access_token;
    $response = wp_remote_get( $request_url );
    $res = 0;
    if (!is_wp_error( $response ) && $response["response"]["code"] === 200) {
      $body = $response['body'];
      $json = json_decode( $body );
      $res = (isset($json->{'engagement'}->{'share_count'}) ? $json->{'engagement'}->{'share_count'} : 0);
    }
    $cache_time_hour = 3600 * 8;
    set_transient( $cache, $res, $cache_time_hour );
    return intval($res);
  } else {
    return $res;
  }
}

/* Twitter Share Count
-----------------------------------------*/
// count.jsoon利用の前提
function getTwitterCount($url) {
  $res = 0;
  $json = @file_get_contents('https://jsoon.digitiminimi.com/twitter/count.json?url=' . $url . '');
  $array = json_decode($json,true);
  if ( !empty($array) ) {
    $res = $array['count'];
  }
  return intval($res);
}
