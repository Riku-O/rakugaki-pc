<?php if ( !is_front_page() && !is_page('ranking') ) : ?>
 <section class="sidebar__item">
  <h2 class="archives__ttl">
    <div class="archives__sidebar">月間ランキング</div>
  </h2>

  <ul class="sidebar__articles">
    <?php
    $cnt = 1;
    $args = array(
      'post_status' => 'publish',
      'posts_per_page' => 3,
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

    <?php if( $cnt == 1 ) : ?>
    <li class="sidebar__articles-wrap">
      <a class="sidebar__articles-link" href="<?php the_permalink(); ?>">      
       <div class="sidebar__articles-img">
        <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pc/rank-label.png" alt="1位" class="sidebar__articles-label">
      </div>
      <div class="sidebar__articles-desc">
        <h2 class="sidebar__articles-ttl"><?php the_title(); ?></h2>
      </div>
      </a>
    </li>

   <?php else : ?>
  <li>
    <a class="sidebar__articles2" href="<?php the_permalink(); ?>">
      <div class="sidebar__articles2-img">
        <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
        <span class="article__rank"><span class="article__rank-txt">No.<?php echo $cnt; ?></span></span>
      </div>
      <div class="sidebar__articles2-desc">
        <h2 class="sidebar__articles-ttl"><?php the_title(); ?></h2>
      </div>
    </a>
  </li>
   
    <?php endif; ?>
    <?php $cnt++; ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </ul>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>ranking" class="sidebar__article-more">もっと見る</a>

</section>
<?php endif; ?>

<?php if( is_page('ranking') ) : ?>
<section class="sidebar__item">
  <h2 class="archives__ttl">
    <div class="archives__sidebar">新着記事</div>
  </h2>

  <ul class="sidebar__articles">
    <?php
    $cnt = 1;
    $args = array(
      'post_status' => 'publish',
      'posts_per_page' => 3
    );
    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post();?>

    <?php if( $cnt == 1 ) : ?>
    <li class="sidebar__articles-wrap">
      <a class="sidebar__articles-link" href="<?php the_permalink(); ?>">      
        <div class="sidebar__articles-img">
        <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
        <?php if ( is_newest_post($post, 3) ) { ?>
        <span class="article__rank--1"><span class="article__rank--1-txt">New</span></span>
        <?php } ?>
        </div>
        <div class="sidebar__articles-desc">
          <h2 class="sidebar__articles-ttl"><?php the_title(); ?></h2>
        </div>
      </a>
    </li>

    <?php else : ?>
    <li>
      <a class="sidebar__articles2" href="<?php the_permalink(); ?>">
        <div class="sidebar__articles2-img">
          <img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
          <?php if ( is_newest_post($post, 3) ) { ?>
          <span class="article__rank"><span class="article__rank-txt">New</span></span>
          <?php } ?>
        </div>
        <div class="sidebar__articles2-desc">
          <h2 class="sidebar__articles-ttl"><?php the_title(); ?></h2>
        </div>
      </a>
    </li>

    <?php endif; ?>
    <?php $cnt++; ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  </ul>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>news" class="sidebar__article-more">もっと見る</a>

</section> 
<?php endif; ?>


 <section class="sidebar__item">
  <h2 class="archives__ttl">
    <div class="archives__sidebar">特集</div>
  </h2>
  
  <ul class="front__special-list">
    <?php
    $args = array( 
      'post_type' => 'special',
      'posts_per_page' => 3
    );

    $the_query = new WP_Query($args); if($the_query->have_posts()):
    ?>
    <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

    <li class="front__special-item">
      <a href="<?php the_field('special_url'); ?>" class="front__special-link">
        <img src="<?php the_field('special_img') ?>" alt="<?php the_title(); ?>" class="front__special-img">
      </a>
    </li>

    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php else: ?>
    <!-- 投稿が無い場合の処理 -->
    <?php endif; ?>
  </ul>
  
  
</section>

<section class="sidebar__item">
  <h2 class="archives__ttl">
    <div class="archives__sidebar">アプリ一覧</div>
    
    <ul class="sidebar__apps">

      <?php
      $args = array( 
        'post_type' => 'apps',
        'order' => 'ASC'        
      );
      $the_query = new WP_Query($args); if($the_query->have_posts()):
      ?>

      <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

      <li class="sidebar__apps-item">
        <a href="<?php the_field('apps_url') ?>" class="sidebar__apps-link"><img class="sidebar__apps-img" src="<?php the_field('apps_icon') ?>">
        <p class="sidebar__apps-name"><?php the_title(); ?></p>
        </a>
      </li>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>
      <!-- /.wrapper --></ul>
  </h2>
</section>

<section class="sidebar__item">
  <h2 class="archives__ttl">
    <div class="archives__sidebar">タグ</div>
  </h2>
  
  <div class="front__apps">
    <?php
    // パラメータを指定
    $args = array(
      // タグ名順で指定
      'orderby' => 'name',
      // 昇順で指定
      'order' => 'ASC'
    );
    $posttags = get_tags( $args );

    if ( $posttags ){
      echo ' <ul class="sidebar__tag-list"> ';
      foreach( $posttags as $tag ) {
        echo '<li class="sidebar__tag-item"><a class="sidebar__tag-link" href="'. get_tag_link( $tag->term_id ) . '">#' . $tag->name . '</a></li>';
      }
      echo ' </ul> ';
    }
    ?>
  </div>
</section>
<div class="sidebar-fb">
  <a class="twitter-timeline" data-height="800" data-theme="dark" href="https://twitter.com/TwitterDev/timelines/539487832448843776?ref_src=twsrc%5Etfw">National Park Tweets - Curated tweets by TwitterDev</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>