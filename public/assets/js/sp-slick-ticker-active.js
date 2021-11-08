jQuery(document).ready(function ($) {

    $('.sp-testimonial-pro-section.tpro-layout-slider-ticker').each(function () {

        var tpro_custom_ticker_id = $(this).attr('id');

        if ( tpro_custom_ticker_id != '') {

            jQuery('#' + tpro_custom_ticker_id).slick({
                pauseOnFocus: false,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 0,
                swipe: false,
                draggable: false,
                arrows: false,
                dots: false,
                cssEase: 'linear'
            });
        }
    });
});