<?php get_header(); ?>

<section class="kv">
  <div class="swiper-wrap">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pc/kv-label.png" alt="編集部おすすめ" class="kv__img-label">

      <div class="swiper-container swiper-fv">
    <div class="swiper-wrapper">
	
	   <?php
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 1,
  );
   $the_query = new WP_Query($args); if($the_query->have_posts()):
   ?>
   <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
  <a class="kv__wrap swiper-slide" href="<?php the_permalink(); ?>">
   <div class="kv__img">
     <div class="kv__img-eye" style="background: url(<?php echo get_thumbnail(); ?>); background-size: cover; height: 260px;"></div>
   </div>
   <div class="kv__desc">
     <h2 class="kv__ttl"><?php the_title(); ?></h2>
     <p class="kv__date"><time class="kv__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time></p>
   </div>
  </a>
   <?php endwhile; ?>
   <?php wp_reset_postdata(); ?>
   <?php endif; ?>
  
   <?php
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'orderby' => array( 'favorite' => 'ASC'),
    'meta_query' => array(
      'relation' => 'AND',
      'ranking'=>array(
        'key'     => 'favorite',
        'type'    => 'numeric',
      ),
    ),
  );
   $the_query = new WP_Query($args); if($the_query->have_posts()):
   ?>
   <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
  <a class="kv__wrap swiper-slide" href="<?php the_permalink(); ?>">
   <div class="kv__img">
     <div class="kv__img-eye" style="background: url(<?php echo get_thumbnail(); ?>); background-size: cover; height: 260px;"></div>
   </div>
   <div class="kv__desc">
     <h2 class="kv__ttl"><?php the_title(); ?></h2>
     <p class="kv__date"><time class="kv__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time></p>
   </div>
  </a>
   <?php endwhile; ?>
   <?php wp_reset_postdata(); ?>
   <?php endif; ?>
    </div>
  </div>
    <div class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
    <div class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>  
  </div>
</section>

<div class="container">
  <main class="main">
    <section class="front__fv">
      <?php get_template_part('parts/new-articles'); ?>
      <?php get_template_part('parts/ranking-articles'); ?>
      <?php get_template_part('parts/column-articles'); ?>
      <?php get_template_part('parts/author-articles'); ?>
    </section>
  </main>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
<!-- /.container --></div>

<?php get_footer();
