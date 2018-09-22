/* =============================================================================

    APP JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        // Wordpress Image Wrapper
        if($('.wp-image').length) {
            $('.wp-image').parent().addClass('wp-image__wrapper');
        }

        // Borken Images
        $('img').on('error', function() {
            $(this).addClass('broken');
        });

        // Responsive Tables
        if($('.content-area table').length) {
            $('.content-area table').each(function(e) {
                $(this).wrap($('<div class="table-wrapper"></div>'));
            });
        }

    });

})(jQuery);
