<?php get_header(); ?>

<div class="container">
  <main class="main">
    <h1 class="archives__ttl">
      <span class="archives__sub">カテゴリー</span>
      <div class="archives__main"><?php the_title(); ?></div>
    </h1>
    
    <ul class="page-writer__list">
    
      <?php
      $user_per_page = 8;
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      if( $paged == 1 ){
        $offset = 0;  
      } else {
        $offset = ( $paged - 1 ) * $user_per_page;
      }
      
      $users = new WP_User_Query( 
	  	array( 
			'number' => $user_per_page, 
			'offset' => $offset,
			'meta_query'    => array(
          		array(
            		'key'     => 'writer_name',
           			'value'   => '',
            		'compare' => '!='
          		)
        	)
		) 
	);

      ?>
      <?php if (!empty($users->results)) : ?>
      <?php 
      foreach ($users->results as $user) : 
      $id = $user->ID;
      $name = $user->writer_name;
      $subname = $user->writer_subname;
      $position = $user->writer_position;
      $product = $user->writer_product;
      $img = $user->writer_img;
      $link = get_author_posts_url($id);
      ?>
      
      <li class="page-writer__item">
        <a href="<?php echo $link; ?>" class="page-writer__link">
          <span class="page-writer__img">
            <span class="page-writer__img-wrap">
              <img src="<?php echo wp_get_attachment_url($img); ?>" alt="<?php echo $name; ?>">
            </span>
          </span>
          <span class="page-writer__meta">
            <p class="page-writer__name"><?php echo $name; ?></p>
            <p class="page-writer__subname"><?php echo $subname; ?></p>
            <p class="page-writer__position"><?php echo $position; ?></p>
            <p class="page-writer__product"><?php echo $product; ?></p>
          </span>
        </a>
      </li>
      
      <?php endforeach; ?>
      <?php endif; ?>
      
      <div class="pagination">
        <?php
        // WP_query用のpagination
        $big = 999999999; // need an unlikely integer
        $total = ceil($users->total_users / $user_per_page);
        echo paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $total,
          'prev_text' => '前のページへ',
          'next_text' => '次のページへ',
        ) );
        ?>
        <!-- /.pagination --></div>
      
    </ul>

    <!-- /.main --></main>
  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
  <!-- /.container --></div>
  
<?php get_footer();
