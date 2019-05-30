<section class="articles articles-side"> 

  <h2 class="archives__ttl">
    <div class="archives__side">マッチングアプリ一覧</div>
  </h2>

  <ul class="apps">
    
      <?php
      $args = array( 
        'post_type' => 'apps',
        'order' => 'ASC'        
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()):
      ?>

      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

      <li class="apps__list">
        <a href="<?php the_field('apps_url') ?>" class="apps__link">
          <img src="<?php the_field('apps_icon') ?>" alt="<?php the_title(); ?>" class="apps__img">
          <span class="apps__name"><?php the_title(); ?></span>
        </a>
      </li>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>

  </ul>
<!-- /.articles --></section>