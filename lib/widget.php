<?php 

/* サイドバー（ウィジェット）を有効化
-------------------------------------------------------------------*/
function rakugaki_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'rakugaki' ),
    'id'            => 'sidebar__widget',
    'description'   => esc_html__( 'Add widgets here.', 'rakugaki' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'rakugaki_widgets_init' );