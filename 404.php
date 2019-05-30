<?php
get_header(); ?>

<div class="container">
  <main class="main">
    <section class="articles">
      <h1 class="articles__ttl">404 NOT FOUND</h1>

      <div class="article e404">
        <p class="e404__desc">
          いつも当サイトをご利用いただきありがとうございます。</p>
        <p class="e404__desc">
         大変申し訳ございませんが、<br>
          お探しのページは存在しないか、削除された可能性がございます。<br>
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

      <!-- /.articles --></section>  
  </main>
  
  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php
get_footer();