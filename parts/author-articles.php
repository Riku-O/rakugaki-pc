<section class="articles articles-side"> 

  <h2 class="archives__ttl">
    <div class="archives__side">ライター&amp;監修</div>
  </h2>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>author/" class="archives__more">もっと見る</a>
  <ul class="article-writers">
    <?php
    $users = get_users( 
      array(
        'orderby'=>ID,
        'order'=>ASC,
		'number'=>'5',
        'meta_query'    => array(
          array(
            'key'     => 'writer_name',
            'value'   => '',
            'compare' => '!='
          )
        )
      ) 
    );
    foreach ($users as $user) : 
    $id = $user->ID;
    $name = $user->writer_name;
    $img = $user->writer_img2;
    $link = get_author_posts_url($id);
    ?>

    <li class="article-writers__item">
      <a href="<?php echo esc_url( $link ); ?>" class="front__writer-link">
        <img src="<?php echo wp_get_attachment_url($img); ?>" alt="<?php echo $name; ?>">
        <p class="article-writers__name"><?php echo $name; ?></p>
      </a>
    </li>

    <?php endforeach; ?>
  </ul>

  <!-- /.articles --></section>