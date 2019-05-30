<?php 
class rakugakiSetting{
  public static $key='my_option_name';//オプションへの保存、呼び出しキー
  private $html_title='カスタム設定';//HTMLのタイトル（管理ページのtitleタグ）
  private $page_title='カスタム設定';//ページのタイトル
  private $page_slug='my_option_page';
  private $options;
  private $group='my_option_group';
  private $section='my_setting_admin';

  public static function getFields(){

    // 実際に表示するカスタム設定 $name, $ttl, $callback
    return array(
      array(
        'type'=>'section',
        'name'=>'sec1',
        'title'=>'',
        'callback'=>'section_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'ga',
        'title'=>'Google Analitycs(UA-XXXXXXXX-X)',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'tw',
        'title'=>'Twitter Acount',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'fb',
        'title'=>'Facebook URL',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'section',
        'name'=>'sec2',
        'title'=>'',
        'callback'=>'section_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'fb_id',
        'title'=>'Facebook App ID',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'cp',
        'title'=>'コピーライト / 運営者名',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'ogp_image',
        'title'=>'OGP シェア 画像',
        'callback'=>'text_callback',
      ),
      array(
        'type'=>'field',
        'name'=>'corp_logo',
        'title'=>'運営会社ロゴ',
        'callback'=>'text_callback',
      ),
    );
  }

  //初期化
  public function __construct(){
    add_action('admin_menu',array($this,'add_my_option_page'));
    add_action('admin_init',array($this,'page_init'));
  }

  //キーを取得（外部から呼び出せるようにする）
  public static function getKey(){
    return self::$key;
  }

  //設定
  public function add_my_option_page(){
    add_options_page(
      $this->html_title,//ダッシュボードのメニューに表示するテキスト
      $this->page_title,//ページのタイトル
      'edit_themes',
      $this->page_slug,//ページスラッグ
      array( $this, 'create_admin_page' )
    );
  }

  //フォームの外観作成
  public function create_admin_page(){
    // Set class property
    $this->options = get_option($this->getKey());
?>
<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php echo $this->page_title;?></h2>
  <form method="post" action="options.php">
    <?php
    // This prints out all hidden setting fields
    settings_fields($this->group);
    do_settings_sections($this->section);
    submit_button();
    ?>
  </form>
</div>
<?php
  }

  //フォームの部品組み立て
  public function page_init(){
    register_setting(
      $this->group, // Option group
      $this->getKey(), // Option name
      array( $this, 'sanitize' ) // Sanitize
    );

    $fields=$this->getFields();
    $section_id='';
    foreach($fields AS $field){
      if($field['type']=='field'){
        add_settings_section(
          $field['name'], // ID
          $field['title'], // Title
          array($this,$field['callback']), // Callback
          $this->section, // Page
          $section_id
        );
      }else{
        add_settings_section(
          $field['name'], // ID
          $field['title'], // Title
          array($this,$field['callback']), // Callback
          $this->section // Page
        );
        $section_id=$field['name'];
      }
    }
  }

  //保存前のサニタイズ
  public function sanitize($input){

    $new_input = array();
    foreach($this->getFields() AS $field){
      if(isset($input[$field['name']])){
        $new_input[$field['name']] = sanitize_text_field($input[$field['name']]);
      }
    }
    return $new_input;
  }

  //セクション表示関数
  public function section_callback(array $args){
    echo '<hr>';
  }

  //テキストフィール表示関数
  public function text_callback(array $args){
    $name=$args['id'];
    printf(
      '<input type="text" id="'.$name.'" name="'.$this->getKey().'['.$name.']" value="%s" style="width: 300px;" />',
      isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : ''
    );
  }
  
  // テキストエリア表示関数
  public function textarea_callback(array $args){
    $name=$args['id'];
    printf(
      '<textarea rows="10" cols="80" id="'.$name.'" name="'.$this->getKey().'['.$name.']" value="%s" /></textarea>',
      isset( $this->options[$name] ) ? esc_attr( $this->options[$name]) : ''
    );
  }
  
  //画像アップロード機能
  public function generate_upload_image_tag($name, $value){?>
<input name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" style="width: 300px;"/>
<input type="button" name="<?php echo $name; ?>_slect" value="選択" />
<input type="button" name="<?php echo $name; ?>_clear" value="クリア" />
<div id="<?php echo $name; ?>_thumbnail" class="uploded-thumbnail">
  <?php if ($value): ?>
  <img src="<?php echo $value; ?>" alt="選択中の画像">
  <?php endif ?>
</div>

<script type="text/javascript">
  (function ($) {
    var custom_uploader;
    $("input:button[name=<?php echo $name; ?>_slect]").click(function(e) {
      e.preventDefault();
      if (custom_uploader) {
        custom_uploader.open();
        return;
      }
      custom_uploader = wp.media({
        title: "画像を選択してください",
        library: {
          type: "image"
        },
        button: {
          text: "画像の選択"
        },
        multiple: false
      });
      custom_uploader.on("select", function() {
        var images = custom_uploader.state().get("selection");
        images.each(function(file){
          $("input:text[name=<?php echo $name; ?>]").val("");
          $("#<?php echo $name; ?>_thumbnail").empty();
          $("input:text[name=<?php echo $name; ?>]").val(file.attributes.sizes.full.url);
          $("#<?php echo $name; ?>_thumbnail").append('<img src="'+file.attributes.sizes.full.url+'" width="320" style="margin-top: 16px;"/>');
        });
      });
      custom_uploader.open();
    });

    $("input:button[name=<?php echo $name; ?>_clear]").click(function() {
      $("input:text[name=<?php echo $name; ?>]").val("");
      $("#<?php echo $name; ?>_thumbnail").empty();
    });
  })(jQuery);
</script>
<?php
                                                          }

  // OGP 画像用の関数
  public function get_ogp() {
    $this->generate_upload_image_tag("ogp_img", get_option('ogp_img'));
  }

  // コーポレート・ロゴ画像用の関数
  public function get_logo() {
    $this->generate_upload_image_tag("corp_logo", get_option('corp_logo'));
  }

}

if(is_admin())
  $my_settings_page = new rakugakiSetting();
  function my_admin_scripts() {
    wp_enqueue_media();
  }
  add_action( 'admin_print_scripts', 'my_admin_scripts' );