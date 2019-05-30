<!DOCTYPE html>
<html lang="ja">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=1140">
    <?php wp_head(); ?>

  </head>

  <body <?php body_class(); ?>>

    <?php if ( is_front_page() ): ?>
    <header class="header header">
      <div class="header__inner">
        <h1 class="header__ttl">
          <a class="header__ttl-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span class="header__ttl-main"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="月刊MA"></span>
            <span class="header__ttl-sub">出会いの情報なら月刊マッチングアプリ</span>
          </a>
        </h1>
        <?php else:?>
        <header class="header header">
          <div class="header__inner">
            <p class="header__ttl">
              <a class="header__ttl-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="header__ttl-main"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="月刊MA"></span>
                <span class="header__ttl-sub">出会いの情報なら月刊マッチングアプリ</span>
              </a>
            </p>
            <?php endif; ?>
            <!-- /.inner --></div>
          <!-- /.header --></header>
        <nav class="gnav">
          <ul class="gnav__list">
            <li class="gnav__item js-menu-app"><div class="gnav__link is-menu js-app">アプリ一覧</div></li>
            <li class="gnav__item js-menu-tag"><div class="gnav__link is-menu js-tag">タグ一覧</div></li>
            <li class="gnav__item js-menu-ma"><div class="gnav__link is-menu js-col">月刊MA連載</div></li>
            <li class="gnav__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>ranking" class="gnav__link">ランキング</a></li>
            <li class="gnav__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>author" class="gnav__link">監修&amp;ライター</a></li>
            <li class="gnav__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>contact" class="gnav__link">お問い合わせ</a></li>
            <li class="gnav__item"><div class="gnav__link gnav__link--search js-s"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon_search.png" alt=""></div></li>
          </ul>
        </nav>
        
        <div class="hide-gnav js-apps">
          <ul class="hide-gnav__list">

            <?php
            $terms = get_terms('apps_type');
            foreach ( $terms as $term ) {
              $term = $term->name;
              $args = array(
                'post_type' => 'apps',
                'post_status' => 'publish',
                'tax_query' => array(
                  'relation' => 'AND',
                  array(
                    'taxonomy' => 'apps_type',
                    'field' => 'slug',
                    'terms' => $term,
                    'include_children' => true,
                    'operator' => 'IN'
                  ),
                )
              );
            ?>

            <li class="hide-gnav__item">
              <p class="hide-gnav__ttl">◆ <?php echo $term; ?></p>
              <ul class="hide-gnav__list-list">

                <?php
              $the_query = new WP_Query($args); if($the_query->have_posts()):
              while ($the_query->have_posts()): $the_query->the_post(); ?>


                <li class="hide-gnav__item-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>category/<?php the_title(); ?>" class="hide-gnav__link"> <?php the_title(); ?></a></li>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>

              </ul>
            </li>
            <?php }
            ?>

          </ul>
        </div>


        <div class="hide-gnav js-tags">
          <ul class="hide-gnav__tags">

            <?php
            $args = array(
              'orderby' => 'name',
              'order' => 'ASC'
            );
            $posttags = get_tags( $args );

            if ( $posttags ){
              foreach( $posttags as $tag ) {
            ?>
            <li class="hide-gnav__tag">
              <a href=" <?php echo get_tag_link( $tag->term_id ); ?>" class="hide-gnav__tag-link"><?php echo $tag->name; ?></a>
            </li>
            <?php }
            }
            ?>

          </ul>
        </div>

        <div class="hide-gnav js-cols">
          <ul class="hide-gnav__tags">

            <?php
            $args = array( 
              'post_type' => 'column_cover'
            );
            $the_query = new WP_Query($args); if($the_query->have_posts()):
            ?>
            <?php while ($the_query->have_posts()): $the_query->the_post(); ?>

            <li class="hide-gnav__tag">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>?s=&term=<?php the_title(); ?>" class="hide-gnav__tag-link"><?php the_title(); ?></a>
            </li>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php endif; ?> 


          </ul>
        </div>
        
        <div class="hide-gnav js-searchs">
          <form method="get" class="gnav__search-inner" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="gnav__search">
              
                <input class="gnav__search-form" type="text" value="<?php echo get_search_query(); ?>" placeholder="検索する" name="s" id="s" />
                <input type="submit" value="&#xf002;" class="fas gnav__search-submit">
                
            </div>
          </form>
        </div>
