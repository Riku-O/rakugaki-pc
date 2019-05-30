(function($) {
  if ( $('.single-content h2').length ) {
    $('.single__bookmark').insertBefore($('.single-content h2').eq(0));
    let h2list = $('.single-content h2');
    $.each(h2list, function(index, value){
      $('.single-content h2').eq(index).attr('id', String(index));
      $('.single__bookmark-list').append(' <li class="single__bookmark-item"><a href="#' + index + '" class="single__bookmark-link">' + $('.single-content h2').eq(index).text() + '</a></li>')
    })
  } else {
    $('.single__bookmark').remove();
  }
  
  $(".single__bookmark-btn").on("click touched", function() {
    if ( $(this).hasClass( 'close' ) ) {
      $(this).removeClass('close');
      $('.single__bookmark-ttl').css('border-bottom-right-radius', '0');
      $('.single__bookmark-ttl').css('border-bottom-left-radius', '0');
    } else {
      $(this).addClass('close');
      $('.single__bookmark-ttl').css('border-bottom-right-radius', '4px');
      $('.single__bookmark-ttl').css('border-bottom-left-radius', '4px');
    }
    $('.single__bookmark-list').slideToggle();
  });

  $('a[href^="#"]').click(function() {
    var speed = 600;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  });

})( jQuery );