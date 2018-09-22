/* =============================================================================

    COMPONENT: DIALOG JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        // Open
        $('.dialog__trigger').on('click', function(e) {
            var dialog_id = $(this).attr('data-dialog');
            $('html').addClass('hide-overflow');
            $('.dialog__overlay').addClass('open');
            $('.dialog[data-dialog="' + dialog_id + '"]').addClass('open');
        });

        // Close
        $('.dialog__close').on('click', function(e) {
            $('html').removeClass('hide-overflow');
            $('.dialog__overlay').removeClass('open');
            $('.dialog').removeClass('open');
        });

        // Esc
        $(document).keyup(function(e) {
            if (e.keyCode == 27) {
                $('html').removeClass('hide-overflow');
                $('.dialog__overlay').removeClass('open');
                $('.dialog').removeClass('open');
            }
        });

    });

})(jQuery);
