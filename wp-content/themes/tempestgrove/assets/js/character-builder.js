jQuery(document).on('ready', function(){

  // The button that surfaces the descrition for a skill
  jQuery('.skill_expander').on('click', function(){
    var desc = jQuery(this).closest('.skill_row').find('.skill_desc');
    desc.slideToggle();
  });

  // The button that surfaces the descrition for a skill
  jQuery(document).on('click', '.spell_expander', function(){
    var desc = jQuery(this).closest('.skill_row').find('.skill_desc');
    desc.slideToggle();
  });

    // The button that hides the descrition for a skill
  jQuery('.skill_closer').on('click', function(e){
    e.preventDefault();
    var desc = jQuery(this).closest('.skill_desc');
    desc.slideToggle();
  });

  //The button that adds a skill to the character
  jQuery('.skill_add:not(spell_add)').on('click', function(){
    if(jQuery(this).hasClass('spell_sphere_add')) {
      update_spell_spheres(); // This function will update the value of the next sphere purchased
    }
    var skill_row = jQuery(this).closest('.skill_row');

    add_skill_to_character(skill_row);

    if(jQuery(this).data('name') == 'Favoured'){
      jQuery('#details_section').hide();
      jQuery('#occupation_selector').show();
    }
    if(skill_row.data('name') == 'Vocation'){
      jQuery('#details_section').hide();
      jQuery('#vocation_selector').show();
    }
  });

  jQuery('#btn_reset').on('click', function(){
    jQuery('.mandatory_section').hide();
    jQuery('#character_section').hide();
    jQuery('#data_fields').hide();
    jQuery('.non_data_fields:not(#character_section)').show();
    jQuery('#btn_generate').show();
    jQuery('#btn_generate').addClass('locked');
    jQuery('#cb_selectors').show();
    jQuery('#cb_race_show').html('');
    jQuery('#cb_class_show').html('');
    jQuery('#details_section').hide();
    jQuery('#menu_primary').show();
    jQuery('#menu_launcher').show();
    jQuery('#category-dropdown').val('');
    jQuery('#character-load-dropdown').val('');
    jQuery('#btn_choose_race').removeClass('selected');
    jQuery('#btn_choose_class').removeClass('selected');
    reset_character();
    reset_skills();
    jQuery('#opt-clear').trigger('click');
  });

  function set_race(race, frag_cost){
    builder_data.character.frags_spent = 0;
    builder_data.character.race = race;
    if(race == "High Elves (Deminis'Thalan)"){
      jQuery('.spell_circle.elf_only').show();
    } else {
      jQuery('.spell_circle.elf_only').hide();
    }
    if(race == 'Minotaur (Fae)') {
        builder_data.character.strength += 1;
    }
    jQuery('#cb_race_show').html(race);;
    if(typeof frag_cost != 'undefined' && frag_cost != ''){
      builder_data.character.frags_spent = parseInt(frag_cost);
      builder_data.character.race_frag_cost = parseInt(frag_cost);
    }

    jQuery('.skill_row').each(function(){
      skill_ele = jQuery(this);
      set_skill_cost_and_visibility(skill_ele);
    });
    if (builder_data.character.race != '' && builder_data.character.pc_class != '') {
      jQuery('#btn_generate').removeClass('locked');
    } else {
      jQuery('#btn_generate').addClass('locked');
    }

  }

    function set_occupation(pc_class, cost_ele){
      var old_cp_count = (builder_data.character.cp_spent + builder_data.character.cp_avail);
      var old_frag_count = builder_data.character.frags_spent;
      var old_blankets_spent = builder_data.character.blankets_spent;
      var old_level = builder_data.character.level;
      var old_class = builder_data.character.pc_class;
      if(cost_ele == "dra_cost" || cost_ele == "lig_cost" || cost_ele == "dar_cost"){
        cost_ele = "dem_cost";
      } else {
        cost_ele = "cha_cost";
      }
      reset_character();
      set_class(pc_class, 50, cost_ele)
      builder_data.character.occupation = true;
      builder_data.character.class_frag_cost = 50;
      builder_data.character.old_class = old_class;
      builder_data.character.pc_class = pc_class;
      builder_data.character.cp_avail = old_cp_count;
      builder_data.character.frags_spent = old_frag_count;
      builder_data.character.blankets_spent = old_blankets_spent;
      builder_data.character.level = old_level;

      jQuery('.skill_row.'+pc_class.replace(' ','')).each(function(){
        jQuery(this).data('class_restricted', false);
      });

      update_character();
      add_automatic_skills();

      jQuery('#occupation_selector').hide();
      jQuery('#details_section').show();
    }
    function set_vocation(pc_class){

      console.log('SETTING VOCATION');
      builder_data.character.vocation = pc_class;

      jQuery('#char_vocation').show();
      jQuery('#cb_vocation_show').html(pc_class);

      jQuery('.skill_row').each(function(){
        if(jQuery(this).data('class_skill')){
          if(jQuery(this).hasClass(pc_class.replace(' ',''))){
            jQuery(this).data('class_restricted', false);
            jQuery(this).removeClass('restricted');
            jQuery(this).show();
          } else {
            jQuery(this).data('class_restricted', true);
            jQuery(this).addClass('restricted');
            jQuery(this).hide();
          }
        }
      });


      jQuery('#vocation_selector').hide();
      jQuery('#details_section').show();
    }

  function set_class(pc_class, frag_cost, cost_ele){
    console.log('SETTING CLASS');
    builder_data.character.pc_class = pc_class;
    builder_data.character.cost_element = cost_ele;
    builder_data.character.class_frag_cost = frag_cost;

    if(pc_class == "Mercenary" || pc_class == "Ranger" || pc_class == "Templar"){
      builder_data.type = "w";
      builder_data.type_string = "Warrior";
    } else if (pc_class == "Assassin" || pc_class == "Nightblade" || pc_class == "Witch Hunter") {
      builder_data.type = "r";
      builder_data.type_string = "Rogue";
    } else {
      builder_data.type = "s";
      builder_data.type_string = "Scholar";
    }

    jQuery('#cb_class_show').html(pc_class);
    jQuery('.skill_cost').hide();

    jQuery('.skill_row').each(function(){
      skill_ele = jQuery(this);
      set_skill_cost_and_visibility(skill_ele);
    });


    if (builder_data.character.race != '' && builder_data.character.pc_class != '') {
      jQuery('#btn_generate').removeClass('locked');
    } else {
      jQuery('#btn_generate').addClass('locked');
    }

  }

  function set_skill_cost_and_visibility(skill_ele) {
    if(skill_ele.data('class_skill') == true){
      skill_ele.find('.level_cost').show();
      if(skill_ele.data('class') == builder_data.character.pc_class || skill_ele.data('class') == builder_data.character.vocation || skill_ele.data('class') == builder_data.character.occupation ){
        skill_ele.data('class_restricted', false);
      } else {
        skill_ele.data('class_restricted', true);
      }
      skill_ele.data('cost', parseInt(skill_ele.find('.level_cost').html()));

    } else if (skill_ele.data('spell_sphere')) {
      skill_ele.data('cost', builder_data.character.sphere_cost);
    } else if(skill_ele.data('racial_skill') == true){
      skill_ele.find('.racial_cost').show();

      if(skill_ele.data('race') != builder_data.character.race){
        skill_ele.data('race_restricted', true);
      } else {
        skill_ele.data('race_restricted', false);
      }
      skill_ele.data('cost', parseInt(skill_ele.find('.cost').html()));

    } else {
      if (skill_ele.data('frag_cost') > 0) {
        if (skill_ele.data('class') != "All" && skill_ele.data('cat_string') != builder_data.type_string){
          //skill_ele.data('class_restricted', true);
          skill_ele.addClass('cat_restricted');
        } else {
          //skill_ele.data('class_restricted', false);
          skill_ele.removeClass('cat_restricted');
        }
      }

      skill_ele.find('.' + builder_data.character.cost_element).show();
      skill_ele.data('cost', parseInt(skill_ele.find('.' + builder_data.character.cost_element).html()));
    }
    skill_ele.find('span.cost').html(skill_ele.data('cost'));
  }

  jQuery('#btn_generate').on('click', function(e){
    e.preventDefault();
    if (builder_data.character.pc_class != '' && builder_data.character.race != '') {
      reset_character();
      jQuery('.mandatory_section').show();
      jQuery(this).hide();
      jQuery('#cb_selectors').hide();
      jQuery('#menu_launcher').hide();
      jQuery('#details_section').show();
      add_automatic_skills();
    }
  });

  jQuery('.state_saver').on('click', function(e){
    e.preventDefault();
    set_state();
  });

  jQuery('#btn_add_blanket').on('click', function(e){
    e.preventDefault();
    builder_data.character.blankets_spent += 1;
    builder_data.character.cp_avail += builder_data.character.blanket_value;
    builder_data.character.cp_total = (builder_data.character.cp_avail + builder_data.character.cp_spent);
    if(builder_data.character.cp_total >= (builder_data.character.level_data['cp']+100)){
      builder_data.character.level += 1;
      builder_data.character.level_data = builder_data.level_chart[builder_data.character.level-1];
      builder_data.character.blanket_value = builder_data.character.level_data.cppb;
      builder_data.character.body_points = builder_data.character.level_data['bp_' + builder_data.type] + builder_data.character.body_point_bonus;
    }
    jQuery('#blanket_val').html(builder_data.character.blanket_value);
    update_character();
  });

  jQuery('#btn_sort_cost').on('click', function(){
    toggleSort('cost');
  });

  jQuery('#btn_sort_name').on('click', function(){
    toggleSort('name');
  });

  function toggleSort(type) {
    jQuery('.btn-sort').toggleClass('active');
    if(type == "name"){
      jQuery('#sort_string').html('NAME');
      tinysort('.skill_row', 'span.name');
    } else {
      jQuery('#sort_string').html('COST');
      tinysort('.skill_row', 'span.cost');
    }
  }

  jQuery('#btn_toggle_skills').on('click', function(){
    if(jQuery('#skill_list').hasClass('avail_only')){
      jQuery('#filter_string').html("AVAILABLE");
    } else {
        jQuery('#filter_string').html("ALL");
    }
    jQuery(this).toggleClass('active');
    jQuery('#skill_list').toggleClass('avail_only');
  });

  jQuery('.btn-cat').on('click', function(){
    var cat = jQuery(this).data('cat');
    var cat_string = jQuery(this).data('catString');
    builder_data.toggle = cat_string;
    jQuery('.skill_row').css('display', '');
    jQuery('#skill_list').removeClass('S');
    jQuery('#skill_list').removeClass('W');
    jQuery('#skill_list').removeClass('R');
    jQuery('#skill_list').removeClass('P');
    jQuery('#skill_list').removeClass('A');
    jQuery('#skill_list').removeClass('C');
    jQuery('.btn-cat').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('#skill_list').addClass(cat);
    jQuery('#cat_string').html(cat_string);

  });

  jQuery('#btn_frag').on('click', function(){
    jQuery('.skill_row').hide();
    jQuery('.frag_row').show();
  });

  jQuery('#opt-clear').on('click', function(){
    builder_data.toggle = "";
    jQuery('.frag_row').hide();
    jQuery('.skill_row').show();
    jQuery('#filter_string').html("ALL");
    jQuery('#skill_list').removeClass('avail_only');
    jQuery('#skill_list').removeClass('S');
    jQuery('#skill_list').removeClass('W');
    jQuery('#skill_list').removeClass('R');
    jQuery('#skill_list').removeClass('P');
    jQuery('#skill_list').removeClass('A');
    jQuery('#skill_list').removeClass('C');
    jQuery('.btn-cat').removeClass('active');
    jQuery('#cat_string').html("");
    jQuery('#sort_string').html('NAME');
    tinysort('.skill_row', 'span.name');
  });


  function add_skill_to_character(skill_ele){
    var name = skill_ele.data('name');
    if(skill_ele.data('multiple') == false || skill_ele.data('multiple') == "" || skill_ele.data('multiple') == 0 || skill_ele.data('multiple') == "0"){
      skill_ele.find('.skill_add').hide();
      skill_ele.find('.skill_purchased').slideToggle();
      skill_ele.addClass('purchased');
    }
    if(skill_ele.data('sphere')){
      builder_data.character.spell_spheres += 1;
    }
    if(builder_data.character.skills.hasOwnProperty(name)) {
      builder_data.character.skills[name] += 1;
    } else {
      builder_data.character.skills[name] = 1;
    }
    if(skill_ele.data('spell_circle')){

      builder_data.character.circle_values[name] += 1;
      var circle = builder_data.circles.indexOf(name)+1;
      slot = parseInt(builder_data.character.circle_values[name]);
      jQuery('.spell_circle[circle="'+circle+'"]').removeClass('disabled');
      jQuery('.spell_circle[circle="'+circle+'"]').find('.spell_slot[slot="'+slot+'"]').removeClass('disabled');

    }
    if(skill_ele.data('class_skill')){
      if(builder_data.character.class_skills.hasOwnProperty(name)) {
        builder_data.character.class_skills[skill_ele.data('level')] += 1;
      } else {
        builder_data.character.class_skills[skill_ele.data('level')] = 1;
      }
    }
    if(skill_ele.data('racial_skill')){
      builder_data.character.racial_skills += 1;
      if(!skill_ele.data('automatic')){
        builder_data.character.next_racial_skill_level = builder_data.character.level+2;
      }
    }
    if(name == "Heavy Armour"){
      builder_data.heavy_armour = true;
      jQuery('.armour_slot_data_2').removeClass('locked');
      jQuery('#heavy_armour_flag').html("Yes")
    }
    if(name == "Strength Bonus") {
      builder_data.character.strength += 1;
    }
    if(name == "Body Point Bonus") {
      builder_data.character.body_point_bonus += 5;
    }
    if(name == "Orcish Constitution") {
      builder_data.character.strength += 1;
      builder_data.character.body_point_bonus += 5;
    }

    builder_data.character.cp_avail -= skill_ele.data('cost');
    builder_data.character.cp_spent += skill_ele.data('cost');
    if(typeof skill_ele.data('frag_cost') != 'undefined' && skill_ele.data('frag_cost') != ""){
      builder_data.character.frags_spent += parseInt(skill_ele.data('frag_cost'));
    }
    builder_data.character.skill_count += 1
    if(builder_data.character.last_class_skill_level < skill_ele.data('class_level')){
      builder_data.character.last_class_skill_level = skill_ele.data('class_level');
    }
    jQuery('#cb_skill_count').html(builder_data.character.skill_count);
    update_character();
    if((!skill_ele.find('.skill_add').hasClass('automatic_skill') && name != "Weapon Group Proficiency: Simple")){
      builder_data.step += 1;
      save_character_step(builder_data.character, builder_data.step, name);
      set_state(name);
    }
  }

  function get_spell_circle(name){
    circle = 0;
    if(name.indexOf("1st")!==0) {
      circle = 1;
    } else if(name.indexOf("2nd")!==0){
      circle = 2;
    } else if(name.indexOf("3rd")!==0){
      circle = 3;
    } else if(name.indexOf("4th")!==0){
      circle = 4;
    } else if(name.indexOf("5th")!==0){
      circle = 5;
    } else if(name.indexOf("6th")!==0){
      circle = 6;
    } else if(name.indexOf("7th")!==0){
      circle = 7;
    } else if(name.indexOf("8th")!==0){
      circle = 8;
    } else if(name.indexOf("9th")!==0){
      circle = 9;
    }
    return circle;
  }

  function reset_character() {

    builder_data.character.user_id = 0;
    builder_data.character.vocation = "";
    builder_data.character.occupation = "";
    jQuery('#char_occupation').hide();
    jQuery('#cb_occupation_show').html("");
    jQuery('#char_vocation').hide();
    jQuery('#cb_vocation_show').html("");
    jQuery('#cb_character_details').find('span').html('');

    builder_data.heavy_armour = false;
    builder_data.armour_points = 0;
    builder_data.armour_pieces = 0;
    builder_data.armour = {};
    jQuery('.armour_slot_data_2').addClass('locked');
    jQuery('#heavy_armour_flag').html("No");
    jQuery('.armour_slot').attr('val1', 0);
    jQuery('.armour_slot').attr('val2', 0);

    builder_data.character.character_id = generateUUID();
    builder_data.character.level = 1;
    builder_data.character.blankets_spent = 0;
    builder_data.character.racial_skills = 0;
    builder_data.character.automatic_racial_skills = 0;
    builder_data.character.cp_avail = 150;
    if(builder_data.character.race == "Human"){
      builder_data.character.cp_avail = 200;
      builder_data.character.level_data = builder_data.human_level_chart[0];
    } else {
      builder_data.character.level_data = builder_data.level_chart[0];
    }
    builder_data.character.last_class_skill_level = 0;
    builder_data.character.spell_spheres = 0;
    builder_data.character.cp_spent = 0;
    builder_data.character.cp_total = 0;
    builder_data.character.blanket_value = builder_data.character.level_data.cppb;
    builder_data.character.strength = 0;
    builder_data.character.body_point_bonus = 0;
    builder_data.character.body_points = builder_data.character.level_data['bp_' + builder_data.type];
    builder_data.character.skills = {};
    builder_data.character.skill_count = 0;
    builder_data.character_states = [];


    update_character();

    tinysort('.skill_row', 'span.name');

  }

  function add_automatic_skills(){

    jQuery('span:contains("Weapon Group Proficiency: Simple")').closest('.skill_row').find('.skill_add').trigger('click');

    jQuery('.automatic_skill').each(function(){
      var $btn_add = jQuery(this);
      if(jQuery(this).closest('.skill_row').data('race') == builder_data.character.race){
        builder_data.character.automatic_racial_skills += 1;
        $btn_add.trigger('click');
      }
    });

    builder_data.character.skill_count = 0;
  }

  function update_character(){
    jQuery('#cb_race_show').html(builder_data.character.race);
    jQuery('#cb_class_show').html(builder_data.character.pc_class);
    jQuery('#cb_blankets_spent').html(builder_data.character.blankets_spent);
    jQuery('#cb_blanket_next').html(builder_data.character.blanket_value);
    jQuery('#cb_cp_avail').html(builder_data.character.cp_avail);
    jQuery('#cb_level').html(builder_data.character.level);
    jQuery('#cb_cp_spent').html(builder_data.character.cp_spent);
    jQuery('#cb_frags_spent').html(builder_data.character.frags_spent);
    jQuery('#cb_bp').html(builder_data.character.body_points+builder_data.character.body_point_bonus);
    jQuery('#cb_strength').html(builder_data.character.strength);
    jQuery('#cb_skills').html(output_skills(builder_data.character.skills));
    jQuery('#cb_skill_count').html(builder_data.character.skill_count);

    builder_data.character.sphere_cost = builder_data.sphere_chart[builder_data.character.spell_spheres][builder_data.character.cost_element];
    jQuery('.sphere_cost').show();
    jQuery('.sphere_cost').closest('.skill_row').data('cost', builder_data.character.sphere_cost);
    jQuery('.sphere_cost').closest('.skill_row').find('span.cost').html(builder_data.character.sphere_cost);
    jQuery('.sphere_cost').html(builder_data.character.sphere_cost);

    update_skills();

  }

  function set_state(name='Character Creation'){
    state_counter += 1;
    if(name != 'Character Creation'){
      jQuery('#btn_undo').removeClass('locked');
    }
    builder_data.character_states.unshift({'element': name, 'count': state_counter, 'character': jQuery.extend(true, {}, builder_data.character)});
    if(builder_data.character_states.length > 5){
      builder_data.character_states.splice(4, 1);
    }
  }

  jQuery('#btn_undo').on('click', function(e){
    e.preventDefault();
    if(!jQuery(this).hasClass('locked')){
      undo();
    }
  });

  function undo() {
    builder_data.character = jQuery.extend(true, {}, builder_data.character_states[0]['character']);
    builder_data.character_states.splice(0, 1);
    if(builder_data.character_states.length == 0){
      jQuery('#btn_undo').addClass('locked');
    }
    update_character();

  }

  function output_skills(skills) {
    html = "<ul>";
    for (skill in skills) {
      if (skills.hasOwnProperty(skill)) {
        if(skills[skill] != 0){
          var skill_string = skill;
          if(skills[skill] > 1) {
            skill_string = skill_string + " X" + skills[skill];
          }
          var remort_string = "";
          if(can_be_remorted(skill)){
            remort_string = " <a href='#' class='remort' data-skill-name='"+skill+"'>X (250 <i class='fa fa-diamond' aria-hidden='true'></i>)</a>";
          }
          html += "<li>"+skill_string + remort_string + "</li>";
        }
      }
    }
    html += "</ul>";
    return html;
  }

  function can_be_remorted(skill){
    var skill_ele = jQuery('.skill_row[skill-name="'+skill+'"]');
    if(skill_ele.data('racial_skill') || skill_ele.data('automatic') || skill == "Weapon Group Proficiency: Simple"){
      return false;
    }
    return true;
  }

  jQuery(document).on('click', '.remort', function(e){
    e.preventDefault();
    builder_data.character.frags_spent += 250;
    builder_data.character.skills[jQuery(this).data('skillName')] -= 1;
    update_character();

  });

  function update_skills() {
    jQuery('.skill_row:not(.spell_row)').each(function(){
      var name = jQuery(this).data('name');
      var cost = parseInt(jQuery(this).data('cost'));
      if (isNaN(cost)){
        cost = 0;
      }
      var has_req = ((jQuery(this).data('requirements') != "" ));
      var spell_circle = is_spell_circle(name);

      if(jQuery(this).data('class_skill')){
        if(jQuery(this).data('class_restricted')){
          jQuery(this).addClass('restricted');
          jQuery(this).hide();
        } else if(builder_data.toggle == "Class" || builder_data.toggle == "") {
          jQuery(this).show();
        } else {
          jQuery(this).removeClass('restricted');
          jQuery(this).show();
        }
      }

      if(jQuery(this).data('racial_skill')){
        if(jQuery(this).data('race_restricted')){
          jQuery(this).addClass('restricted');
          jQuery(this).hide();
        } else if(builder_data.toggle == "Race" || builder_data.toggle == "") {
          jQuery(this).show();
        }
      }
      if (cost > builder_data.character.cp_avail
          || ((jQuery(this).data('multiple') == false || jQuery(this).data('multiple') == 0) && character_has_skill(name))
          || (!spell_circle && has_req && !meets_req(jQuery(this)))
          || (spell_circle && !has_circle_req(name))
          || (jQuery(this).data('class_skill') && !meets_class_req(jQuery(this)))
          || (jQuery(this).data('racial_skill') && !meets_racial_req(jQuery(this)))
          || (jQuery(this).data('multiple') == "1" && limit_exceeded(jQuery(this)))) {
            jQuery(this).find('.skill_add').hide();
            jQuery(this).addClass('locked');
      } else {
        jQuery(this).find('.skill_add').show();
        jQuery(this).find('.skill_purchased').hide();
        jQuery(this).removeClass('locked');
        jQuery(this).removeClass('purchased');
      }
    });

  }

  function limit_exceeded(skill_row){
    //console.log(skill_row.data('max'));
    if(skill_row.data('max') == "" || typeof skill_row.data('max') == 'undefined'){
      return false;
    }
    if(typeof builder_data.character.skills[skill_row.data('name')] !== 'undefined' && builder_data.character.skills[skill_row.data('name')] >= skill_row.data('max')) {
      return true;
    }
    return false;
  }

  function meets_class_req(skill_row){
    level = parseInt(skill_row.data('class_level'));
    if(builder_data.character.level >= level &&
      (level == 3 || builder_data.character.last_class_skill_level >= (level-3)) &&
      skill_row.data('class') == builder_data.character.pc_class){
      return true;
    }
    return false;
  }

  function meets_racial_req(skill_row){
    if((builder_data.character.next_racial_skill_level <= builder_data.character.level)){
      return true;
    }
    return false;
  }

  function character_has_skill(skill){
    if(builder_data.character.skills[skill] > 0){
      return true;
    }
    return false;
  }

  function is_spell_circle(skill){
    circle_search = builder_data.character.circle_values[skill];
    if(typeof circle_search != 'undefined'){
      return true;
    }
    return false;
  }

  function has_circle_req(skill) {
    cur_circle = builder_data.circles.indexOf(skill);
    var cur_circle_count = builder_data.character.circle_values[skill];
    skills = builder_data.character.skills;
    if(typeof cur_circle_count == 'undefined'){
      cur_circle_count = 0;
    }
    if (cur_circle_count >= 5) {
      return false;
    } else if (skill == "Spell Slot: Ritual Base" && skills["Read Magic: Ritual"] == 1 && skills["Spell Slot: 9th Circle"] >= 1) {
      return true;
    } else if(skill == "Spell Slot: 1st Circle" && (builder_data.character.spell_spheres >= 1) && (cur_circle_count < 2 || circle_math_req(cur_circle, cur_circle_count))){
      return true;
    } else if (skill != "Spell Slot: 5th Circle" && skill != "Spell Slot: Ritual Base" && circle_math_req(cur_circle, cur_circle_count)) {
      return true;
    } else if (skill == "Spell Slot: 5th Circle" && skill != "Spell Slot: Ritual Base" && skills["Read Magic: Advanced"] == 1 && circle_math_req(cur_circle, cur_circle_count)){
      return true;
    }
    return false;
  }

  function circle_math_req(cur_circle, cur_circle_count){
    prev_circle_count = builder_data.character.circle_values[builder_data.circles[cur_circle-1]];
    next_circle_count = builder_data.character.circle_values[builder_data.circles[cur_circle+1]];
    if(cur_circle == 0){
      return ((cur_circle_count > next_circle_count) && (cur_circle_count < next_circle_count+2));
    } else {
      return ((next_circle_count <= cur_circle_count+1) && (prev_circle_count >= cur_circle_count+2 || prev_circle_count == 5));
    }
    return false;
  }

  function meets_req(skill_row){
    var req = skill_row.data('requirements')
    reqs = [];

    if(typeof req !== 'undefined' && req != ""){
      items = req.split(', ');
      for (req in items) {
        var original_req = items[req];
        items[req] = set_req_alias(items[req], skill_row.data('name'));

        if (items.hasOwnProperty(req)) {
          var conditionals = items[req].split(" OR ");
          for (subreq in conditionals) {
            if (conditionals.hasOwnProperty(subreq)) {
              reqs.push(conditionals[subreq]);
            } else {
              if(req.indexOf("Max") !== -1){
                reqs.push(subreq);
              }
            }
          }
        } else {
          if(req.indexOf("Max") !== -1){
            reqs.push(req);
          }
        }
      }

      char_skills = builder_data.character.skills;
      var returns = [];
      for (i = 0; i < reqs.length; i++) {
        if(reqs[i] == "Spell Sphere: Elemental" && char_skills["Elemental Attunement"] >=4){
          return false;
        }
        if(reqs[i] == builder_data.type_string ){
          skill_row.find('.skill_req').hide();
          returns.push(true);
        }
        if(char_skills.hasOwnProperty(reqs[i])){
          skill_row.find('.skill_req').hide();
          returns.push(true);
        }
        if(reqs[i] == "Sphere of Magic: 1st" && builder_data.character.spell_spheres > 0){
          skill_row.find('.skill_req').hide();
          returns.push(true);
        }
      }
      var unique = returns.filter(function(item, i, ar){ return ar.indexOf(item) === i; });
      //if(returns.length != reqs.length){
        //return false;
      //}
      if(unique.length >= 1 && unique[0] == true) {
        return true;
      }
    } else {
      return false;
    }
    return false;
  }

  function set_req_alias(req, skill) {
    switch(req) {
      case "Elemental Sphere":
        return "Spell Sphere: Elemental";
        break;
      case "Weapon Group Proficiency":
      case "Group Proficiency":
        switch(skill) {
          case "Critical +2: Specific Simple Weapon":
          case "Critical +2: Simple Group":
          case "Specialization +1: Simple Group":
          case "Specialization +1: Simple Weapon":
            return "Weapon Group Proficiency: Simple";
            break;
          case "Critical +2: Specific Medium Weapon":
          case "Critical +2: Medium Group":
          case "Specialization +1: Medium Group":
          case "Specialization +1: Medium Weapon":
            return "Weapon Group Proficiency: Medium";
            break;
          case "Critical +2: Specific Large Weapon":
          case "Critical +2: Large Group":
          case "Specialization +1: Large Group":
          case "Specialization +1: Large Weapon":
            return "Weapon Group Proficiency: Large";
            break;
          case "Critical +2: Specific Exotic Weapon":
          case "Critical +2: Exotic Group":
          case "Specialization +1: Exotic Group":
          case "Specialization +1: Exotic Weapon":
            return "Weapon Group Proficiency: Exotic";
            break;
          }
        case "Specialization +1: Weapon Group":
          switch(skill) {
            case "Slay / Parry (Master): All Simple Weapons":
              return "Specialization +1: Simple Group"
            case "Slay / Parry (Master): All Medium Weapons":
              return "Specialization +1: Medium Group"
            case "Slay / Parry (Master): All Large Weapons":
              return "Specialization +1: Large Group"
            case "Slay / Parry (Master): All Exotic Weapons":
              return "Specialization +1: Exotic Group"
          }
        case "Specialization +1: Weapon Specific":
          switch(skill) {
            case "Slay / Parry: Specific Simple Weapon":
              return "Specialization +1: Simple Group"
            case "Slay / Parry: Specific Medium Weapon":
              return "Specialization +1: Medium Group"
            case "Slay / Parry: Specific Large Weapon":
              return "Specialization +1: Large Group"
            case "Slay / Parry: Specific Exotic Weapon":
              return "Specialization +1: Exotic Group"
          }
      case "Critical +2: Specific":
        switch(skill) {
          case "Execute: Specific Simple Weapon":
            return "Critical +2: Specific Simple Weapon";
            break;
          case "Execute: Specific Medium Weapon":
            return "Critical +2: Specific Medium Weapon";
            break;
          case "Execute: Specific Large Weapon":
            return "Critical +2: Specific Large Weapon";
            break;
          case "Execute: Specific Exotic Weapon":
            return "Critical +2: Specific Exotic Weapon";
            break;
        }
      case "Critical +2: Group":
        switch(skill) {
          case "Execute: Simple Weapon Group":
            return "Critical +2: Simple Group";
            break;
          case "Execute: Medium Weapon Group":
            return "Critical +2: Medium Group";
            break;
          case "Execute: Large Weapon Group":
            return "Critical +2: Large Group";
            break;
          case "Execute: Exotic Weapon Group":
            return "Critical +2: Exotic Group";
            break;
        }
      case "Execute":
        switch(skill) {
          case "Execute: Specific Simple Weapon (Subsequent)":
            return "Execute: Specific Simple Weapon";
            break;
          case "Execute: Specific Medium Weapon (Subsequent)":
            return "Execute: Specific Medium Weapon";
            break;
          case "Execute: Specific Large Weapon (Subsequent)":
            return "Execute: Specific Large Weapon";
            break;
          case "Execute: Specific Exotic Weapon (Subsequent)":
            return "Execute: Specific Exotic Weapon";
            break;
        }

    }
    return req;
  }

  function reset_skills(){

    builder_data.character.skill_count = 0;
    jQuery('#cb_skill_count').html(0);
    jQuery('.skill_row').removeClass('locked');
    jQuery('.skill_row').removeClass('purchased');
    jQuery('.skill_req').show();
    jQuery('.skill_add').show();
    jQuery('.skill_purchased').hide();
  }

  function update_spell_spheres(){
    builder_data.character.spell_spheres++;
    if(builder_data.character.spell_spheres == 3) {
      jQuery('.spell_sphere').addClass('purchased');
    }
  }

  function generateUUID () { // Public Domain/MIT
    var d = new Date().getTime();
    if (typeof performance !== 'undefined' && typeof performance.now === 'function'){
        d += performance.now(); //use high-precision timer if available
    }
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
  }

  jQuery('.btn-cb-content ').on('click', function(){
    jQuery('.btn-cb-content').removeClass('active');
    jQuery('.cb_display_content').removeClass('active');
    jQuery(this).addClass('active');
    jQuery('.cb_display_content[data-tab="'+jQuery(this).data('tab')+'"]').addClass('active');
  });

  jQuery(document).on('click', '.expand_armour', function(){
    jQuery(this).toggleClass('hidden')
    jQuery(this).siblings('.close_armour').toggleClass('hidden');
    var slot = jQuery(this).attr('armour');
    jQuery('#armour_'+slot).find('.armour_slot_data').show();
  });
  jQuery(document).on('click', '.close_armour', function(){
    jQuery(this).toggleClass('hidden')
    jQuery(this).siblings('.expand_armour').toggleClass('hidden');
    var slot = jQuery(this).attr('armour');
    jQuery('#armour_'+slot).find('.armour_slot_data').hide();
  });

  jQuery('.legend_toggler').on('click', function(e){
    e.preventDefault();
    jQuery('#legend').toggleClass('opened').toggleClass('closed');
  });

  jQuery('#btn_data_export, #btn_data_import').on('click', function(e){
    e.preventDefault();
    jQuery('.non_data_fields').hide();
    jQuery('#cb_selectors').hide();
    jQuery('#details_section').hide();
    jQuery('#menu_primary').hide();
    jQuery('#menu_launcher').show();
    jQuery('#data_fields').show();
  });
  jQuery('#btn_data_export').on('click', function(e){
    e.preventDefault();
    jQuery('#data_fields_export').show();
    jQuery('#data_fields_import').hide();
  });
  jQuery('#btn_data_import').on('click', function(e){
    e.preventDefault();
    jQuery('#data_fields_export').hide();
    jQuery('#data_fields_import').show();
  });

  jQuery('#btn_close_data').on('click', function(e){
    e.preventDefault();
    if(builder_data.character['skill_count'] == 0){
      jQuery('#btn_reset').trigger('click');
    } else {
      jQuery('.non_data_fields').show();
      jQuery('#data_fields').hide();
      jQuery('#char_export_code').val("");
      jQuery('#data_import').val("");
      jQuery('.mandatory_section').show();
      jQuery('#btn_generate').hide();
      jQuery('#cb_selectors').hide();
      jQuery('#details_section').show();
      jQuery('#menu_primary').show();
      jQuery('#menu_launcher').hide();
    }
  });

  jQuery('#generate_export').on('click', function(e){
    e.preventDefault();
    jQuery('#char_export_code').val(JSON.stringify(builder_data.character));
  });

  jQuery('#save_character').on('click', function(){
    var cn_dd = jQuery('#character-save-dropdown');
    if(cn_dd.val() != '' || cn_dd.val() != 'char_new' || jQuery('#char_name').val() != ''){
      let char_id = '';
      let char_name = '';
      if(cn_dd.val() != '' && cn_dd.val() != 'char_new'){
        char_id = cn_dd.val();
        builder_data.character.id = char_id;
      } else {
        char_name = jQuery('#char_name').val();
        builder_data.character.char_name = char_name;
      }

      save_character(builder_data.character)

      jQuery('#load_character_section').show();
      jQuery('#character-load-dropdown').val('');
      if(builder_data.character['skill_count'] == 0){
        jQuery('#btn_reset').trigger('click');
      } else {
        jQuery('.non_data_fields').show();
        jQuery('#data_fields').hide();
        jQuery('#char_export_code').val("");
        jQuery('#data_import').val("");
        jQuery('.mandatory_section').show();
        jQuery('#btn_generate').hide();
        jQuery('#cb_selectors').hide();
        jQuery('#details_section').show();
        jQuery('#menu_primary').show();
        jQuery('#menu_launcher').hide();
      }
    } else {
      alert('You must select a character or add a character name.');
    }
  });

  jQuery('#load_character').on('click', function(){
    let char_id = jQuery('#character-load-dropdown').val();
    load_character(builder_data.saved_characters[char_id]);
  });

  jQuery('#process_import').on('click', function(e){
    e.preventDefault();
    var char_import = jQuery('#data_import').val();
    var parsed_char = JSON.parse(char_import);
    load_character(parsed_char);
  });

  function load_character(character){

    reset_character();
    reset_skills();

    builder_data.character = character;

    jQuery('#character-load-dropdown').val('');
    jQuery('.non_data_fields').show();
    jQuery('#data_fields').hide();
    jQuery('#char_export_code').val("");
    jQuery('#data_import').val("");
    jQuery('.mandatory_section').show();
    jQuery('#btn_generate').hide();
    jQuery('#cb_selectors').hide();

    set_race(builder_data.character.pc_class, builder_data.character.race_frag_cost)

    if(builder_data.character.occupation){
      set_occupation(builder_data.character.pc_class, builder_data.character.cost_element);
    } else if (builder_data.character.vocation != '') {
      set_vocation(builder_data.character.vocation);
    } else {
      set_class(builder_data.character.pc_class, builder_data.character.class_frag_cost, builder_data.character.cost_element);
    }
    jQuery('#details_section').show();
    jQuery('#menu_primary').show();
    jQuery('#menu_launcher').hide();

    update_character();
    set_spellbook();

    jQuery('#opt-clear').trigger('click');
  }

  function set_spellbook(){

    for (var day in builder_data.character.spells) {
       if (builder_data.character.spells.hasOwnProperty(day)) {

         var spellbook_day = builder_data.character.spells[day];
         for (var circle in spellbook_day) {
            if (spellbook_day.hasOwnProperty(circle)) {
              jQuery(`.spell_slot[circle="${circle}"]`).removeClass('disabled');
              jQuery(`.spell_circle[circle="${circle}"]`).removeClass('disabled');

              var spellbook_circle = spellbook_day[circle];
              for (var slot in spellbook_circle) {
                 if (spellbook_circle.hasOwnProperty(slot)) {

                   jQuery(`.spell_name[circle="${circle}"][slot="${slot}"][day="${day}"]`).html(spellbook_circle[slot]);

                 }
               }
            }
          }
       }
     }
  }

  // Cache selectors outside callback for performance.
  if(jQuery('#character_data').length > 0){
    var $window = jQuery(window),
        $stickyEl = jQuery('#character_data'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
      if(!jQuery('header#header').hasClass('mobile')){
        //console.log("Testing: " + $window.scrollTop() + " & " + elTop);
         $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop-200);
       }
    });

    $stickyEl.css({'max-width': $stickyEl.width()});
    $stickyEl.css({'width': $stickyEl.width()});
  }

  if(typeof saved_char !== 'undefined'){
    jQuery('#load_character_section').show();
  }



  jQuery('#btn_choose_race').on('click', function(){
    jQuery('#menu_items').hide();
    jQuery('#menu_launcher').css('background', 'none');
    jQuery('#menu_launcher').css('padding-top', '0');
    jQuery('#race_selector').fadeIn();
    scrollTo(jQuery('#menu_launcher'));

  });
  jQuery('#btn_choose_class').on('click', function(){
    jQuery('#menu_items').hide();
    jQuery('#menu_launcher').css('background', 'none');
    jQuery('#menu_launcher').css('padding-top', '0');
    jQuery('#class_selector').fadeIn();
    scrollTo(jQuery('#menu_launcher'));
  });

  function scrollTo(ele) {

    jQuery('html, body').animate({
        scrollTop: (ele.offset().top -100)
    }, 300);

  }

  jQuery('.builder_selector').on('change', function(){
    jQuery('.content').hide();
    jQuery('.content[data-name="'+jQuery(this).val()+'"]').fadeIn();
  });

  jQuery('#category-dropdown').on('change', function(){
    builder_data.character.category = jQuery(this).val();
  });


  jQuery(document).on('click', '#select_race', function(){
    jQuery('#btn_choose_race').addClass('selected');
    jQuery('#menu_items').fadeIn();
    jQuery('#menu_launcher').css('background', '');
    jQuery('#menu_launcher').css('padding-top', '');
    jQuery('#race_selector').hide();
    set_race(jQuery(this).data('race'), jQuery(this).data('frag_cost'));
  });
  jQuery(document).on('click', '#select_class', function(){
    jQuery('#btn_choose_class').addClass('selected');
    jQuery('#menu_items').fadeIn();
    jQuery('#menu_launcher').css('background', '');
    jQuery('#menu_launcher').css('padding-top', '');
    jQuery('#class_selector').hide();
    set_class(jQuery(this).data('class'), jQuery(this).data('frag_cost'), jQuery(this).data('cost-ele'));
  });
  jQuery(document).on('click', '#select_occupation', function(){
    set_occupation(jQuery(this).data('class'), jQuery(this).data('cost-ele'));
  });
  jQuery(document).on('click', '#select_vocation', function(){
    set_vocation(jQuery(this).data('class'));
  });

  if(jQuery('.tooltip').length > 0){
    jQuery( document ).tooltip();
  }

  jQuery('#btn_view_spellbook').on('click', function(){
    builder_data.available_spells = {};
    builder_data.available_spells["elf"] = []
    for (var sphere in builder_data.spells) {
      for (var level in builder_data.spells[sphere]) {
        if(typeof builder_data.character.skills["Spell Sphere: "+ sphere] !== 'undefined'){
          for (var spell in builder_data.spells[sphere][level]) {
            if(typeof builder_data.character.skills[builder_data.circles[level-1]] !== 'undefined'){
              var spell_to_add = builder_data.spells[sphere][level][spell];
              if(typeof builder_data.available_spells[level] == "undefined"){
                builder_data.available_spells[level] = []
              }
              builder_data.available_spells[level].push(spell_to_add);
              builder_data.available_spells["elf"].push(spell_to_add);
            }
          }
        }
      }
    }
    jQuery('#spellbook_modal').modal();
  });

  jQuery('.change_spell').on('click', function(){
    var circle = jQuery(this).closest('.spell_slot').attr('circle');
    var slot = jQuery(this).closest('.spell_slot').attr('slot');
    var day = jQuery(this).closest('.spell_slot').attr('day');
    var available_level_spells = builder_data.available_spells[circle];
    jQuery('#spell_modal').find('#spell_list').html('');

    for (i=0;i<available_level_spells.length;i++){
      var spell_html = `<div class="row skill_row spell_row"><div class="col-sm-12 skill" style=""><div class="row"><div class="col-xs-1">
        <i id="" class="fa fa-plus-square spell_add skill_add" circle="${circle}" slot="${slot}" day="${day}" spell-name="${available_level_spells[i]['name']}" aria-hidden="true"></i>
        <i class="fa fa-check-square-o skill_purchased" aria-hidden="true"></i>
      </div>
      <div class="col-xs-9">
        <span class="cat_label"><i class="fa fa-magic" aria-hidden="true"></i></span>&nbsp;
          ${available_level_spells[i]['sphere']}: ${available_level_spells[i]['name']}
        </span>
        &nbsp; <i class="fa fa-info-circle skill_expander spell_expander" uuidaria-hidden="true"></i>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 skill_desc spell_desc" style="display:none;">
        Incant: ${available_level_spells[i]['incant']}<br/>
        Duration: ${available_level_spells[i]['duration']}<br/>
        Description: ${available_level_spells[i]['desc']}<br/>
        <hr />
        <p class="skill_meta"><a href="#" class="skill_closer"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; close</a></p>
      </div>
    </div></div></div></div>`;
    jQuery('#spell_modal').find('#spell_list').append(spell_html);
    }

    jQuery('#spell_modal').modal();
  });

  jQuery(document).on('click', '.spell_add', function(){
    var circle = jQuery(this).attr('circle');
    var slot = jQuery(this).attr('slot');
    var day = jQuery(this).attr('day');
    var spell_name = jQuery(this).attr('spell-name');
    jQuery(`.spell_name[circle="${circle}"][slot="${slot}"][day="${day}"]`).html(spell_name);

    if(typeof builder_data.character.spells[day] === "undefined"){
      builder_data.character.spells[day] = {};
    }
    if(typeof builder_data.character.spells[day][circle] === "undefined"){
      builder_data.character.spells[day][circle] = {};
    }
    builder_data.character.spells[day][circle][slot] = spell_name;

    jQuery('#spell_modal').modal('toggle');

    push_spell_to_remote(builder_data, slot, level, day, spell_name);

  });
  jQuery('#spell_selector_close').on('click', function(){
    jQuery('#spell_modal').modal('toggle');
  });

  jQuery('.show_armour_modal').on('click', function(){
    var slot = jQuery(this).attr('slot');
    var level = jQuery(this).attr('level');
    jQuery('#armour_add').attr('slot', slot);
    jQuery('#armour_add').attr('level', level);
    jQuery('#armour_add').attr('old-ap', jQuery('#armour_'+slot).attr('val'+level));
    jQuery('#armour_modal').modal();
  });

  jQuery('#armour_add').on('click', function(){
    if (jQuery(this).attr('old-ap') != "0") {
      builder_data.character.armour_points -= parseInt(jQuery(this).attr('old-ap'));
      builder_data.character.armour_pieces -= 1;
    }

    var slot = jQuery(this).attr('slot');
    var level = jQuery(this).attr('level');
    var ap = parseInt(jQuery('#armour_type').val());
    var type = jQuery('#armour_type').find('option:selected').attr('type');
    var penalty = jQuery('#armour_penalty').val();

    if(penalty != '0'){
      type = type + " (penalty: "+penalty+")";
      ap = ap-parseInt(penalty);
    }

    jQuery('#armour_'+slot+'_val_'+level).html(ap);
    jQuery('#armour_'+slot+'_desc_'+level).html(type);
    jQuery('#armour_'+slot).attr('val'+level, ap);
    var section_ap = parseInt(jQuery('#armour_'+slot).attr('val1')) + parseInt(jQuery('#armour_'+slot).attr('val2'));
    jQuery('#ap_val_'+slot).html(section_ap);

    if(typeof builder_data.armour[slot] == "undefined"){
      builder_data.armour[slot] = {};
    }

    builder_data.armour[slot][level] = {'value': ap, 'type': type, 'penalty': penalty};
    builder_data.armour_points += ap;
    builder_data.armour_pieces += 1;

    jQuery('#armour_points').html(builder_data.armour_points);
    jQuery('#armour_count').html(builder_data.armour_pieces);

    jQuery('#armour_slot_data_'+slot).find('.armour_toggle').toggleClass('hidden');
    jQuery('#armour_modal').modal('toggle');

    push_armour_to_remote(builder_data, slot, level, ap, penalty, type);

  });

  jQuery('#character-save-dropdown').on('change', function(){
    let dd_val = jQuery(this).find('option:selected').html();
    if (dd_val != 'Create a character'){
      jQuery('#char_name').val();

    }
  });

  jQuery('#fb-logout-button').on('click', function(){
    console.log('logging out');
    FB.logout(function(response) {
      // user is now logged out
      console.log(response);
    });
    jQuery('.fb-login-button').show();
    jQuery('.login_element').show();
    jQuery('.advanced_element').hide();
    builder_data.user_logged_in = false;
  });

  jQuery('#fb-login-button').on('click', function(){
    FB.login(function(response) {
      if (response.authResponse) {
       console.log('Welcome!  Fetching your information.... ');
       FB.api('/me', function(response) {
         console.log('Good to see you, ' + response.name + '.');
         builder_data.user_logged_in = true;

         var uid = response.authResponse.userID;
         load_characters(String(uid));
       });
      } else {
       console.log('User cancelled login or did not fully authorize.');
      }
    });
  });

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  window.fbAsyncInit = function() {

    FB.init({
      appId      : '121772051743892',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
    FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
        // the user is logged in and has authenticated your
        // app, and response.authResponse supplies
        // the user's ID, a valid access token, a signed
        // request, and the time the access token
        // and signed request each expire
        var uid = response.authResponse.userID;
        var accessToken = response.authResponse.accessToken;
        builder_data.access_token = response.authResponse.accessToken;
        builder_data.user_logged_in = true;
        console.log('User logged in.');
        jQuery('.fb-login-button').hide();
        jQuery('.login_element').hide();
        jQuery('.advanced_element').show();
        console.log('fkey='+uid);

        load_characters(String(uid));

        builder_data.character.fb_user_id = uid;
      } else if (response.status === 'not_authorized') {
        console.log('not authorized');
        builder_data.user_logged_in = false;
        // the user is logged in to Facebook,
        // but has not authenticated your app
        jQuery('.fb-login-button').show();
        jQuery('.login_element').show();
        jQuery('.advanced_element').hide();
      } else {
        console.log('not logged in');
        builder_data.user_logged_in = false;
        // the user isn't logged in to Facebook.
        jQuery('.fb-login-button').show();
        jQuery('.login_element').show();
        jQuery('.advanced_element').hide();
      }
     });
     FB.Event.subscribe('xfbml.render', toggle_fb_placeholder);
     FB.Event.subscribe('auth.statusChange', toggle_fb_elements);
     console.log('end of init');
  };



    var toggle_fb_placeholder = function() {
      console.log('toggle placeholder');
      jQuery('.fb_login_placeholder').hide();
    }

    var toggle_fb_elements = function() {
      console.log('finished rendering');
      if(FB.getUserID() > 0){
        jQuery('.fb_login_placeholder').hide();
        jQuery('.fb-login-button').hide();
        jQuery('.login_element').hide();
        jQuery('.advanced_element').show();
      } else {
        if(builder_data.access_token){
          jQuery('.fb_login_placeholder').show();
        }
        jQuery('.fb-login-button').show();
        jQuery('.login_element').show();
        jQuery('.advanced_element').hide();
      }
    }

  if(window.location.href.indexOf('uwtg') !== -1) {
    jQuery('.login_element').hide();
    jQuery('.advanced_element').show();
  }

});
