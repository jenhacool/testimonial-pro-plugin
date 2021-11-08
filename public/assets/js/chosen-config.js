jQuery(function ($) {

    'use strict';

    /* ==== Chosen ====*/
    $(".chosen-select").chosen({width: "100%"});

    /* ==== Social Profile Check ====*/
    $(".tpro-social-profile-check").change(function () {
        var social_profile_check = $("input[name=tpro_social_profile_check]").attr('checked') ? '1' : '0';
        if (social_profile_check == '1') {
            $('.tpro-social-profile-links').show();
        } else {
            $('.tpro-social-profile-links').hide();
        }
    });

});
