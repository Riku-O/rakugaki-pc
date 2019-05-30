(function($) {

$('.hide-gnav').hide();

function gnav(target, elm) {
  target.on('click',function(){
    if ( $('.hide-gnav').hasClass('open') ) {
      if ( elm.hasClass('open') ) {// クリックメニュー出てるなら
        elm.removeClass('open');
        target.removeClass('is-open');
        elm.slideUp(300);
      } else {// クリックメニュー以外が出てるなら
        $('.hide-gnav').removeClass('open');
        $('.hide-gnav').slideUp(300);
        $('.gnav__link').removeClass('is-open');
        elm.addClass('open');
        elm.slideDown(300);
        target.addClass('is-open');
      }
    } else {
      elm.addClass('open');
      elm.slideDown(300);
      target.addClass('is-open');
    }
  });
}

gnav($('.js-app'), $('.js-apps'));
gnav($('.js-tag'), $('.js-tags'));
gnav($('.js-col'), $('.js-cols'));

$('.js-s').on('click',function(){
  if ( $('.hide-gnav').hasClass('open') ) {
    if ( $('.js-searchs').hasClass('open') ) {// クリックメニュー出てるなら
      $('.js-searchs').removeClass('open');
      $('.js-searchs').slideUp(300);
    } else {// クリックメニュー以外が出てるなら
      $('.hide-gnav').removeClass('open');
      $('.hide-gnav').slideUp(300);
      $('.gnav__link').removeClass('is-open');
      $('.js-searchs').addClass('open');
      $('.js-searchs').slideDown(300);
      $('.gnav__search-form').eq(0).focus();
    }
  } else {
    $('.js-searchs').addClass('open');
    $('.js-searchs').slideDown(300);
    $('.gnav__search-form').eq(0).focus();
  }
});

$('.js-search').on('click',function(){
  $( '.gnav' ).animate({ 
    opacity: 1
  }, 500 );
  $( '.gnav' ).css('pointer-events', 'auto');
  $('input').eq(0).focus();
  setTimeout(function(){
    let current_scrollY = $( window ).scrollTop(); 
    $( 'body' ).css( {
      position: 'fixed',
      top: -1 * current_scrollY
    } );
  },500);
});

})( jQuery );