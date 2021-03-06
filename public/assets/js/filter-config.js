jQuery(document).ready(function ($) {
    // ----------------------------------------------
    //  Isotope Filter
    // ----------------------------------------------
    $('.sp-testimonial-pro-section.sp_testimonial_pro_filter').each(function (index) {

        var filter_id = $(this).attr('id');
        var tpro_filter_config = $.parseJSON($(this).closest('.sp-testimonial-pro-wrapper').find('.sp-tpro-config').text());

        var winDow = $(window);
        var $container = $('#' + filter_id + ' .sp-tpro-isotope-items');
        var $filter = $('#' + filter_id + ' .sp-tpro-filter');
        try {
            $container.imagesLoaded(function () {
                $container.show();
                $container.isotope({
                    filter: '*',
                    layoutMode: (tpro_filter_config.filter_mode),
                    animationOptions: {
                        duration: 750,
                        easing: 'linear'
                    }
                });
            });
        } catch (err) {
        }

        winDow.bind('resize', function () {
            var selector = $filter.find('a.active').attr('data-filter');

            try {
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false,
                    }
                });
            } catch (err) {
            }
            return false;
        });

        $filter.find('a').click(function () {
            var selector = $(this).attr('data-filter');
            try {
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
            } catch (err) {

            }
            return false;
        });

        var filterItemA = $('#' + filter_id + ' .sp-tpro-filter a');
        filterItemA.on('click', function () {
            var $this = $(this);
            if (!$this.hasClass('active')) {
                filterItemA.removeClass('active');
                $this.addClass('active');
            }
        });


    });
});
