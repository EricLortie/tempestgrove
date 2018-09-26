/* =============================================================================

    COMPONENT: TABS JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        $('.tabs__tab-item-link').on('click', function(e) {

            // Tab Navigation
            $('.tabs__tab-item-link').removeClass('current');
            $(this).addClass('current');

            // Tab Content
            var tab_id = $(this).attr('data-tab');
            $('.tabs__tab-content').removeClass('current');
            $('.tabs__tab-content[data-tab="' + tab_id + '"]').addClass('current');

        });

    });

})(jQuery);
