jQuery(document).ready(function ($) {
  /* back-to-top button */
  $('.back-to-top').hide();
  $('.back-to-top').on("click", function (e) {
      e.preventDefault();
      $('html, body').animate({
          scrollTop: 0
      }, 'slow');
  });
  $(window).scroll(function () {
      var scrollheight = 400;
      if ($(window).scrollTop() > scrollheight) {
          $('.back-to-top').fadeIn();

      } else {
          $('.back-to-top').fadeOut();
      }
  });  
  /*toggle search button*/
  $(".search-button a").click(function () {
    $(".header-search .search-form ").toggleClass("active");
  });

  /*mean-menu responsive js*/
  $('.menu-container').meanmenu({
    meanMenuContainer: '.hgroup-right',
    meanScreenWidth: "767",
    meanRevealPosition: "left",
  });

  /*owl-carousel*/
  $('#myCarousel').carousel({
    interval: 4000
  });


  var owl = $("#post-slider");
  owl.owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    autoplay: true,
    autoplayTimeout: 4000,
    fallbackEasing: 'easing',
    transitionStyle: "fade",
    dots: false,
    autoplayHoverPause: true
  });

  /*team slider*/
  $('.affiliation-slider').owlCarousel({
    loop: true,
    margin:50,
    responsiveClass: true,
    dots: false,
    autoplay: true,
    responsive: {
      0: {
        items: 2,
      },
      640: {
        items: 3,
      },

      992: {
        items: 4,
      },
      1200: {
        items: 5,
      }
    }
  });

  // slider
  var owllogo = $("#owl-slider-demo");

  owllogo.owlCarousel({
    items: 1,
    margin:50,
    loop: true,
    nav: true,
    dots: false,
    smartSpeed: 900,
    autoplay: true,
    autoplayTimeout: 5000,
    fallbackEasing: 'easing',
    transitionStyle: "fade",
    autoplayHoverPause: true,
    animateOut: 'fadeOut'
  });

  // HIdden sidebar toggle
  $('.hide-show-point').click(function () {
    $('.hidden-sidebar').toggleClass('on');

  });
  $('.inner-hide-show-point').click(function () {
    $('.hidden-sidebar').removeClass('on');
  });

});