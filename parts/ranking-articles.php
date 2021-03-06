<section class="articles articles-side"> 

  <h2 class="archives__ttl">
    <div class="archives__side">月間ランキング</div>
  </h2>

  <a href="<?php echo esc_url( home_url( '/' ) ); ?>ranking/" class="archives__more">もっと見る</a>
  
  <?php if ( is_front_page() ): ?>
  <a class="article1" href="<?php the_permalink(); ?>">
    <?php
    $args = array(
      'post_status' => 'publish',
      'posts_per_page' => 1,
      'paged' => $paged,
      'orderby' => array( 'ranking' => 'ASC', 'views' => 'DESC' ),
      'meta_query' => array(
        'relation' => 'AND',
        'ranking'=>array(
          'key'     => 'ranking',
          'type'    => 'numeric',
        ),
        'views'=>array(
          'key'     => 'views',
          'type'    => 'numeric',
        ),
      ),
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post();?>

    <div class="article1__img">
      <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pc/rank-label.png" alt="1位" class="sidebar__articles-label">
    </div>

    <div class="article1__desc">
      <h2 class="article1__ttl"><?php the_title(); ?></h2>
      <p class="article1__txt"><?php the_excerpt(); ?></p>
      <p class="article1__date"><time class="article1__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time></p>
    </div>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </a>
  
  <?php endif; ?>

  <div class="article-wrap">
    <?php
    $pages = 4;
    if ( !is_front_page() ) {
      $pages = 3;
      $cnt = 2;
    } 
    $args = array(
      'post_status' => 'publish',
      'posts_per_page' => $pages,
      'paged' => $paged,
      'orderby' => array( 'ranking' => 'ASC', 'views' => 'DESC' ),
      'meta_query' => array(
        'relation' => 'AND',
        'ranking'=>array(
          'key'     => 'ranking',
          'type'    => 'numeric',
        ),
        'views'=>array(
          'key'     => 'views',
          'type'    => 'numeric',
        ),
      ),
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post(); $cnt++;?>
    <?php if ($cnt <= 1) :?>
    <?php else : ?>
    <article class="article-rows">
      <a href="<?php the_permalink(); ?>" class="article-rows__link">
        <h3 class="article-rows__ttl"><?php the_title(); ?></h3>
        <div class="article-rows__img"><img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
          <span class="article__rank"><span class="article__rank-txt">No.<?php echo $cnt; ?></span></span>
        </div>
      </a>
    </article>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>

  <!-- /.articles --></section>