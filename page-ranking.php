<?php get_header(); ?>

<div class="container list">
  <main class="main">
    <h1 class="archives__ttl">
      <span class="archives__sub">カテゴリー</span>
      <div class="archives__main"><?php the_title(); ?></div>
    </h1>
    
    <section class="articles">

      <?php
      $paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
      $args = array(
        'post_status' => 'publish',
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
      $cnt = 1;
      ?>

      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
      
      <a class="article1" href="<?php the_permalink(); ?>">
        <div class="article1__img">
          <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
          
          <?php if( is_page('ranking') && !is_paged() ) : ?>
          <!-- 1ページ目のみ表示 -->
          <?php if ( $cnt <= 10 ) { ?>
          <?php if ( $cnt == 1 ) { ?>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pc/rank-label.png" alt="1位" class="sidebar__articles-label">
          <?php } else { ?>
          <span class="article__rank--1 is-<?php echo $cnt; ?>"><span class="article__rank-txt">No.<?php echo $cnt; ?></span></span>
          <?php } ?>
          <?php } ?>
          <?php endif; ?>
          
        </div>

        <div class="article1__desc">
          <h2 class="article1__ttl"><?php the_title(); ?></h2>
          <p class="article1__txt"><?php the_excerpt(); ?></p>
          <p class="article1__date"><time class="article1__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time></p>
        </div>
      </a>
      
      <?php 
        if ( $cnt <= 10 ) {
          $cnt++;
        }
      ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>

      <div class="pagination">
      <?php
      // WP_query用のpagination
      $big = 999999999; // need an unlikely integer

      echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $the_query->max_num_pages,
        'prev_text' => '前のページへ',
        'next_text' => '次のページへ',
      ) );
      ?>
      <!-- /.pagination --></div>
      
    <!-- /.articles --></section>
    
    <!-- /.main --></main>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
  <!-- /.container --></div>

<?php get_footer();
