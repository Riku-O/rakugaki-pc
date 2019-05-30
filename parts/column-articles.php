<section class="articles articles-side"> 

  <h2 class="archives__ttl">
    <div class="archives__side">連載</div>
  </h2>

  <a href="<?php echo esc_url( home_url( '/' ) ); ?>columns/" class="archives__more">もっと見る</a>

  <div class="article-columns__wrap">
    <?php
    $args = array(
      'post_type' => 'column_cover',
      'post_per_pages' => 4
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post();;?>
    <article class="article-columns">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>?s=&term=<?php the_title(); ?>" class="article-columns__link">
        <p class="article-columns__subttl">連載</p>
        <h3 class="article-columns__ttl"><?php the_title(); ?></h3>
        <div class="article-columns__img"><img class="article-columns__img-eye" src="<?php the_field('column_img'); ?>" alt="<?php the_title(); ?>">
        </div>
      </a>
      <?php if ( is_newest_post($post, 3) ) { ?>
      <span class="article__rank--1"><span class="article__rank-txt">New</span></span>
      <?php } ?>
    </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>

  <!-- /.articles --></section>