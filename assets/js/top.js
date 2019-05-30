(function($) {

  var fvSwiper = new Swiper ('.swiper-fv', {
    loop: false,
    slidesPerView: 1,
    speed: 900,
    autoplay: {
      delay: 4000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    loop: true,
  })
})( jQuery );