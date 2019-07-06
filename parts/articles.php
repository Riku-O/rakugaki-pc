<section class="articles">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <a class="article1" href="<?php the_permalink(); ?>">
    <div class="article1__img">
      <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
      <?php if ( is_newest_post($post, 3) ) { ?>
      <span class="article__rank--1"><span class="article__rank--1-txt">New</span></span>
      <?php } ?>
    </div>

    <div class="article1__desc">
      <h2 class="article1__ttl"><?php the_title(); ?></h2>
      <p class="article1__txt"><?php the_excerpt(); ?></p>
      <p class="article1__date"><time class="article1__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time></p>
    </div>
  </a>

  <?php endwhile; ?>
    <?php get_template_part('parts/pagination'); ?>
  <?php else : ?>
  <p>まだ記事はありません。</p>
  <?php endif; ?>
<!-- /.articles --></section>