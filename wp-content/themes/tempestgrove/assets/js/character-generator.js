
  jQuery(document).on('ready', function(){
    jQuery('.switcher').on('click', function(){
      if(!jQuery(this).hasClass('active')){
        jQuery('.switcher-content').toggle();
        jQuery('.switcher').toggleClass('active');
      }
    });

    jQuery('#character-generator').on('click', function(e){
      e.preventDefault();
      if(jQuery('#cg-race').val() != 'lock'){
        var race = builder_data.races[Math.floor(Math.random()*builder_data.races.length)];
      }
      if(jQuery('#cg-pc_class').val() != 'lock'){
        var pc_class = builder_data.pc_classes[Math.floor(Math.random()*builder_data.pc_classes.length)];
      }
      if(jQuery('#cg-arrival').val() != 'lock'){
        var arrival = builder_data.arrivals[Math.floor(Math.random()*builder_data.arrivals.length)];
      }
      if(jQuery('#cg-purpose').val() != 'lock'){
        var purpose = builder_data.purposes[Math.floor(Math.random()*builder_data.purposes.length)];
      }
      if(jQuery('#cg-profession').val() != 'lock'){
        var quirk = builder_data.quirks[Math.floor(Math.random()*builder_data.quirks.length)];
      }
      if(jQuery('#cg-quirk').val() != 'lock'){
        var profession = builder_data.professions[Math.floor(Math.random()*builder_data.professions.length)];
      }

      if(race != null){
        jQuery('#race-holder').text(race.name);
      }
      if(pc_class != null){
        jQuery('#pc_class-holder').text(pc_class.name);
      }
      jQuery('#purpose-holder').text(end_sentence(purpose));
      jQuery('#quirk-holder').text(end_sentence(quirk));
      jQuery('#profession-holder').text(end_sentence(profession));
      jQuery('#arrival-holder').text(arrival);

      jQuery('.pc_class').hide();
      jQuery('.race').hide();
      jQuery('.race[data-name="'+race.name+'"]').show();
      jQuery('.pc_class[data-name="'+pc_class.name+'"]').show();
      jQuery('#'+makeSafeForCSS(race.name)).show();
      jQuery('#generator-tabs').show();

    });

    jQuery('#cg-pc_class').on('change', function(){
      if(jQuery(this).val() == "hide"){
        jQuery('#class-tab').hide();
        jQuery('#pc_class-container').hide();
      } else {
        jQuery('#class-tab').show();
        jQuery('#pc_class-container').show();
      }
    });

    jQuery('#cg-race').on('change', function(){
      if(jQuery(this).val() == "hide"){
        jQuery('#race-tab').hide();
        jQuery('#pc_race-container').hide();
      } else {
        jQuery('#race-tab').show();
        jQuery('#pc_race-container').show();
      }
    });

    jQuery('.gen-opt').on('change', function(){
      var holder = jQuery(this).data('eleHolder');
      if(jQuery(this).val() == 'hide') {
          jQuery(jQuery(this).data('eleHolder')).hide();
        } else {
          jQuery(jQuery(this).data('eleHolder')).show();
        }
    });

    // jQuery('#cg-quirk, #cg-arrival, #cg-purpose, #cg-profession').on('changed', function(){
    //
    //   if(jQuery(this).val() == 'hide') {
    //     jQuery(jQuery(this).data('eleHolder')).hide();
    //   } else {
    //     jQuery(jQuery(this).data('eleHolder')).show();
    //   }
    // });

  });

  function end_sentence(string) {
    if (string == null) {
      string = "";
    }
    return string.replace(/\.+$/, "") + '.';
  }

  function makeSafeForCSS(name) {
      return name.replace(/[!\"#$%&'\(\)\*\+,\.\/:;<=>\?\@\[\\\]\^`\{\|\}~]/g, '');
  }
