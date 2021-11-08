jQuery(document).ready(function ($) {

    $('.sp-testimonial-pro-section.tpro-layout-slider-standard').each(function () {

        var tpro_custom_slider_id = $(this).attr('id');
        var _this = $(this);

        if (tpro_custom_slider_id != '') {
            jQuery('#' + tpro_custom_slider_id).slick({
                pauseOnFocus: false,
                prevArrow: '<div class="slick-prev"><i class="fa fa-' + _this.data('arrowicon') + '-left"></i></div>',
                nextArrow: '<div class="slick-next"><i class="fa fa-' + _this.data('arrowicon') + '-right"></i></div>',
            });
        }



    });
});
