/* =============================================================================

    COMPONENT: FORMS JS

    Authored by:
        - Josh Beveridge
        - Justin Bellefontaine

============================================================================= */

(function($) {

    $(document).ready(function() {

        // File Inputs
        function inputChange() {
            if($(this)[0].files.length === 1) {
                $(this).siblings('.file-input__label').text($(this).val().split('\\').pop());
            } else {
                $(this).siblings('.file-input__label').text($(this)[0].files.length + ' files selected');
            }
        }

        $('input[type="file"]').each(function() {
            $(this).parent().append("<label class='file-input__label' for=" + $(this).attr('id') + ">Select a File</label>");
            $(this).change(inputChange);
        });

    });

})(jQuery);
