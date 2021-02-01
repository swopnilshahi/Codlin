(function ($) {
    'use strict';
    $(function () {
        preFunction();
    });

    $(window).on('load resize', function () {
        preFunction();
    });

    function preFunction() {
        HeightResize();
    }

    $(window).on('load', function () {
        $('.tss-wrapper').each(function () {
            var container = $(this);
            var str = $(this).attr("data-layout");
            if (str) {
                var caro = container.find('.tss-carousel');
                if (caro.length) {
                    caro.parents('.rt-row').removeClass('tss-pre-loader');
                    var items = caro.data('items-desktop'),
                        tItems = caro.data('items-tab'),
                        mItems = caro.data('items-mobile'),
                        loop = caro.data('loop'),
                        nav = caro.data('nav'),
                        dots = caro.data('dots'),
                        autoplay = caro.data('autoplay'),
                        autoPlayHoverPause = caro.data('autoplay-hover-pause'),
                        autoPlayTimeOut = caro.data('autoplay-timeout'),
                        autoHeight = caro.data('auto-height'),
                        smartSpeed = caro.data('smart-speed');
                    caro.addClass('owl-carousel owl-theme').owlCarousel({
                        items: items ? items : 3,
                        loop: loop ? true : false,
                        nav: nav ? true : false,
                        dots: dots ? true : false,
                        navText: ["<span class=\'dashicons dashicons-arrow-left-alt2\'></span>", "<span class=\'dashicons dashicons-arrow-right-alt2\'></span>"],
                        autoplay: autoplay ? true : false,
                        autoplayHoverPause: autoPlayHoverPause ? true : false,
                        autoplayTimeout: autoPlayTimeOut ? autoPlayTimeOut : 5000,
                        smartSpeed: smartSpeed ? smartSpeed : 250,
                        autoHeight: autoHeight ? true : false,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: mItems ? mItems : 1
                            },
                            767: {
                                items: tItems ? tItems : 2
                            },
                            991: {
                                items: items ? items : 3
                            }
                        }
                    });
                }
            }
        });
    });

    function HeightResize() {
        var wWidth = $(window).width();
        $(".tss-wrapper").each(function () {
            var self = $(this),
                dCol = self.data('desktop-col'),
                tCol = self.data('tab-col'),
                mCol = self.data('mobile-col'),
                target = $(this).find('.rt-row.tss-even');
            if ((wWidth >= 992 && dCol > 1) || (wWidth >= 768 && tCol > 1) || (wWidth < 768 && mCol > 1)) {
                target.imagesLoaded(function () {
                    var tlpMaxH = 0;
                    target.find('.even-grid-item').height('auto');
                    target.find('.even-grid-item').each(function () {
                        var $thisH = $(this).outerHeight();
                        if ($thisH > tlpMaxH) {
                            tlpMaxH = $thisH;
                        }
                    });
                    target.find('.even-grid-item').height(tlpMaxH + "px");
                });
            } else {
                target.find('.even-grid-item').height('auto');
            }

        });
    }
})(jQuery);