jQuery(document).ready(function ($) {

   /*  $('.sp-testimonial-pro-read-more.tpro-readmore-expand-true').each(function (index) {
        var tpro_custom_read_id = $(this).attr('id');
        var tpro_read_more_config = $.parseJSON($(this).closest('.sp-testimonial-pro-wrapper').find('.sp-tpro-rm-config').text());

        if ( tpro_custom_read_id != '') {

            $('#' + tpro_custom_read_id + ' .tpro-client-testimonial').curtail({
                limit: parseInt(tpro_read_more_config.testimonial_characters_limit),
                ellipsis: (tpro_read_more_config.testimonial_read_more_ellipsis),
                toggle: true,
                text: [(tpro_read_more_config.testimonial_read_less_text), (tpro_read_more_config.testimonial_read_more_text)]
            });
            // Expand message
            $('#' + tpro_custom_read_id + ' .tpro-client-testimonial .tpro-read-more').on('click', function() {
                $(this).parent().toggleClass('tpro-testimonial-expanded');

                // Check if there is masonry grid on the page and reload it
                if( $(".sp_testimonial_pro_masonry").length ) {
                    $(this).closest(".sp_testimonial_pro_masonry").masonry();
                }

                // Check if there is slider on the page and reload it
                if( $(".sp_testimonial_pro_filter").length ) {
                    $(this).closest(".sp-tpro-isotope-items, .isotope").resize();
                }
            });

        }
    }); */
});
