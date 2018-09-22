/* =============================================================================

    COMPONENT: NAVIGATION (SIDEBAR) JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        // Basic Panes
        $('a[data-sidebar-pane]').on('click', function(e) {
            var pane_id = $(this).attr('data-sidebar-pane');

            $('div[data-sidebar-pane]').removeClass('current');
            $('ul[data-sidebar-level]').removeClass('current');

            if($(this).hasClass('current')) {
                $('a[data-sidebar-pane]').removeClass('current');
                $('a[data-sidebar-level]').removeClass('current');
                $(this).removeClass('current');
                $('.sidebar-nav__overlay').removeClass('show');
                $('[class*="sidebar-nav__pane--"][data-sidebar-pane="' + pane_id + '"]').removeClass('current');
            } else {
                $('a[data-sidebar-pane]').removeClass('current');
                $(this).addClass('current');
                $('.sidebar-nav__overlay').addClass('show');
                $('[class*="sidebar-nav__pane--"][data-sidebar-pane="' + pane_id + '"]').addClass('current');
            }

            if($('a[data-sidebar-pane]').hasClass('current')) {
                $('html').addClass('hide-overflow');
            } else {
                $('html').removeClass('hide-overflow');
            }

        });

        // Panes: Navigation Submenus
        $('a[data-sidebar-level]').on('click', function(e) {
            $('.sidebar-nav__pane-nav--level-2 .sidebar-nav__pane-nav-item-link').removeClass('current');
            var level_id = $(this).attr('data-sidebar-level');
            $(this).parent().siblings().each(function(){
                $('a', this).removeClass('current');
            });
            $(this).addClass('current');

            if($(this).parent().parent().hasClass('sidebar-nav__pane-nav--level-1')){
                $('.sidebar-nav__pane-nav--level-3').removeClass('current');
            }

            var open_pane_class = $('[class*="sidebar-nav__pane-nav--"][data-sidebar-level="' + level_id + '"]').attr('class');
            $('.' + open_pane_class).removeClass('current');
            $('[class*="sidebar-nav__pane-nav--"][data-sidebar-level="' + level_id + '"]').addClass('current');
        });

        // Panes: Back
        $('.sidebar-nav__pane-nav-item-link.back').on('click', function(e) {
            $(this).parent().parent().removeClass('current');
            $('a[data-sidebar-level]').removeClass('current');
        });

        // Panes: Overlay
        $('.sidebar-nav__overlay').on('click', function(e) {
            $('html').removeClass('hide-overflow');
            $(this).removeClass('show');
            $('a[data-sidebar-level]').removeClass('current');
            $('div[data-sidebar-pane], a[data-sidebar-pane]').removeClass('current');
            $('ul[data-sidebar-level]').removeClass('current');
        });

        // Panes: Esc Keypress
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                if($('div[data-sidebar-pane]').hasClass('current')) {
                    $('html').removeClass('hide-overflow');
                    $('a[data-sidebar-level]').removeClass('current');
                    $('div[data-sidebar-pane].current').removeClass('current');
                    $('a[data-sidebar-pane]').removeClass('current');
                    $('ul[data-sidebar-level]').removeClass('current');
                    $('.sidebar-nav__overlay').removeClass('show');
                }
            }
        });

        // Search Only: Click to Focus (Desktop Only)
        if (matchMedia('only screen and (min-width: 64em)').matches) {
            $('a[data-sidebar-pane="pane-search"]').on('click', function(e) {
                $('.search-pane .sidebar-nav__search-input').focus();
            });
        }

        // Body Offset (Mobile)
        /*
            These media queries should be set to the same value as
            $menu-media-query in settings.css.
        */
        if (matchMedia('only screen and (max-width: 64em)').matches) {
            var tab_bar_height = $('.sidebar-nav').outerHeight();
            $('html').css('padding-bottom', tab_bar_height);
        }

        $(window).resize(function(e) {
            if (matchMedia('only screen and (max-width: 64em)').matches) {
                var tab_bar_height = $('.sidebar-nav').outerHeight();
                $('html').css('padding-bottom', tab_bar_height);
            } else {
                $('html').css('padding-bottom', 0);
            }
        });

        $('.more-menu-toggle').on('click', function(e) {
            $(this).siblings('.sidebar-nav__more-menu').toggleClass('show');
        });

    });

})(jQuery);
