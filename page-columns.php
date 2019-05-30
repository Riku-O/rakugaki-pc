<?php get_header(); ?>

<div class="container list">
 
  <main class="main">
    <h1 class="archives__ttl">
      <span class="archives__sub">カテゴリー</span>
      <div class="archives__main"><?php the_title(); ?></div>
    </h1>
    <script>
      let datas = [];
      let elms = [];
      let harray = [];
      let h = [];
    </script>
    <?php
    $args = array( 'post_type' => 'column_cover');
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

      <style>
        .column__cover-more {
          background: url('<?php the_field('column_img'); ?>');
          background-size: cover;
          background-position: center center;
        }
      </style>
      <section class="column">
        <div class="column__wrap">
          <div class="column__cover"><img src="<?php the_field('column_img'); ?>" alt="<?php the_title(); ?>"></div>
          <div class="column__dot"></div>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>?s=&term=<?php the_title(); ?>" class="column__more">この連載を見る</a>

          <section class="articles articles-side">             
            <?php get_template_part('parts/columns-articles'); ?>
          <!-- /.articles --></section>

        <!-- /.column__wrap --></div>
      <!-- /.column --></section>
    
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?> 
  <!-- /.main --></main>
  
  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
<!-- /.container --></div>

<?php get_footer();