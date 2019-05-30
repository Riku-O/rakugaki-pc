        <footer class="footer">
            <div class="footer__inner">
               <div class="footer__wrap">
                 <p class="footer__name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__link"><?php echo getOptionValue('cp'); ?></a></p>
                    <?php //ヘッダーナビ
                    wp_nav_menu(
                      array (
                      'theme_location' => 'footer_menu',
                      'menu_class' => 'footer__list',
                      'container' => false,
                      'fallback_cb' => false
                      )
                    ); ?>
                  <small class="footer__copy">&copy; <?php echo date("Y"); ?> <?php echo getOptionValue('cp'); ?></small>
                </div>
            
            </div>
        </footer>
       
        <?php wp_footer(); ?>
    </body>
</html>