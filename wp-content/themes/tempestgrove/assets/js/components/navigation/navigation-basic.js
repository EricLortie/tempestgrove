/* =============================================================================

    COMPONENT: NAVIGATION (BASIC) JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        // Basic Nav: Hide/Show on Mobile
        $('.nav-toggle').on('click', function(e) {
            $('html').toggleClass('hide-overflow');
            $(this).toggleClass('show');
            $('.main-nav').toggleClass('show');
            if($(this).hasClass('show')) {
                $(this).text('Hide Menu');
            } else {
                $(this).text('Menu');
            }
        });

        $('.has-submenu > [class$="item-link"]').append('<span class="main-nav__submenu-expand"></span>');

        $('.main-nav__submenu-expand').on('click', function(e) {
            $(this).parent().toggleClass('active');
            $(this).parent().siblings('[class*="main-nav__submenu--"]').toggleClass('open');
            e.preventDefault();
        });

    });

})(jQuery);
