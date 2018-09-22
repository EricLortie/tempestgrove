

 <?php
 /**
  * Template Name: Character Builder
  *
  * @package WordPress
  * @subpackage Tempest Grove
  * @since Tempest Grove 2.0
  */

  get_header();
 ?>


<div id="fb-root"></div>

<div class="container--xl flex-grid">
				<?php
				if( have_posts() ):
					while( have_posts() ):
						the_post(); ?>
            <button class="btn btn-red" style="max-width: 300px; display:block; margin:0px auto;" data-toggle="collapse" data-target="#demo">Read Instructions</button>

            <div id="demo" class="collapse">
              <hr/>
              <?php the_content(); ?>
            </div>
            <hr/>
            <?php
					endwhile;
				else:
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>



        <script type="text/javascript">
          var builder_data = {};

          var saved_char = localStorage.getItem('saved_character');

          state_counter = 0;
          builder_data.character = {};
          builder_data.character.pc_class = "";
          builder_data.character.race = "";
          builder_data.character.skills = {};
          builder_data.character.spells = {};
          builder_data.character.class_skills = {};
          builder_data.character.strength = 0;
          builder_data.character.body_point_bonus = 0;
          builder_data.character.frags_avail = 0;
          builder_data.character.frags_spent = 0;
          builder_data.character.skill_count = 0;
          builder_data.character.rulebook = 5.5;
          builder_data.character.racial_skills = 0;
          builder_data.character.automatic_racial_skills = 0;
          builder_data.character.next_racial_skill_level = 1;
          builder_data.character.fb_user_id = 0;
          builder_data.character.occupation = false;
          builder_data.character.vocation = true;
          builder_data.races = [];
          builder_data.skill = 0;
          builder_data.step = 0;
          builder_data.vocations = [];
          builder_data.occupations = [];
          builder_data.pc_classes = [];
          builder_data.spell_spheres = [];
          builder_data.spells = {};
          builder_data.heavy_armour = false;

          builder_data.armour_points = 0;
          builder_data.armour_pieces = 0;
          builder_data.armour = {};
          builder_data.available_spells = {};

          builder_data.character.circle_values = {
            "Spell Slot: 1st Circle": 0,
            "Spell Slot: 2nd Circle": 0,
            "Spell Slot: 3rd Circle": 0,
            "Spell Slot: 4th Circle": 0,
            "Spell Slot: 5th Circle": 0,
            "Spell Slot: 6th Circle": 0,
            "Spell Slot: 7th Circle": 0,
            "Spell Slot: 8th Circle": 0,
            "Spell Slot: 9th Circle": 0,
            "Spell Slot: Ritual Base": 0
          }

          builder_data.circles = [
            "Spell Slot: 1st Circle", "Spell Slot: 2nd Circle", "Spell Slot: 3rd Circle",
            "Spell Slot: 4th Circle", "Spell Slot: 5th Circle", "Spell Slot: 6th Circle",
            "Spell Slot: 7th Circle", "Spell Slot: 8th Circle", "Spell Slot: 9th Circle",
            "Spell Slot: Ritual Base"
          ]
          builder_data.character_states = [];
          builder_data.skills = [];
          builder_data.level_chart = [
            {'cp': 150, 'cppb': 65, 'bp_w': 6, 'bp_r': 4, 'bp_s': 3},
            {'cp': 250, 'cppb': 43, 'bp_w': 8, 'bp_r': 5, 'bp_s': 4},
            {'cp': 350, 'cppb': 34, 'bp_w': 10, 'bp_r': 6, 'bp_s': 4},
            {'cp': 450, 'cppb': 28, 'bp_w': 12, 'bp_r': 7, 'bp_s': 5},
            {'cp': 550, 'cppb': 24, 'bp_w': 14, 'bp_r': 8, 'bp_s': 6},
            {'cp': 650, 'cppb': 22, 'bp_w': 16, 'bp_r': 9, 'bp_s': 6},
            {'cp': 750, 'cppb': 19, 'bp_w': 18, 'bp_r': 10, 'bp_s': 7},
            {'cp': 850, 'cppb': 17, 'bp_w': 20, 'bp_r': 11, 'bp_s': 8},
            {'cp': 950, 'cppb': 16, 'bp_w': 22, 'bp_r': 12, 'bp_s': 8},
            {'cp': 1050, 'cppb': 15, 'bp_w': 24, 'bp_r': 13, 'bp_s': 9},
            {'cp': 1150, 'cppb': 14, 'bp_w': 26, 'bp_r': 14, 'bp_s': 10},
            {'cp': 1250, 'cppb': 13, 'bp_w': 28, 'bp_r': 15, 'bp_s': 10},
            {'cp': 1350, 'cppb': 12, 'bp_w': 30, 'bp_r': 16, 'bp_s': 11},
            {'cp': 1450, 'cppb': 12, 'bp_w': 32, 'bp_r': 17, 'bp_s': 12},
            {'cp': 1550, 'cppb': 11, 'bp_w': 34, 'bp_r': 18, 'bp_s': 12},
            {'cp': 1650, 'cppb': 11, 'bp_w': 36, 'bp_r': 19, 'bp_s': 13},
            {'cp': 1750, 'cppb': 10, 'bp_w': 38, 'bp_r': 20, 'bp_s': 14},
            {'cp': 1850, 'cppb': 10, 'bp_w': 40, 'bp_r': 21, 'bp_s': 14},
            {'cp': 1950, 'cppb': 10, 'bp_w': 42, 'bp_r': 22, 'bp_s': 15},
            {'cp': 2050, 'cppb': 10, 'bp_w': 44, 'bp_r': 23, 'bp_s': 16},
          ]
          builder_data.human_level_chart = [];
          for (level in builder_data.level_chart){
            var level_data =  jQuery.extend({}, builder_data.level_chart[level]);
            level_data['cp'] += 50;
            builder_data.human_level_chart.push(level_data);
          };
          builder_data.sphere_chart = [
            {'mer_cost': 100,'ran_cost': 100, 'tem_cost': 75, 'nig_cost': 75, 'ass_cost': 100, 'wit_cost': 75, 'mag_cost': 25, 'dru_cost': 50, 'bar_cost': 50, 'cha_cost': 50, 'dem_cost': 50},
            {'mer_cost': 200,'ran_cost': 200, 'tem_cost': 175, 'nig_cost': 175, 'ass_cost': 200, 'wit_cost': 175, 'mag_cost': 150, 'dru_cost': 175, 'bar_cost': 175, 'cha_cost': 200, 'dem_cost': 175},
            {'mer_cost': 300,'ran_cost': 300, 'tem_cost': 275, 'nig_cost': 275, 'ass_cost': 300, 'wit_cost': 275, 'mag_cost': 200, 'dru_cost': 225, 'bar_cost': 225, 'cha_cost': 300, 'dem_cost': 225},
            {'mer_cost': "",'ran_cost': "", 'tem_cost': "", 'nig_cost': "", 'ass_cost': "", 'wit_cost': "", 'mag_cost': "", 'dru_cost': "", 'bar_cost': "", 'cha_cost': "", 'dem_cost': ""}
          ]
          builder_data.categories = {
            'Warrior': ['Mercenary', 'Ranger', 'Templar', 'Paladin', 'Dread Knight'],
            'Rogue': ['Assassin', 'Nightblade', 'Witch Hunter'],
            'Scholar': ['Mage', 'Druid', 'Bard', 'Darkweaver', 'Lightweaver', 'Dragon Knight'],
          }

          builder_data.skill_aliases = {
            'Weapon Group Proficiency': [
              'Weapon Group Proficiency: Simple',
              'Weapon Group Proficiency: Medium',
              'Weapon Group Proficiency: Large',
              'Weapon Group Proficiency: Exotic'
            ],
            'Specialization +1: Weapon Group': [
              'Specialization +1: Simple Group',
              'Specialization +1: Medium Group',
              'Specialization +1: Large Group',
              //'Specialization +1: Exotic Group',
            ],
            'Specialization +1: Weapon Specific': [
              'Specialization +1: Simple Weapon',
              'Specialization +1: Medium Weapon',
              'Specialization +1: Large Weapon',
              'Specialization +1: Exotic Weapon',
            ],
            'Critical +2: Group': [
              'Critical +2: Simple Group',
              'Critical +2: Medium Group',
              'Critical +2: Large Group',
              //'Critical +2: Exotic Group'
            ],
            'Critical +2: Specific': [
              'Critical +2: Specific Simple Weapon',
              'Critical +2: Specific Medium Weapon',
              'Critical +2: Specific Large Weapon',
              //'Critical +2: Specific Exotic Weapon'
            ],
            "Execute" : [
              'Execute: Specific Simple Weapon',
              'Execute: Specific Medium Weapon',
              'Execute: Specific Large Weapon',
              //'Execute: Specific Exotic Weapon',
            ],
            "Execute: Subsequent" : [
              'Execute: Specific Simple Weapon (Subsequent)',
              'Execute: Specific Medium Weapon (Subsequent)',
              'Execute: Specific Large Weapon (Subsequent)',
              //'Execute: Specific Exotic Weapon (Subsequent)',
            ],
            "Execute: Master" : [
              'Execute: Simple Weapon Group',
              'Execute: Medium Weapon Group',
              'Execute: Large Weapon Group',
              //'Execute: Exotic Weapon Group',
            ],
            "Execute: Master Subsequent" : [
              'Execute: Simple Weapon Group (Subsequent)',
              'Execute: Medium Weapon Group (Subsequent)',
              'Execute: Large Weapon Group (Subsequent)',
              //'Execute: Exotic Weapon Group (Subsequent)',
            ],
            "Slay / Parry" : [
              'Slay / Parry: Specific Simple Weapon',
              'Slay / Parry: Specific Medium Weapon',
              'Slay / Parry: Specific Large Weapon',
              'Slay / Parry: Specific Exotic Weapon',
            ],
            "Slay / Parry: Subsequent" : [
              'Slay / Parry: Specific Simple Weapon (Subsequent)',
              'Slay / Parry: Specific Medium Weapon (Subsequent)',
              'Slay / Parry: Specific Large Weapon (Subsequent)',
              'Slay / Parry: Specific Exotic Weapon (Subsequent)',
            ],
            "Slay / Parry: Master" : [
              'Slay / Parry (Master): All Simple Weapons',
              'Slay / Parry (Master): All Medium Weapons',
              'Slay / Parry (Master): All Large Weapons',
              'Slay / Parry (Master): All Exotic Weapons',
            ],
            "Slay / Parry: Master Subsequent" : [
              'Slay / Parry (Master): All Simple Weapons (Subsequent)',
              'Slay / Parry (Master): All Medium Weapons (Subsequent)',
              'Slay / Parry (Master): All Large Weapons (Subsequent)',
              'Slay / Parry (Master): All Exotic Weapons (Subsequent)',
            ]
          }


          function save_skill(skill, category){
            jQuery.ajax({
                type: "POST",
                data :JSON.stringify({name: skill, category: category}),
                headers: { 'X-API-KEY': "tempest_grove" },
                url: "https://arcane-sierra-27033.herokuapp.com/skills",
                contentType: "application/json",
                dataType: "json",
                success: function(data){
                }
            });

          }

          function save_character_step(character, step, skill){

            if(skill != "Weapon Group Proficiency: Simple" && window.location.href.indexOf('uwtg') == -1){

              var api_character = {
                rulebook: character.rulebook,
                character_id: character.character_id,
                category: character.category,
                step: step,
                character: JSON.stringify(character),
                pc_class: character.pc_class,
                vocation: character.vocation,
                occupation: character.occupation,
                race: character.race,
                skill_name: skill,
                skill_count: character.skill_count,
                frags_spent: character.frags_spent,
                spell_spheres: character.spell_spheres,
                cp_spent: character.cp_spent,
                fb_user_id: character.fb_user_id,
                status: 'builder'
              };

              jQuery.ajax({
                  type: "POST",
                  data :JSON.stringify(api_character),
                  headers: { 'X-API-KEY': "tempest_grove" },
                  url: "https://arcane-sierra-27033.herokuapp.com/character_steps",
                  contentType: "application/json",
                  dataType: "json",
                  success: function(data){
                  }
              });
            }
          }

          function load_characters(fb_user_id){
            jQuery.ajax({
                type: "GET",
                data : {fb_user_id: fb_user_id},
                headers: { 'X-API-KEY': "tempest_grove" },
                url: "https://arcane-sierra-27033.herokuapp.com/characters/fetch_by_fb_user_id",
                contentType: "application/json",
                dataType: "json",
                success: function(data){
                  console.log(data);
                  builder_data.saved_characters = {};
                  jQuery('#character-load-dropdown').html('<option>Select a character</option>');
                  for (let char of data) {
                    builder_data.saved_characters[char.id] = JSON.parse(char.character);
                    let char_name = encodeURI(JSON.parse(char.character).char_name);
                    jQuery('#character-save-dropdown').append('<option value="'+char.id+'">'+char_name+'</option>');
                    jQuery('#character-load-dropdown').append('<option value="'+char.id+'">'+char_name+'</option>');
                  }
                },
                failure: function(data){
                  console.log(data);
                }
            });
          }

          function save_character(character){

            var api_character = {
              id: character.id,
              rulebook: character.rulebook,
              character_id: character.character_id,
              category: character.category,
              character: JSON.stringify(character),
              pc_class: character.pc_class,
              vocation: character.vocation,
              occupation: character.occupation,
              race: character.race,
              fb_user_id: builder_data.character.fb_user_id
            };

            jQuery.ajax({
                type: "POST",
                data :JSON.stringify(api_character),
                headers: { 'X-API-KEY': "tempest_grove" },
                url: "https://arcane-sierra-27033.herokuapp.com/characters/save_character_data",
                contentType: "application/json",
                dataType: "json",
                success: function(data){
                  console.log(data);
                  load_characters(builder_data.character.fb_user_id);
                },
                failure: function(data){
                  console.log(data);
                }
            });
          }
          function push_armour_to_remote(armour_data, slot, level, ap, penalty, type){

            if(window.location.href.indexOf('uwtg') == -1){
              var api_armour = {
                rulebook: armour_data.character.rulebook,
                character_id: armour_data.character.character_id,
                category: armour_data.character.category,
                character: JSON.stringify(armour_data.character),
                pc_class: armour_data.character.pc_class,
                vocation: armour_data.character.vocation,
                occupation: armour_data.character.occupation,
                race: armour_data.character.race,
                skill_count: armour_data.character.skill_count,
                frags_spent: armour_data.character.frags_spent,
                spell_spheres: armour_data.character.spell_spheres,
                cp_spent: armour_data.character.cp_spent,
                armour_points: armour_data.armour_points,
                armour_pieces: armour_data.armour_pieces,
                armour_slot: slot,
                armour_level: level,
                armour_value: ap,
                armour_penalty: penalty,
                armour_type: type
              };

              jQuery.ajax({
                  type: "POST",
                  data :JSON.stringify(api_armour),
                  headers: { 'X-API-KEY': "tempest_grove" },
                  url: "https://arcane-sierra-27033.herokuapp.com/armours",
                  contentType: "application/json",
                  dataType: "json",
                  success: function(data){
                  }
              });
            }
          }
          function push_spell_to_remote(spell_data, slot, circle, day, spell_name){

            if(window.location.href.indexOf('uwtg') == -1){
              var api_spell = {
                rulebook: spell_data.character.rulebook,
                character_id: spell_data.character.character_id,
                category: spell_data.character.category,
                character: JSON.stringify(spell_data.character),
                pc_class: spell_data.character.pc_class,
                vocation: spell_data.character.vocation,
                occupation: spell_data.character.occupation,
                race: spell_data.character.race,
                skill_count: spell_data.character.skill_count,
                frags_spent: spell_data.character.frags_spent,
                spell_spheres: spell_data.character.spell_spheres,
                cp_spent: spell_data.character.cp_spent,
                spell_name: spell_name,
                spell_slot: slot,
                spell_circle: circle,
                spell_day: day
              };

              jQuery.ajax({
                  type: "POST",
                  data :JSON.stringify(api_spell),
                  headers: { 'X-API-KEY': "tempest_grove" },
                  url: "https://arcane-sierra-27033.herokuapp.com/spell_slots",
                  contentType: "application/json",
                  dataType: "json",
                  success: function(data){
                  }
              });
            }
          }

        </script>

        <?php if( have_rows('races', get_id_by_slug('codex-races')) ): ?>
          <?php $races = array(); ?>
          <?php while( have_rows('races',get_id_by_slug('codex-races')) ): the_row(); ?>


            <?php // vars
            $name = get_sub_field('name');
            $life_span = get_sub_field('life_span');
            $frag_cost = get_sub_field('frag_cost');
            $description = get_sub_field('description');
            $racial_characteristics = get_sub_field('racial_characteristics');
            $advantages = get_sub_field('advantages');
            $disadvantages = get_sub_field('disadvantages');
            $appendix = get_sub_field('appendix');
            $photo = get_sub_field('photo');
            $race = new stdClass();
            $race->name = $name;
            $race->life_span = $life_span;
            $race->frag_cost = $frag_cost;
            $race->appendix = $appendix;
            if ($frag_cost != "") {
              $race->race_string = preg_replace('/ \(.*/', "", $name) . " (" . $frag_cost . " frags)";
            } else {
              $race->race_string = preg_replace('/ \(.*/', "", $name);
            }
            $race->description = $description;
            $race->racial_characteristics = $racial_characteristics;
            $race->advantages = $advantages;
            $race->disadvantages = $disadvantages;
            if($photo == ""){
              $race->photo = site_url() . "/wp-content/uploads/2016/06/UWL_logo.png";
            } else {
              $race->photo = $photo;
            }
            array_push($races, $race);

            ?>

            <script type="text/javascript">
              builder_data.races[`<?php echo $name; ?>`] = {
                name: `<?php echo $name ?>`,
                lifespan: `<?php echo $life_span ?>`,
                racial_characteristics: `<?php echo $racial_characteristics ?>`,
                description: `<?php echo $description ?>`,
                advantages: `<?php echo $advantages ?>`,
                disadvantages: `<?php echo $disadvantages ?>`,
                frag_cost: `<?php  echo $frag_cost; ?>`
              }
            </script>

          <?php endwhile; ?>
          <?php //usort($races, 'sortByOption'); ?>
        <?php endif; ?>

        <?php if( have_rows('classes', get_id_by_slug('codex-classes')) ): ?>
          <?php $classes = array(); ?>
          <?php $vocations = array(); ?>
          <?php $occupations = array(); ?>
          <?php while( have_rows('classes', get_id_by_slug('codex-classes')) ): the_row(); ?>

            <?php // vars

            $name = get_sub_field('name');
            $frag_cost = get_sub_field('frag_cost');

            $description = get_sub_field('description');
            $photo = get_sub_field('photo');
            $frag_cost = get_sub_field('frag_cost');

            $pc_class = new stdClass();
            $pc_class->name = $name;
            $pc_class->description = $description;
            $pc_class->frag_cost = $frag_cost;
            if($photo == ""){
              $pc_class->photo = site_url() . "/wp-content/uploads/2016/06/UWL_logo.png";
            } else {
              $pc_class->photo = $photo;
            }

            $optional = get_sub_field('optional');
            if ( $optional && in_array('vocation', $optional) ) {
              array_push($vocations, $pc_class); ?>
              <script type="text/javascript">
                builder_data.vocations[`<?php echo $name; ?>`] = {
                  name: `<?php echo $name ?>`,
                  description: `<?php echo $description ?>`
                }
              </script>
              <?php
            } else if($optional && in_array('occupation', $optional)) {
              array_push($occupations, $pc_class); ?>
              <script type="text/javascript">
                builder_data.occupations[`<?php echo $name; ?>`] = {
                  name: `<?php echo $name ?>`,
                  description: `<?php echo $description ?>`
                }
              </script>
              <?php
            } else {
              array_push($classes, $pc_class); ?>

              <script type="text/javascript">
                builder_data.pc_classes[`<?php echo $name; ?>`] = {
                  name: `<?php echo $name ?>`,
                  description: `<?php echo $description ?>`
                }
              </script>

            <?php } ?>


          <?php endwhile;
        endif; ?>

        <?php if( have_rows('spells', get_id_by_slug('codex-spells')) ): ?>
          <?php $count = 0; ?>
          <?php while( have_rows('spells', get_id_by_slug('codex-spells')) ): the_row(); ?>

            <?php $name = preg_replace('<type>', '[type]', get_sub_field('name')); ?>
            <?php $sphere = get_sub_field('sphere'); ?>
            <?php $incant = preg_replace('<type>', '[type]', get_sub_field('incant')); ?>
            <?php $level = get_sub_field('level'); ?>
            <?php $duration = get_sub_field('duration'); ?>
            <?php $desc = preg_replace('<type>', '[type]', get_sub_field('description')); ?>

            <script type="text/javascript">
              if(typeof builder_data.spells[`<?php echo $sphere; ?>`] == "undefined"){
                builder_data.spells[`<?php echo $sphere; ?>`] = {}
              }
              if(typeof builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`] == "undefined"){
                builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`] = []
              }
              builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`].push({
                name: `<?php echo $name ?>`,
                level: `<?php echo $level ?>`,
                sphere: `<?php echo $sphere ?>`,
                incant: `<?php echo $incant ?>`,
                duration: `<?php echo $duration ?>`,
                desc: `<?php echo $desc ?>`
              });
            </script>

          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('spells', get_id_by_slug('codex-frag-spells')) ): ?>
          <?php $count = 0; ?>
          <?php while( have_rows('spells', get_id_by_slug('codex-frag-spells')) ): the_row(); ?>

            <?php $name = preg_replace('<type>', '[type]', get_sub_field('name')); ?>
            <?php $sphere = get_sub_field('sphere'); ?>
            <?php $incant = preg_replace('<type>', '[type]', get_sub_field('incant')); ?>
            <?php $level = get_sub_field('level'); ?>
            <?php $duration = get_sub_field('duration'); ?>
            <?php $desc = preg_replace('<type>', '[type]', get_sub_field('description')); ?>


            <script type="text/javascript">
              if(typeof builder_data.spells[`<?php echo $sphere; ?>`] == "undefined"){
                builder_data.spells[`<?php echo $sphere; ?>`] = {}
              }
              if(typeof builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`] == "undefined"){
                builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`] = []
              }
              builder_data.spells[`<?php echo $sphere; ?>`][`<?php echo $level; ?>`].push({
                name: `<?php echo $name ?>`,
                level: `<?php echo $level ?>`,
                sphere: `<?php echo $sphere ?>`,
                incant: `<?php echo $incant ?>`,
                duration: `<?php echo $duration ?>`,
                desc: `<?php echo $desc ?>`
              });
            </script>

          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('spell_spheres', get_id_by_slug('codex-magic')) ): ?>
          <?php $count = 0; ?>
          <?php while( have_rows('spell_spheres', get_id_by_slug('codex-magic')) ): the_row(); ?>

            <?php build_skill_row($post, $count, "spell_sphere"); ?>

          <?php endwhile; ?>
        <?php endif; ?>



        <?php if( have_rows('skills', get_id_by_slug('codex-racial-abilities')) ): ?>
          <?php $s_count = 0; ?>
          <?php while( have_rows('skills', get_id_by_slug('codex-racial-abilities')) ): the_row(); ?>

            <?php build_skill_row($post, $s_count, "race_skill"); ?>

          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('skills', get_id_by_slug('codex-class-skills')) ): ?>
          <?php $s_count = 0; ?>
          <?php while( have_rows('skills', get_id_by_slug('codex-class-skills')) ): the_row(); ?>

            <?php build_skill_row($post, $s_count, "class_skill"); ?>

          <?php endwhile; ?>
        <?php endif; ?>




        <?php if( have_rows('skills', get_id_by_slug('codex-skills')) ): ?>
          <?php $s_count = 0; ?>
          <?php while( have_rows('skills', get_id_by_slug('codex-skills')) ): the_row(); ?>

            <?php build_skill_row($post, $s_count, "skill"); ?>


          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('skills', get_id_by_slug('codex-frag-skills')) ): ?>
          <?php $s_count = 0; ?>
          <?php while( have_rows('skills', get_id_by_slug('codex-frag-skills')) ): the_row(); ?>

            <?php build_skill_row($post, $s_count, "frag skill"); ?>

          <?php endwhile; ?>
        <?php endif; ?>

        <div id="launcher" class="flex-grid">
          <div class="small full">

            <div id="menu_launcher" class="flex-grid bg_<?php echo rand(1,5); ?>">
              <div class="small full">
                <div id="menu_items">
                  <div id="menu_primary" class="flex-grid">
                    <div class="blog-post text-center small full" style="margin-bottom:3rem;">
                      <a id="btn_choose_race" href="#" title="Choose Race" class="full-width blog-post-button locked">Select Race <i class="fa fa-check-square passed" aria-hidden="true"></i></a>
                    </div>

                    <div class="blog-post text-center small full" style="margin-bottom:3rem;">
                      <a id="btn_choose_class" href="#" title="Choose Class" class="full-width blog-post-button locked">Select Class <i class="fa fa-check-square passed" aria-hidden="true"></i></a>
                    </div>

                    <div class="blog-post text-center" style="">
                      <div id="category-menu" class="small full <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">
                        <label>SELECT A CATEGORY <i class="fa fa-info-circle" aria-hidden="true" title="This is not required but will be useful for future projects."></i></label>
                        <p style="margin-bottom:3rem;"><span class="full-width styled-dropdown custom-dropdown custom-dropdown--red">
                          <select id="category-dropdown" class="full-width builder_selector custom-dropdown__select custom-dropdown__select--red">
                            <option>---</option>
                            <?php $categories = array("Crafter", "Defender", "Attacker", "Damage Dealer", "Tank", "Guard", "Healer", "Passifist", "Hero", "Villain", "Storyteller", "Politician", "Merchant", "Jack of All Trades", "Specialist", "Observer", "Other"); ?>
                            <?php foreach ($categories as $category) { ?>
                              <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                            <?php } ?>
                          </select>
                        </span></p>
                      </div>
                    </div>

                    <div class="blog-post text-center small full" style="margin-bottom:3rem;">
                      <a id="btn_generate" href="#" title="Build Character" class="full-width blog-post-button state_saver locked">Start Character</a>
                    </div>

                    <div class="blog-post text-center small full login_element" style="margin-bottom:3rem;">
                      <p>Logging in allows you to save and load characters, as well as unlocks additional functionality.</p>

                      <p class="fb_login_placeholder" style="padding-top: 9px;"><img src="<?php echo get_template_directory_uri(); ?>/inc/loading_spinner.gif" style="height:20px;"/> Loading</p>
                      <div class="fb-login-button" data-max-flex-grids="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>

                    </div>

                    <div class="btn_warning text-center advanced_element" style="margin-bottom:3rem;">
                      <div class="flex-grid">
                        <div class="small-1of2">
                          <button class="btn btn-red" style="width:77%" id="btn_data_import">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> LOAD
                          </button>
                        </div>
                        <div class="small-1of2">
                          <button class="btn btn-red" style="width:77%" id="fb-logout-button">LOGOUT</button>
                        </div>
                      </div>
                    </div>
                    <div class="blog-post text-center small full" style="margin-bottom:3rem;">
                      <hr/>
                    </div>
                  </div>

                  <div id="data_fields" class="flex-grid" style="padding-bottom:3rem;">
                    <div class="small full">
                    <label>Saving and loading characters requires that you first login.</label>

                    <p class="fb_login_placeholder" style="padding-top: 9px;"><img src="<?php echo get_template_directory_uri(); ?>/inc/loading_spinner.gif" style="height:20px;"/> Loading</p>
                    <div class="fb-login-button" style="padding-top:0px !important" data-max-flex-grids="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
                    <div id="data_fields_export">
                      <div id="save_character_section">

                        <label>Click the button below to save this character to the character builder database.</label>

                        <p><span id="character-save-dropdown-container" class="custom-dropdown custom-dropdown--red" style="width:100%">
                          <select id="character-save-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red" style="width:100%">
                            <option>Create a new character</option>
                          </select>
                        </span></p>
                        <label>Character Name
                        <input type="text" id="char_name" /></label>
                        <br/>
                        <button id="save_character" class="btn btn-red btn_process_data advanced_element">Save Character</button>

                        <br/>
                        <hr/>
                        <button id="delete_character" class="btn btn-red btn_process_data advanced_element" style="background: #333;border: 1px solid white;">Delete Character</button>

                      </div>
                    </div>
                    <div id="data_fields_import">
                      <label>Load a character from the database.</label>

                      <p><span id="character-save-dropdown-container" class="custom-dropdown custom-dropdown--red" style="width:100%">
                        <select id="character-load-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red" style="width:100%">
                          <option>Select a character</option>
                        </select>
                      </span></p>
                      <br/>
                      <button id="load_character" class="btn btn-red btn_process_data advanced_element">Load Character</button>

                    </div>
                    <hr/>
                    <button id="btn_close_data" class="btn btn-red advanced_element">Back</button>

                  </div>
                </div>
              </div>
            </div>

            <div id="selector_elements" class="small full">
              <div id="race_selector" class="flex-grid">

                <div id="race-menu" class="small full <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">
                  <p><span class="custom-dropdown custom-dropdown--red">
                    <select id="race-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red">
                    <option>Select a race</option>
                      <?php
                      usort($races, "cmp");
                      foreach ($races as $race) { ?>
                        <?php
                        $race_string = ($race->frag_cost > 0) ? $race->name . " (" . $race->frag_cost . " FRAGS)" : $race->name;
                        if(is_array($race->appendix)) {
                          $race_string .= " (APPENDIX RULEBOOK)";
                        }
                        ?>

                        <option value="<?php echo $race->name; ?>"><?php echo $race_string ?></option>
                      <?php  }?>
                    </select>
                  </span></p>
                </div>

                <div id="race-content" class="small full">
                  <?php
                  foreach ($races as $race) { ?>
                    <div class="race content repeater-content" data-name="<?php echo $race->name; ?>">
                      <h2><?php echo $race->name; ?></h2>

                      <div class="flex-grid repeater-flex-grid">
                        <div class="small-1of3 column race_meta">

                          <img src="<?php echo $race->photo ?>" class="img-responsive builder_photo" alt="<?php echo $race->name ?>" title="<?php echo $race->name ?>"/>

                          <div class="blog-post text-center" style="margin-bottom:3rem;">
                            <a id="select_race" href="#" title="Select Race" data-race="<?php echo $race->name; ?>" data-frag_cost="<?php echo $race->frag_cost; ?>" class="builder_selector blog-post-button locked">
                              Select <?php echo $race->race_string; ?>
                            </a>
                          </div>

                          <h4>Lifespan</h4>

                          <p><?php echo $race->life_span; ?></p>

                          <h4>Racial Characteristics</h4>

                          <p><?php echo $race->racial_characteristics; ?></p>
                        </div>
                        <div class="small-1of3 column race_info <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">

                          <h4>Descriptipn</h4>
                          <?php echo $race->description; ?>

                          <h4>Advantages</h4>
                          <?php echo $race->advantages; ?>

                          <h4>Disadvantages:</h4>
                          <?php echo $race->disadvantages; ?>

                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>


              </div>

              <div id="class_selector" class="flex-grid">

                <div id="class-menu" class="small full <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">
                  <p><span class="custom-dropdown custom-dropdown--red">
                    <select id="class-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red">
                    <option>Select a class</option>
                      <?php
                      foreach ($classes as $class) { ?>
                        <?php $class_string = ($class->frag_cost > 0) ? $class->name . " (" . $class->frag_cost . " FRAGS)" : $class->name; ?>
                        <option value="<?php echo $class->name; ?>"><?php echo $class_string ?></option>
                      <?php } ?>
                    </select>
                  </span></p>
                </div>

                <div id="class-content" class="small full">
                  <?php foreach ($classes as $pc_class) { ?>
                    <div class="class content repeater-content" data-name="<?php echo $pc_class->name; ?>">
                      <h2><?php echo $pc_class->name; ?></h2>

                      <div class="flex-grid repeater-flex-grid">
                        <div class="small-1of3 column class_meta">

                          <img src="<?php echo $pc_class->photo ?>" class="img-responsive builder_photo" alt="<?php echo $pc_class->name ?>" title="<?php echo $pc_class->name ?>"/>

                        </div>
                        <div class="small-1of3 column class_info">

                          <h4>Descriptipn</h4>
                          <?php echo $pc_class->description; ?>


                          <div class="blog-post text-center" style="margin-bottom:3rem;">
                            <a id="select_class" href="#" title="Select Class" data-class="<?php echo $pc_class->name; ?>" data-frag_cost="<?php echo $pc_class->frag_cost; ?>" data-cost-ele="<?php echo strtolower(substr($pc_class->name, 0, 3)); ?>_cost" class="builder_selector blog-post-button locked">Select <?php echo $pc_class->name; ?></a>
                          </div>

                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>

            </div>

          </div>
        </div>

        <div id="details_section" class="flex-grid">
          <div class="small-1of3">

            <div id="character_data">

              <div class="flex-grid">
                <div class="small-1of3 non_data_fields">
                  <div class="btn_warning text-center mandatory_section" style="margin-bottom:3rem;">
                    <a id="btn_reset" href="#" title="Reset" class="blog-post-button"><i class="fa fa-trash" aria-hidden="true"></i> Reset</a>
                  </div>
                </div>
                <div class="small-1of3 non_data_fields">
                  <div class="btn_warning text-center mandatory_section" style="margin-bottom:3rem;">
                    <a id="btn_undo" href="#" title="Undo" class="blog-post-button locked"><i class="fa fa-undo" aria-hidden="true"></i> Undo</a>
                  </div>
                </div>
                <div class="small-1of3 non_data_fields advanced_element">
                  <div class="btn_warning text-center mandatory_section" style="margin-bottom:3rem;">
                    <a id="btn_data_export" href="#" title="Export" class="blog-post-button"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</a>
                  </div>
                </div>

                <div class="small full non_data_fields">

                  <button id="btn_add_blanket" class="btn btn-red mandatory_section" style="margin: 2rem 0;">
                    Add Blanket of XP (+<span id="blanket_val">65</span>CP)
                  </button>
                </div>
              </div>


              <div id="character_section" class="mandatory_section non_data_fields">

                <div class="flex-grid">
                  <div class="small-1of2">
                    <button id="btn_view_char" class="btn-cb-content btn btn-red active" data-tab="Character">
                      Character
                    </button>
                  </div>
                  <div class="small-1of2">
                    <button id="btn_view_skills" class="btn-cb-content btn btn-red" data-tab="Skills">
                      Skills
                    </button>
                  </div>
                </div>
                <br/>
                <div class="flex-grid">
                  <div class="small-1of2">
                    <button id="btn_view_armour" class="btn-cb-content btn btn-red" data-tab="Armour">
                      Armour
                    </button>
                  </div>
                  <div class="small-1of2">
                    <button id="btn_view_spellbook" class="btn btn-red">
                      Spellbook
                    </button>
                  </div>
                </div>
                <hr />
                <div class="cb_data">
                  <div id="cb_character_details" class="cb_display_content active" data-tab="Character">
                    <h4>Race: <span id="cb_race_show"></span></h4>
                    <h4>Class: <span id="cb_class_show"></span></h4>
                    <h4 id="char_vocation">Vocation: <span id="cb_vocation_show"></span></h4>
                    <h4>Level: <span id="cb_level"></span></h4>
                    <h4>CP Spent: <span id="cb_cp_spent"></span></h4>
                    <h4>CP Available: <span id="cb_cp_avail"></span></h4>
                    <h4>CP Applied per Blanket: <span id="cb_blanket_next"></span></h4>
                    <h4>Blankets Spent: <span id="cb_blankets_spent"></span></h4>
                    <h4>Frags Spent: <span id="cb_frags_spent"></span></h4>
                    <h4>Body Points: <span id="cb_bp"></span></h4>
                    <h4>Skills: <span id="cb_skill_count">0</span></h4>
                    <h4>Strength: <span id="cb_strength">0</span></h4>
                  </div>

                  <div id="cb_skill_details" class="cb_display_content" data-tab="Skills">
                    <div id="suggested_skills">

                        <h4>Suggested Skills</h4>
                        <p>Coming soon-ish! You'll be able to get suggestions on what skill to purchase next.</p>
                        <p>Consider donating to my <a href="https://www.patreon.com/EricLortie" target="_blank">Patreon page</a> to further motivate me.</p>

                        <p class="fb_login_placeholder" style="padding-top: 9px;"><img src="<?php echo get_template_directory_uri(); ?>/inc/loading_spinner.gif" style="height:20px;"/> Loading</p>
                        <div class="fb-login-button" data-max-flex-grids="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>

                    </div>

                    <hr/>
                    <h4>Purchased Skills</h4>
                    <div id="cb_skills"></div>

                  </div>

                  <div id="cb_armour_details" class="cb_display_content"  data-tab="Armour">

                    <ul>
                      <li>Total Armour Points: <span id="armour_points">0</span></li>
                      <li>Total Armour Pieces: <span id="armour_count">0</span></li>
                      <li>Heavy Armour: <span id="heavy_armour_flag">No</span></li>
                    </ul>
                    <?php
                      $a_slots = [
                        "Upper Skull",
                        "Eyes",
                        "Lower Face/Jaw",
                        "Throat",
                        "Right Pectoral",
                        "Left Pectoral",
                        "Right Ribs",
                        "Left Ribs",
                        "Right Abdomen",
                        "Left Abdomen",
                        "Groin",
                        "Right Shoulder",
                        "Left Shoulder",
                        "Right Forearm",
                        "Left Forearm",
                        "Right Hand",
                        "Left Hand",
                        "Right Thigh",
                        "Left Thigh",
                        "Right Calf",
                        "Left Calf",
                        "Right Foot",
                        "Left Foot",
                        "Back of Neck",
                        "Upper Back",
                        "Mid Back",
                        "Lower Back",
                        "Gluteus"
                      ];
                      for($i=0; $i<=count($a_slots)-1; $i++){
                        $slot = $i+1;
                    ?>
                      <div id="armour_<?php echo $slot; ?>" val1="0" val2="0" class="armour_slot">
                        <div class="flex-grid">
                          <div class="small-2of12">
                            <?php echo $slot; ?>
                          </div>
                          <div class="small-5of12">
                            <?php echo $a_slots[$i]; ?>
                          </div>
                          <div class="small-3of12">
                            <span id="ap_val_<?php echo $slot; ?>">0</span> pts
                          </div>
                          <div class="small-2of12">
                            <i class="fa fa-toggle-down expand_armour" armour="<?php echo $slot; ?>" aria-hidden="true"></i>
                            <i class="fa fa-toggle-up close_armour hidden" armour="<?php echo $slot; ?>" aria-hidden="true"></i>
                          </div>
                        </div>
                        <div class="flex-grid armour_slot_data armour_slot_data_1">
                          <div class="small-2of12">
                            <span id="armour_<?php echo $slot; ?>_val_1">0</span> pts
                          </div>
                          <div class="small-8of12">
                            <span id="armour_<?php echo $slot; ?>_desc_1">No Armour</span>
                          </div>
                          <div class="small-2of12">
                            <i class="fa fa-plus-square armour_toggle show_armour_modal" slot="<?php echo $slot; ?>" level="1" aria-hidden="true"></i>
                          </div>
                        </div>
                        <div class="flex-grid armour_slot_data armour_slot_data_2 locked">
                          <div class="small-2of12">
                            <span id="armour_<?php echo $slot; ?>_val_2">0</span> pts
                          </div>
                          <div class="small-8of12">
                            <span id="armour_<?php echo $slot; ?>_desc_2">No Armour</span>
                          </div>
                          <div class="small-2of12 action_buttons">
                            <i class="fa fa-plus-square armour_toggle show_armour_modal" slot="<?php echo $slot; ?>" level="2" aria-hidden="true"></i>
                          </div>
                        </div>
                      </div>
                    <?php }?>
                  </div>

                </div>
              </div>
            </div><!-- /#character_data -->

            </div>

          <div class="small-1of3" style="padding:0 4rem;">
            <div id="skills_section" class="mandatory_section">
              <div id="skill_header" class="flex-grid">

              <div class="flex-grid">
                <div id="legend" class="small full closed" style="">
                  <p class="skill_meta">
                    <a href="#" id="legend_close" class="legend_toggler"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; close icon legend</a>
                    <a href="#" id="legend_open" class="legend_toggler"><i class="fa fa-circle-o" aria-hidden="true"></i>&nbsp; open icon legend</a>
                  </p>
                  <div id="legend_content" class="flex-grid">
                  <?php
                    $legend_items = array(
                      array('shield', 'Warrior Skill'),
                      array('bomb', 'Rogue Skill'),
                      array('magic', 'Scholar Skill'),
                      array('cog', 'Production Skill'),
                      array('users', 'Racial Skill'),
                      array('universal-access', 'Class Skill'),
                      array('diamond', 'Frag Skill'),
                      array('exclamation-triangle', 'Requirement Not Met'),
                      array('info-circle', "Click to view details")
                    );
                   ?>
                   <?php foreach ($legend_items as $li){ ?>
                      <div class="small-1of3">
                        <div class="small-2of12 text-center">
                          <i class="fa fa-<?php echo $li[0]?>" aria-hidden="true"></i>
                        </div>
                        <div class="small full20 text-left">
                          <?php echo $li[1]; ?>
                        </div>
                      </div>
                    <?php } ?>
                  </div></div>
              </div>

                <div class="small-1of2 text-center" style="display:none;">
                  <h4>Filter</h4>
                  <div class="flex-grid">
                    <div class="small-2of12">
                      <button id="btn_warrior" title="Warrior Skills" data-cat="W" data-cat-string="Warrior" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-shield" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-2of12">
                      <button id="btn_rogue" title="Rogue Skills" data-cat="R" data-cat-string="Rogue" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-bomb" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-2of12">
                      <button id="btn_scholar" title="Scholar Skills" data-cat="S" data-cat-string="Scholar" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-magic" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-2of12">
                      <button id="btn_production" title="Production Skills" data-cat="P" data-cat-string="Production" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-2of12">
                      <button id="btn_racial" title="Racial Skills" data-cat="A"  data-cat-string="Racial" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-users" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-2of12">
                      <button id="btn_class" title="Class Skills" data-cat="C" data-cat-string="Class" class="skill_menu btn-cat btn btn-skill">
                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="small-3of12 small-1of2 text-center" style="display:none;">
                  <h4>Toggle</h4>
                  <div class="flex-grid">
                    <div class="small-1of2">
                      <button id="btn_toggle_skills" title="Toggle Available Skills" class="skill_menu btn btn-skill">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </button>
                    </div>
                    <div class="small-1of2">
                      <button id="btn_frag" title="Frag Skills" class="skill_menu btn btn-skill">
                        <i class="fa fa-diamond" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="small-1of3 small-1of2 text-center">
                </div>
                <div class="small-1of3 small-1of2 text-center">
                  <h4>Sort</h4>
                  <div class="flex-grid">
                    <div class="small-1of2">
                      <button id="btn_sort_cost" title="Sort by Cost" class="skill_menu btn-sort btn btn-skill">#</button>
                    </div>
                    <div class="small-1of2">
                      <button id="btn_sort_name" title="Sort by Name" class="skill_menu btn-sort btn btn-skill active">A-Z</button>
                    </div>
                  </div>
                </div>
              </div>

              <div id="skill_header" class="flex-grid" style="display:none;">
                <p id="option_string">Showing <span id="filter_string" class="opt">ALL</span> <span id="cat_string" class="opt"></span> skills, sorted by <span id="sort_string" class="opt">NAME</span>.&nbsp;
                <i id="opt-clear" class="fa fa-close" aria-hidden="true"></i></p>
              </div>
              <div id="skill_list" class="flex-grid">

              </div>
            </div>
          </div>

          </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinysort/2.3.6/tinysort.js"></script>

        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        <script type="text/javascript" src="<?php site_url(); ?>/wp-content/themes/illdy/layout/js/character-builder.js"></script>

			</section><!--/#blog-->
		</div><!--/.col-small-7-->
	</div><!--/.flex-grid-->
</div><!--/.container-->

<div id="blog">

    <div id="occupation_selector" class="flex-grid">

      <div id="occupation-menu" class="small full <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">
        <p><span class="custom-dropdown custom-dropdown--red">
          <select id="occupation-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red">
          <option>Select a Renowned Occupation</option>
            <?php foreach ($occupations as $class) { ?>
              <?php $class_string = ($class->frag_cost > 0) ? $class->name . " (" . $class->frag_cost . " FRAGS)" : $class->name; ?>
              <option value="<?php echo $class->name; ?>"><?php echo $class_string ?></option>
            <?php } ?>
          </select>
        </span></p>
      </div>

      <div id="occupation-content" class="small full">
        <?php foreach ($occupations as $pc_class) { ?>
          <div class="occupation content repeater-content" data-name="<?php echo $pc_class->name; ?>">
            <h2><?php echo $pc_class->name; ?></h2>

            <div class="flex-grid repeater-flex-grid">
              <div class="small-1of3 column class_meta">

                <img src="<?php echo $pc_class->photo ?>" class="img-responsive builder_photo" alt="<?php echo $pc_class->name ?>" title="<?php echo $pc_class->name ?>"/>

              </div>
              <div class="small-1of3 column class_info">

                <h4>Descriptipn</h4>
                <?php echo $pc_class->description; ?>


                <div class="blog-post text-center" style="margin-bottom:3rem;">
                  <a id="select_occupation" href="#" title="Select Class" data-class="<?php echo $pc_class->name; ?>" data-frag_cost="<?php echo $pc_class->frag_cost; ?>" data-cost-ele="<?php echo strtolower(substr($pc_class->name, 0, 3)); ?>_cost" class="builder_selector occupation blog-post-button locked">Select <?php echo $pc_class->name; ?></a>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>
      </div>

    </div>
    <div id="vocation_selector" class="flex-grid">

      <div id="vocation-menu" class="small full <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?>">
        <p><span class="custom-dropdown custom-dropdown--red">
          <select id="vocation-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red">
          <option>Select a Vocation</option>
            <?php foreach ($vocations as $class) { ?>
              <?php $class_string = ($class->frag_cost > 0) ? $class->name . " (" . $class->frag_cost . " FRAGS)" : $class->name; ?>
              <option value="<?php echo $class->name; ?>"><?php echo $class_string ?></option>
            <?php } ?>
          </select>
        </span></p>
      </div>

      <div id="occupation-content" class="small full">
        <?php foreach ($vocations as $pc_class) { ?>
          <div class="vocation content repeater-content" data-name="<?php echo $pc_class->name; ?>">
            <h2><?php echo $pc_class->name; ?></h2>

            <div class="flex-grid repeater-flex-grid">
              <div class="small-1of3 column class_meta">

                <img src="<?php echo $pc_class->photo ?>" class="img-responsive builder_photo" alt="<?php echo $pc_class->name ?>" title="<?php echo $pc_class->name ?>"/>

              </div>
              <div class="small-1of3 column class_info">

                <h4>Descriptipn</h4>
                <?php echo $pc_class->description; ?>


                <div class="blog-post text-center" style="margin-bottom:3rem;">
                  <a id="select_vocation" href="#" title="Select Class" data-class="<?php echo $pc_class->name; ?>" data-frag_cost="0" data-cost-ele="<?php echo strtolower(substr($pc_class->name, 0, 3)); ?>_cost" class="builder_selector vocation blog-post-button locked">Select <?php echo $pc_class->name; ?></a>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>
      </div>

    </div>



<?php
get_footer();

?>

<div class="modal fade builder_modal" id="spellbook_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Spellbook</h4>
          <p>As you purchase spell spheres and spell circles these slots will unlock.
            You'll be able to add appropriate spells to them for reference during games.</p>
        </div>
        <div class="modal-body">

        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#Friday" aria-controls="Friday" role="tab" data-toggle="tab">Friday</a></li>
          <li role="presentation"><a href="#Saturday" aria-controls="Saturday" role="tab" data-toggle="tab">Saturday</a></li>
          <li role="presentation"><a href="#Sunday" aria-controls="Sunday" role="tab" data-toggle="tab">Sunday</a></li>
        </ul>
        <div class="tab-content">
          <?php for ($day=1;$day<=3;$day++){ ?>
            <?php if($day == 1){
              $label = "Friday";
            } else if ($day == 2){
                $label = "Saturday";
            } else {
              $label = "Sunday";
            }
            ?>
            <div role="tabpanel" id="<?php echo $label;?>" class="<?php if($day == 1) { echo 'active'; } ?> tab-pane fade in">
              <div class="flex-grid spell_circle disabled elf_only" circle="elf">
                <div class="small full2">
                  <label class="elf-circle">High Elf</label>
                </div>
                <div class="small-2of12">
                  <div class="spell_slot" circle="elf" slot="<?php echo $slot; ?>" day="<?php echo $day; ?>">
                    <p class="spell_name" circle="elf" slot="<?php echo $slot; ?>" day="<?php echo $day; ?>">No spell selected.</p>
                    <p class="change_spell">Change</p>
                  </div>
                </div>
              </div>

              <?php for ($circle=9;$circle>=1;$circle--){ ?>
                <div class="flex-grid spell_circle disabled" circle="<?php echo $circle; ?>">
                  <div class="small full2">
                    <label circle="<?php echo $circle;?>"><?php echo $circle;?></label>
                  </div>
                  <?php for ($slot=1;$slot<=5;$slot++){ ?>
                    <div class="small-2of12">
                      <div class="spell_slot disabled" circle="<?php echo $circle; ?>" slot="<?php echo $slot; ?>" day="<?php echo $day; ?>">
                        <p class="spell_name" circle="<?php echo $circle; ?>" slot="<?php echo $slot; ?>" day="<?php echo $day; ?>">No spell selected.</p>
                        <p class="change_spell">Change</p>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>


        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade builder_modal" id="spell_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Spell</h4>
      </div>
      <div class="modal-body">
        <div id="spell_list" class="flex-grid">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="spell_selector_close" class="btn">Return To Spellbook</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade builder_modal" id="armour_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Armour</h4>
      </div>
      <div class="modal-body">
        <div class="flex-grid">
          <div class="small full">
            Type:<br/>
            <select id="armour_type">
              <?php foreach([[0, "No Armour"], [1, 'Leather'],[2, 'Boiled/Studded Leather'],[3, 'Chain/Scale'],[4, 'Plate']] as $a) { ?>
                <option value="<?php echo $a[0];?>" type="<?php echo $a[1];?>"><?php echo $a[1];?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="flex-grid">
          <div class="small full">
            Penalty:<br/>
            <select id="armour_penalty">
              <option value="0">0</option>
              <option value="0.5">0.5</option>
              <option value="1">1</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="armour_add" class="btn" slot="" level="" old-ap="">Add To Slot</button>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
