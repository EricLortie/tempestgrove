jQuery(document).on('ready', function(){


    jQuery('.spell_expander').on('click', function(){
      jQuery('#spell_info').html(jQuery(this).siblings('.spell_info').html())
      // jQuery('#spell_modal').modal();
    });

    if(window.location.hash != ''){
      ele = decodeURI(window.location.hash.substring(1));
      jQuery('.builder_selector').val(ele).trigger('change');
    }

});
