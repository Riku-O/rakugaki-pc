<?php get_header(); ?>

<div class="container">
  <main class="main">
    <h1 class="archives__ttl">
      <span class="archives__sub">カテゴリー</span>
      <div class="archives__main">監修&amp;ライター</div>
    </h1>
    
    <?php 
    $user = get_userdata($author);
    $userID = $user->user_login;
    $id = $user->ID;
    $name = $user->writer_name;
    $subname = $user->writer_subname;
    $position = $user->writer_position;
    $product = $user->writer_product;
    $img = $user->writer_img;
    $desc = $user->writer_desc;
    $tw = $user->writer_tw;
    $fb = $user->writer_fb;
    $link = get_author_posts_url($id);
    ?>
    <section class="author-prof">
      <img src="<?php echo wp_get_attachment_url($img); ?>" alt="<?php echo $name; ?>">
      <div class="author-prof__meta">
        <div class="author-prof__meta-name">
          <h2 class="author-prof__name"><?php echo $name; ?></h2>
          <p class="author-prof__position"><?php echo $position; ?></p>
        </div>
        <p class="author-prof__subname"><?php echo $subname; ?></p>
      </div>
      <div class="author-prof__desc">
        <?php echo $desc; ?>
      </div>
      <ul class="author-prof__sns">
        <li class="author-prof__sns-item"><a href="https://twitter.com/<?php echo $tw; ?>" class="author-prof__tw" target="_blank">@<?php echo $tw; ?></a></li>
        <li class="author-prof__sns-item"><a href="https://ja-jp.facebook.com/<?php echo $fb; ?>" class="author-prof__fb" target="_blank"><?php echo $fb; ?></a></li>
      </ul>
    <!-- /.author-prof --></section>
    
    <section class="articles articles-side"> 

      <h2 class="archives__ttl">
        <div class="archives__side">執筆記事</div>
      </h2>

      <a class="article1" href="<?php the_permalink(); ?>">
        <?php
        $args = array( 
          'posts_per_page' => 1,
          'author' => $id
        );
        $the_query = new WP_Query($args); if($the_query->have_posts()):
        ?>
        <?php while ($the_query->have_posts()): $the_query->the_post();?>

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

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </a>

      <div class="article-wrap">
        <?php
        $pages = 4;
        if ( !is_front_page() ) {
          $pages = 3;
        }
        $args = array( 
          'posts_per_page' => $pages
        );
        $the_query = new WP_Query($args); if($the_query->have_posts()):
        ?>
        <?php while ($the_query->have_posts()): $the_query->the_post();?>
        <?php 
        if ( !is_front_page() ) {
          $cnt = 2;
        }
        ?>
        <?php if ($cnt <= 1) :?>
        <?php else : ?>
        <article class="article-rows">
          <a href="<?php the_permalink(); ?>" class="article-rows__link">
            <h3 class="article-rows__ttl"><?php the_title(); ?></h3>
            <div class="article-rows__img"><img src="<?php echo get_thumbnail(); ?>" alt="<?php echo get_thumbnail_alt(); ?>">
              <?php if ( is_newest_post($post, 3) ) { ?>
              <span class="article__rank"><span class="article__rank-txt">New</span></span>
              <?php } ?></div>
          </a>
        </article>
        <?php endif; ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
      <a class="author-prof__more" href="<?php echo esc_url( home_url( '/' ) ); ?>?s=&author=<?php echo $userID; ?>"><?php echo $name; ?>の執筆記事一覧</a>

      <!-- /.articles --></section>
    
    <!-- /.main --></main>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
  <!-- /.container --></div>

<?php get_footer();
