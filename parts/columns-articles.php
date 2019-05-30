<section class="articles articles-side"> 

  <h2 class="archives__ttl">
    <div class="archives__side">連載記事</div>
  </h2>

  <a href="<?php echo esc_url( home_url( '/' ) ); ?>?s=&term=<?php the_title(); ?>" class="archives__more">もっと見る</a>

  <a class="article1" href="<?php the_permalink(); ?>">
    <?php
    $ttl = get_the_title();
    $args = array(
      'post_type' => 'column',
      'post_status' => 'publish',
      'posts_per_page' => 1,
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'column_cat',
          'field' => 'slug',
          'terms' => $ttl,
          'include_children' => true,
          'operator' => 'IN'
        ),
      )
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post();?>

    <div class="article1__img">
      <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
      <span class="article__rank--1"><span class="article__rank--1-txt">New</span></span>
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

  <div class="article-wrap">
    <?php
    $cnt = 1;
    $args = array(
      'post_type' => 'column',
      'post_status' => 'publish',
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'column_cat',
          'field' => 'slug',
          'terms' => $ttl,
          'include_children' => true,
          'operator' => 'IN'
        ),
      )
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    $post_no = $the_query->post_count;
    $i = 1;
    $cnt = $post_no;
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post();?>
    <?php if ($i > 1 && $i < 5) :?>
    <article class="article-rows">
      <a href="<?php the_permalink(); ?>" class="article-rows__link">
        <h3 class="article-rows__ttl"><?php the_title(); ?></h3>
        <div class="article-rows__img"><img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
          <?php if ( $post_no == $cnt ) { ?>
          <span class="article__rank"><span class="article__rank-txt">New</span></span>
          <?php } else { ?>
          <span class="article__rank article__no"><span class="article__rank-txt">No.<?php echo $post_no; ?></span></span>
          <?php } ?>
          
          </div>
      </a>
    </article>
    <?php endif; ?>
    <?php $i++; $post_no--; ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </div>

  <!-- /.articles --></section>