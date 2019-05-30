<?php 
$url = $_SERVER['REQUEST_URI'];
$url = urldecode($url);
preg_match('/term=([^&]+)/', $url, $match);
$term = $match[1];
?>
 
<?php 
  $cover_post = get_page_by_title($term, OBJECT, 'column_cover');
  $img = $cover_post->column_img2;
  $img_url = wp_get_attachment_url($img);
?>
 

 <div class="container">
  <main class="main">
    <div class="column__head">
      <img src="<?php echo $img_url; ?>" alt="<?php echo $term; ?>">
    </div>
    <div class="column__desc">
      <?php echo $cover_post->column_desc; ?>
    </div>
    <section class="articles">
      <h2 class="articles__ttl">執筆記事</h2>
      <?php
      $paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
      $args = array(
        'post_type' => 'column',
        'post_status' => 'publish',
        'paged' => $paged,
        'tax_query' => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'column_cat',
            'field' => 'slug',
            'terms' => $term,
            'include_children' => true,
            'operator' => 'IN'
          ),
        )
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()):
      $post_no = $the_query->post_count;
      $cnt = $post_no;
      ?>

      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
      
      <a class="article1" href="<?php the_permalink(); ?>">
        <div class="article1__img">
          <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
          <?php if ( $cnt == $post_no ) { ?>
          <span class="article__rank--1"><span class="article__rank-txt">New</span></span>
          <?php } else { ?>
          <span class="article__rank--1 article__no is-<?php  if($post_no > 9) {echo '10';} ?>"><span class="article__rank-txt">No.<?php echo $post_no; ?></span></span>
          <?php }; ?>
        </div>

        <div class="article1__desc">
          <h2 class="article1__ttl"><?php the_title(); ?></h2>
          <p class="article1__txt"><?php the_excerpt(); ?></p>
          <p class="article1__date"><time class="article1__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time></p>
        </div>
      </a>

      <?php $post_no--; ?>
      <?php endwhile; ?>
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
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>
      
      <!-- /.articles --></section>  
  </main>
   <aside class="sidebar">
     <?php get_sidebar(); ?>
   </aside>
<!-- /.container --></div>