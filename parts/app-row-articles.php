<section class="articles articles-side-apps <?php if(is_page('contact')) { echo 'articles-side-contact'; } ?>"> 

  <h2 class="apps-row__ttl">紹介アプリ一覧<?php if(is_page('contact')) { echo '<span class="apps-row__ttl--contact"></span>'; } ?></h2>
  <div class="swiper-container apps-row<?php if(is_page('contact')) {echo '--contact';} ?>">  
    <ul class="swiper-wrapper apps-row__list">

      <?php
      $args = array( 
        'post_type' => 'apps',
		'posts_per_page' => -1,
        'order' => 'ASC'        
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()):
      ?>

      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

      <li class="swiper-slide apps-row__item">
        <a href="<?php the_field('apps_url') ?>" class="apps-row__link"><img class="apps-row__img <?php if(is_page('contact')) { echo 'apps-row__img--contact'; } ?>" src="<?php the_field('apps_icon') ?>"></a>
      </li>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    <!-- /.wrapper --></ul>
  <!-- /.container --></div>
<!-- /.articles --></section>