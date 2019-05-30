<?php
$s = get_search_query();
if ( empty($s) ) { ?>
<div class="container">
  <main class="main">
    <section class="articles">
      <h1 class="articles__ttl">「<?php echo $s; ?>」の検索結果</h1>

<div class="article e404">
  <p class="e404__desc">
    いつも当サイトをご利用いただきありがとうございます。</p>
  <p class="e404__desc">
    大変申し訳ございませんが、お探しの条件に一致するページは<br>
    見つかりませんでした。
  </p>
  <p class="e404__desc">
    条件を変えて再度検索いただくか、改めてホームよりコンテンツをお探しください。<br>
    なお、新着記事や月間ランキングもあわせてご確認いただけますと幸いです。
  </p>
  <div class="e404__links">
    <a class="e404__btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">ホームへ戻る</a>
  </div>
  <?php get_template_part('parts/new-articles'); ?>
  <?php get_template_part('parts/ranking-articles'); ?>
</div>

<?php } else {?>
<div class="container">
  <main class="main">
    <section class="articles">
      <h1 class="articles__ttl">「<?php echo $s; ?>」の検索結果</h1>
      <?php
      $paged = get_query_var('paged') ? get_query_var('paged') : 1 ;
      $args = array( 
        'post_type' => 'post',
        'paged' => $paged,
        'posts_per_page' => 15,
        's' => $s
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()):
      ?>
      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

      <a class="article1" href="<?php the_permalink(); ?>">
        <div class="article1__img">
          <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
        </div>

        <div class="article1__desc">
          <h2 class="article1__ttl"><?php the_title(); ?></h2>
          <p class="article1__txt"><?php the_excerpt(); ?></p>
          <p class="article1__date"><time class="article1__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y/m/d' ); ?></time></p>
        </div>
      </a>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
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
      <?php else: ?>
            <div class="article e404">
              <p class="e404__desc">
                いつも当サイトをご利用いただきありがとうございます。</p>
              <p class="e404__desc">
              お探しの条件に一致するページは見つかりませんでした。
              </p>
              <p class="e404__desc">
                条件を変えて再度検索いただくか、改めてホームよりコンテンツをお探しください。
              </p>
            </div>

            <div class="e404__links">
              <a class="e404__btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">ホームへ戻る</a>
            </div>

      <?php endif; ?>
      <?php } ?>
      <!-- /.articles --></section>  
  </main>
  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>