// ; (function ($) {
jQuery(document).ready(function ($) {
    /**
     * Preloader.
     */
    $('body').find('.sp-testimonial-pro-section').each(function () {
        var _this = $(this),
            custom_id = $(this).attr('id'),
            preloader = _this.data('preloader');

        if ('1' == preloader) {
            var parents_class = $('#' + custom_id).parent('.sp-testimonial-pro-wrapper'),
                parents_siblings_id = parents_class.find('.tpro-preloader').attr('id');
            $(window).load(function () {
                setTimeout(function () {
                    $('#' + parents_siblings_id).css({ 'opacity': 0, 'display': 'none' });
                }, 600);
                $('#' + custom_id).animate({ opacity: 1 }, 600);
            })
        }
    });

    /* === Masonry === */

    /* === Testimonial Submit Form === */
    (function () {
        $("#testimonial_form").validate();
    }());


    $('.sp-testimonial-pro-wrapper').each(function () {
        var sliderID = $(this).attr('id');
        var testimonailData = $("#" + sliderID + " .sp-testimonial-pro-section").data("testimonial");
        var stpmsnry;
        function tpro_read_more_init() {
            if ($('#' + sliderID +  ' .sp-testimonial-pro-read-more.tpro-readmore-expand-true').length > 0) {
                $('#' + sliderID +  ' .sp-testimonial-pro-read-more.tpro-readmore-expand-true').each(function (index) {
                    var tpro_custom_read_id = $(this).attr('id');
                    var tpro_read_more_config = JSON.parse($(this).closest('.sp-testimonial-pro-wrapper').find('.sp-tpro-rm-config').text());
                    $('#' + tpro_custom_read_id + ' .tpro-client-testimonial .tpro-read-more:contains(' + tpro_read_more_config.testimonial_read_more_text + ')').trigger('click');
                    if (tpro_custom_read_id != '') {
                        $(document).find('#' + tpro_custom_read_id + ' .tpro-client-testimonial').curtail({
                            limit: parseInt(tpro_read_more_config.testimonial_characters_limit),
                            ellipsis: (tpro_read_more_config.testimonial_read_more_ellipsis),
                            toggle: true,
                            text: [(tpro_read_more_config.testimonial_read_less_text), (tpro_read_more_config.testimonial_read_more_text)]
                        });
                        // Expand message
                        $('#' + tpro_custom_read_id + ' .tpro-client-testimonial .tpro-read-more').on('click', function () {
                            $(this).parent().toggleClass('tpro-testimonial-expanded');

                            // Check if there is masonry grid on the page and reload it
                            if ($('#' + sliderID +  ' .sp_testimonial_pro_masonry').length) {
                                $('#' + sliderID +  ' .sp_testimonial_pro_masonry .sp-tpro-items').masonry();
                            }

                            // Check if there is slider on the page and reload it
                            if ($(".sp_testimonial_pro_filter").length) {
                                $(this).closest(".sp-tpro-isotope-items, .isotope").resize();
                            }
                        });

                    }
                });
            }
        }

        tpro_read_more_init();


        function trpo_masonry_init() {
            var masonry = $("#"  + sliderID + " .sp_testimonial_pro_masonry .sp-tpro-items");
            if (masonry.length > 0) {
                // $(window).on('load', function () {
                masonry.masonry(); // Masonry
                // });
                masonry.imagesLoaded(function () {
                    masonry.masonry(); // Masonry
                });
                stpmsnry = masonry.data('masonry');
            }
        };
        trpo_masonry_init();
        /* == MagnificPopup == */
        function tpro_popup_init() {
            if (testimonailData.thumbnailSlider == false && testimonailData.videoIcon === 1) {
                $('.sp-tpro-video').magnificPopup({
                    type: 'iframe',
                    mainClass: 'mfp-fade',
                    preloader: false,
                    fixedContentPos: false
                });
            }
        }
        tpro_popup_init();
        var appendClass = ' .sp-tpro-items > div';

        if ($("#" + sliderID + " .sp-testimonial-pro-section.infinite_scroll").length > 0) {
            $("#" + sliderID + " .sp-testimonial-pro-section.infinite_scroll .sp-tpro-items").infiniteScroll({
                // options
                path: '#' + sliderID + ' .sp-tpro-pagination a.page-numbers',
                append: '#' + sliderID + appendClass,
                scrollThreshold: 100,
                history: false,
                outlayer: stpmsnry,
                status: '#' + sliderID + ' .page-load-status',
                button: '#' + sliderID + ' .tpro-post-load-more',
                hideNav: '#' + sliderID + ' .sp-tpro-pagination-area'
            }).on('load.infiniteScroll', function (event, response, path) {
                setTimeout(function () {
                    tpro_popup_init();
                    tpro_read_more_init();
                    trpo_masonry_init();
                    if ($('[data-remodal-id]').length > 0) {
                        $('[data-remodal-id]').remodal();
                    }
                }, 300);
            });
        }
        if ($("#" + sliderID + " .sp-testimonial-pro-section.ajax_load_more").length > 0) {
            $("#" + sliderID + " .sp-testimonial-pro-section.ajax_load_more .sp-tpro-items").infiniteScroll({
                // options
                path: '#' + sliderID + ' .sp-tpro-pagination a.page-numbers',
                append: '#' + sliderID + appendClass,
                scrollThreshold: 100,
                history: false,
                status: '#' + sliderID + ' .page-load-status',
                loadOnScroll: false,
                elementScroll: true,
                outlayer: stpmsnry,
                button: '#' + sliderID + ' .tpro-items-load-more',
                hideNav: '#' + sliderID + ' .sp-tpro-pagination-area'
            }).on('load.infiniteScroll', function (event, response, path) {
                setTimeout(function () {
                    tpro_popup_init();
                    tpro_read_more_init();
                    trpo_masonry_init();
                    if ($('[data-remodal-id]').length > 0) {
                        $('[data-remodal-id]').remodal();
                    }
                }, 300);
            });
        }
        if ($("#" + sliderID + " .sp-testimonial-pro-section.ajax_pagination").length > 0) {
            $("#" + sliderID).on('click', '.sp-tpro-pagination a', function (e) {
                // $("#" + sliderID ).parent('.sp-testimonial-pro-wrapper').css('position', 'relative');
                e.preventDefault();
                e.stopPropagation();
                var link = $(this).attr('href');

                $("#" + sliderID + " .tpro-preloader").css("display", "block");
                $("#" + sliderID + " .tpro-preloader").css("opacity", 1);
                $("#" + sliderID).load(link + " #" + sliderID + " > *", function () {
                    tpro_popup_init();
                    tpro_read_more_init();
                    trpo_masonry_init();
                    if ($('[data-remodal-id]').length > 0) {
                        $('[data-remodal-id]').remodal();
                    }
                    setTimeout(function () {
                        $("#" + sliderID + " .tpro-preloader").css({ "opacity": 0, "display": "none" });
                    }, 1000);
                });
            });
        }
    });

    jQuery.fn.extend({
        createProfile: function (options = {}) {
            var hasOption = function (optionKey) {
                return options.hasOwnProperty(optionKey);
            };

            var option = function (optionKey) {
                return options[optionKey];
            };

            var generateId = function (string) {
                return string
                    .replace(/\[/g, '_')
                    .replace(/\]/g, '')
                    .toLowerCase();
            };

            var addItem = function (items, key, fresh = true) {
                var itemContent = items;
                var group = itemContent.data("group");
                var item = itemContent;
                var input = item.find('input,select');

                input.each(function (index, el) {
                    var attrName = $(el).data('name');
                    var skipName = $(el).data('skip-name');
                    if (skipName != true) {
                        $(el).attr("name", group + "[" + key + "][" + attrName + "]");
                    } else {
                        if (attrName != 'undefined') {
                            $(el).attr("name", attrName);
                        }
                    }
                    if (fresh == true) {
                        $(el).attr('value', '');
                    }

                    $(el).attr('id', generateId($(el).attr('name')));
                    $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
                })

                var itemClone = items;

                /* Handling remove btn */
                var removeButton = itemClone.find('.tpro-social-profile-remove');

                removeButton.attr('onclick', 'jQuery(this).parents(\'.tpro-social-profile-item\').remove()');

                var newItem = $("<div class='tpro-social-profile-item'>" + itemClone.html() + "<div/>");
                newItem.attr('data-index', key)

                newItem.appendTo(repeater);
            };


            /* find elements */
            var repeater = this;
            var items = repeater.find(".tpro-social-profile-item");
            var key = 0;
            var addButton = $('.tpro-social-profile-wrapper').find('.tpro-add-new-profile-btn');

            items.each(function (index, item) {
                items.remove();
                if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
                    addItem($(item), key);
                    key++;
                } else {
                    if (items.length > 1) {
                        addItem($(item), key);
                        key++;
                    }
                }
            });

            /* handle click and add items */
            addButton.on("click", function () {
                addItem($(items[0]), key);
                key++;
            });

        }
    });


    $("#tpro-social-profiles").createProfile({
        showFirstItemToDefault: true,
    });

});
