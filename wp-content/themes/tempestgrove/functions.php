<?php

/* ************************************************************************ **
** Global Definitions                                                       **
** ************************************************************************ */

define('ASSET_VERSION', '0.1.0');
define('ASSETS_DIR', get_template_directory_uri() . '/assets/');


/* ************************************************************************ **
** Include Additional Files                                                 **
** ************************************************************************ */

// Navigation Menu
require_once('includes/menus.php');


/* ************************************************************************ **
** Enqueue Files & Register WP Options                                      **
** ************************************************************************ */

// Javascripts
add_action('wp_enqueue_scripts', 'add_javascripts');
function add_javascripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('modernizr',  ASSETS_DIR . 'vendor/modernizr.js#async',                               array(), ASSET_VERSION, 0);
    wp_enqueue_script('lazyload',   ASSETS_DIR . 'vendor/lazyload.min.js#async',                            array(), ASSET_VERSION, 1);
    wp_enqueue_script('matchmedia', ASSETS_DIR . 'vendor/matchMedia.js#async',                              array(), ASSET_VERSION, 1);
    // wp_enqueue_script('particles',  ASSETS_DIR . 'vendor/particles.min.js#async',                           array(), ASSET_VERSION, 1);
    wp_enqueue_script('core',       ASSETS_DIR . 'js/core.js#async',                                        array(), ASSET_VERSION, 1);
    wp_enqueue_script('content',    ASSETS_DIR . 'js/components/content/content.js#async',                  array(), ASSET_VERSION, 1);
    wp_enqueue_script('navigation', ASSETS_DIR . 'js/components/navigation/navigation-sidebar.js#defer',    array(), ASSET_VERSION, 1);
}

// Add ACF Options Page
if(function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Sitewide Options',
        'menu_title'    => 'Options'
    ));
}

// Register Additional Image Sizes
add_image_size('1920w', 1920, 0);
add_image_size('600w', 600, 0);
add_image_size('200x150', 200, 150, true);

// Unregister Default WP Taxonomies
add_action('init', 'unregister_taxonomies');
function unregister_taxonomies(){
    register_taxonomy('post_tag', array());
    register_taxonomy('category', array());
}

// Unregister Default 'Post' Post Type
add_filter('register_post_type_args', 'unregister_default_posts', 0, 2);
function unregister_default_posts($args, $postType){
    if ($postType === 'post') {
        $args['capabilities'] = [
            'edit_post' => false,
            'read_post' => false,
            'delete_post' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'read' => false,
            'delete_posts' => false,
            'delete_private_posts' => false,
            'delete_published_posts' => false,
            'delete_others_posts' => false,
            'edit_private_posts' => false,
            'edit_published_posts' => false,
            'create_posts' => false,
        ];
    }
    return $args;
}


/* ************************************************************************ **
** Helper Functions                                                         **
** ************************************************************************ */

// Pretty Print for Debugging
function pre($a) { echo '<pre>'; print_r($a); echo '</pre>'; }

// Defer or Asynchronously Load Scripts
add_filter('script_loader_tag', 'js_defer_async_attr', 10);
function js_defer_async_attr($url){
    if(!is_admin()){
        if(strpos($url, '#async') !== false){
            return str_replace(' src', ' async src', $url);
        }elseif(strpos($url, '#defer') !== false){
            return str_replace(' src', ' defer src', $url);
        }
    }
    return $url;
}


/* ************************************************************************ **
** WP Smarty                                                                **
** ************************************************************************ */

function wp_smarty(){
    global $wp_smarty;
    if($wp_smarty)
        return $wp_smarty;

    $wp_smarty = smarty_get_instance();
    $wp_smarty->assign('assets_dir', ASSETS_DIR);

    // Load Sidebar Menu
    assign_menus($wp_smarty);

    // Load Current Year
    $wp_smarty->assign('year', date('Y'));

    // Load Site Options
    $wp_smarty->assign('options', get_fields('option'));

    // Load Breadcrumbs
    if(function_exists('bcn_display')){
        $wp_smarty->assign('breadcrumbs', do_shortcode(bcn_display(true)));
    }

    return $wp_smarty;
}


/* ************************************************************************ **
** Theme Specific Functions                                                 **
** ************************************************************************ */

// Not applicable for this project


/* ************************************************************************ **
** Theme Specific Ajax Functions                                            **
** ************************************************************************ */

// Not applicable for this project


/* ************************************************************************ **
** WP Admin Cleanup                                                         **
** ************************************************************************ */

add_action('admin_menu', 'cleanup_admin_menu', 9999);
function cleanup_admin_menu(){
    if(!current_user_can('administrator')){
        global $menu;
        foreach($menu as $k=>$v){
            if($v[0] == 'Appearance'){
                $menu[$k][0] = 'Menus';
                $menu[$k][2] = 'nav-menus.php';
            }
        }
        remove_menu_page('edit-comments.php');
        remove_menu_page('tools.php');
        remove_menu_page('threewp-broadcast');
        return $menu;
    }
}

add_action('wp_before_admin_bar_render', 'modify_admin_bar');
function modify_admin_bar(){
    if(!current_user_can('administrator')){
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('comments');
    }
}


add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
function remove_dashboard_widgets(){
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

add_action('login_enqueue_scripts', 'edit_login_logo');
function edit_login_logo(){
    echo '<style type="text/css">.login h1 a, #login h1 a { background: url('. ASSETS_DIR .'img/logo--black.png) 50% 50% no-repeat !important; background-size: contain !important; height: 6rem; width: 100%;}</style>';
}

add_filter('login_headerurl', 'change_login_url');
function change_login_url() {
    return get_bloginfo('url');
}

add_filter('login_headertitle', 'change_login_title');
function change_login_title(){
    return get_bloginfo('name');
}


function generate_og_tags() {
    global $post;

    $og_tags = array(
        'site_name'         => get_bloginfo('name'),
        'title'             => $post->post_title,
        'url'               => get_permalink($post->ID),
        'description'       => wp_trim_words(wp_strip_all_tags($post->post_content), 40, ''),
        'image'             => ASSETS_DIR . 'img/social-logo.jpg',
        'type'              => 'article'
    );

    $featured_image = get_field('featured_image', $post->ID);
    $header_image = get_field('header_background', $post->ID);
    if($featured_image){
        $og_tags['image'] = $featured_image['sizes']['650x650'];
    }elseif($header_image){
        $og_tags['image'] = $header_image['sizes']['650x650'];
    }

    if(!$post->post_content){
        $og_tags['description'] = 'Tempest Grove: Live Action Roleplay in Cape Breton, Nova Scotia. An amazing adventure as part of the Underworld LARP franchise.';
    }

    if(is_home() || is_front_page()){
        $og_tags['title'] = get_bloginfo('name');
    }

    return $og_tags;
}


 function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

// Gets and structures a list of current alerts
function get_characters($count = -1){
    $today = date('Ymd');
    $args = array(
        'post_type' => 'characters',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'rand'
    );
    $posts = [];
    $posts_1 = array();
    $posts_2 = array();
    $posts_query = new WP_Query($args);
    while($posts_query->have_posts()){
        $posts_query->the_post();
        global $post;
        $post->thumbnail_url = get_the_post_thumbnail_url($post->ID);
        $post->permalink = get_the_permalink($post->ID);
        $post->fields = get_fields($post->ID);
        if($post->fields['player']){
          um_fetch_user($post->fields['player']['ID']);
          $post->profile_url = um_user_profile_url();
        }
        if($post->post_excerpt == ""){
          $posts_2[] = $post;
        } else {
          $posts_1[] = $post;
        }
    }
    if($count == -1){
      $posts = array_merge($posts_1, $posts_2);
    } else {
      $posts = array_slice($posts_1, 0, 4);
    }
    wp_reset_query();
    return $posts;
}


function build_skill_row($post, $s_count, $skill_type) {
	$s_count++;
	$name = get_sub_field('name');
	if (strpos($name, 'Subsequent') === false && $name != "Spell Versatility") {

			$description = get_sub_field('description');
			$category = get_sub_field('category');

			if($skill_type == "spell_sphere"){
				$name = "Spell Sphere: " . $name;
				$category = "Spell Sphere";
			}

      $cat_icon = "fa-diamond";
			if($category == "Warrior"){
				$cat_icon = "fa-shield";
			} else if ($category == "Rogue"){
				$cat_icon = "fa-bomb";
			} else if ($category == "Scholar"){
				$cat_icon = "fa-magic";
			} else if ($category == "Production"){
				$cat_icon = "fa-cog";
			} else if ($category == "Racial Ability"){
				$category = "Abilities (Racial)";
				$cat_icon = "fa-users";
			} else if ($category == "Class Ability"){
				$cat_icon = "fa-universal-access";
			}

			$cat =  substr($category, 0, 1);
			$focus = get_sub_field('focus');

			$frag_cost = get_sub_field('frag_cost');

			$optional_fields = get_sub_field('optional_fields');
			$mercenary_cost = get_sub_field('mercenary_cost');
			$ranger_cost = get_sub_field('ranger_cost');
			$templar_cost = get_sub_field('templar_cost');
			$nightblade_cost = get_sub_field('nightblade_cost');
			$assassin_cost = get_sub_field('assassin_cost');
			$witchhunter_cost = get_sub_field('witchblade_cost');
			$mage_cost = get_sub_field('mage_cost');
			$druid_cost = get_sub_field('druid_cost');
			$bard_cost = get_sub_field('bard_cost');
			$demagogue_cost = get_sub_field('demagogue_cost');
			$champion_cost = get_sub_field('champion_cost');
			$demagogue_cost = get_sub_field('demagogue_cost');
			$champion_cost = get_sub_field('champion_cost');

			$race = get_sub_field('race');

			$pc_class = get_sub_field('class');
			$pc_class_string = str_replace(" ", "", $pc_class);
			$class_level = get_sub_field('level');

			$optional = get_sub_field('optional_fields');

			$sphere_class = '';
			$btn_class = '';
			$btn_id = 'skill_'+$s_count;
			$spells = get_sub_field('spells');
			if($skill_type == "spell_sphere"){
				$btn_class = 'spell_sphere_add';
				$btn_id = 'sphere_' + $s_count;
				$sphere_class = 'spell_sphere';
				$prereq = 'Read Magic';
				$cat_icon = "fa-magic";
			} else {
				$prereq = get_sub_field('prerequesites');
			}

			preg_match('/(?:Max: ([1-9]))/', $prereq, $max);
			if(count($max)>0){
				$max = $max[1];
				$prereq = "";
			} else {
				$max = "";
			}

			if($name == "Mysticism"){
				$max = 10;
			} else if($name == "Physician"){
				$max = 10;
			}

			$multiple = false;
			if ( $optional && in_array('multiple', $optional) ) {
				$multiple = true;
			}
			$automatic = false;
			if ( $optional && in_array('automatic', $optional) ) {
				$automatic = true;
			}
			$vocation_ability = false;
			if ( $optional && in_array('vocation', $optional) ) {
				return "";
				$vocation_ability = true;
			}

      $level = get_sub_field('level');
      $level_cost = 0;
      if($level == 3){
        $level_cost = 30;
      } else if ($level == 6) {
        $level_cost = 60;
      } else if ($level == 9) {
        $level_cost = 90;
      } else if($level == 12){
        $level_cost = 120;
      }

			?>

			<script type="text/javascript">
				jQuery(document).on('ready', function(){
					var skill_type = '<?php echo $skill_type; ?>';
					var skill_row = jQuery(`<div class="flex-grid skill_row <?php echo $sphere_class; ?> <?php echo $cat; ?> <?php echo $pc_class_string; ?>" skill-name="<?php echo $name; ?>"><div class="small full skill" style=""></div></div>`);
					var skill_ele = skill_row.find('.skill');
					skill_ele.append(`
						<div class="flex-grid">
							<div class="small-1of12">
								<i id="<?php echo $btn_class; ?>" class="fa fa-plus-square skill_add <?php echo $btn_class; ?> <?php echo (($automatic) ? "automatic_skill" : "" ) ?> <?php echo (($name == "Favoured") ? "favoured" : ""); ?>" aria-hidden="true"></i>
								<i class="fa fa-check-square-o skill_purchased" aria-hidden="true"></i>
							</div>
							<div class="small-9of12">
								<span class="cat_label"><i class="fa <?php echo $cat_icon; ?>" aria-hidden="true"></i></span>&nbsp;
								<span class="name">
								<?php if($skill_type == "frag skill"){ ?>
									<span class="frag_cost"><?php echo $name; ?> (<?php echo $frag_cost; ?>&nbsp;<i class=" fa fa-diamond" aria-hidden="true"></i>)</span> </span>
								<?php } else { ?>
									<?php echo $name; ?>
								<?php } ?>
								</span>
								&nbsp; <i class="fa fa-info-circle skill_expander" aria-hidden="true"></i>
								<?php if($prereq != ""){ ?>
									&nbsp; <i class="fa fa-exclamation-triangle skill_req skill_expander" aria-hidden="true"></i>
								<?php } ?>
								&nbsp;
							</div>
							<div class="small-1of12">
								<?php if($automatic) { ?>
									<span class="racial_cost skill_cost">0</span>
									<span class="cost" style="display:none">0</span>
								<?php } else if ($skill_type == "race_skill") { ?>
									<span class="racial_cost skill_cost">50</span>
									<span class="cost" style="display:none">50</span>
								<?php } else if ($level_cost != 0) { ?>
									<span class="level_cost skill_cost"><?php echo $level_cost ?></span>
									<span class="cost" style="display:none"><?php echo $level_cost ?></span>
								<?php } else { ?>
									<div class="cost_strings">
										<span class="mer_cost skill_cost"><?php echo $mercenary_cost ?></span>
										<span class="ran_cost skill_cost"><?php echo $ranger_cost ?></span>
										<span class="tem_cost skill_cost"><?php echo $templar_cost ?></span>
										<span class="nig_cost skill_cost"><?php echo $nightblade_cost ?></span>
										<span class="ass_cost skill_cost"><?php echo $assassin_cost ?></span>
										<span class="wit_cost skill_cost"><?php echo $witchhunter_cost ?></span>
										<span class="mag_cost skill_cost"><?php echo $mage_cost ?></span>
										<span class="dru_cost skill_cost"><?php echo $druid_cost ?></span>
										<span class="bar_cost skill_cost"><?php echo $bard_cost ?></span>
										<span class="dem_cost skill_cost"><?php echo $demagogue_cost ?></span>
										<span class="cha_cost skill_cost"><?php echo $champion_cost ?></span>
									</div>
									<span class="sphere_cost skill_cost"></span>
									<span class="cost" style="display:none"></span>
								<?php } ?>
							</div>
						</div>
						<div class="flex-grid">
							<div class="small full skill_desc" style="display:none;">
								<?php if ($prereq != "") { ?>
									<p><i class="fa fa-exclamation-triangle skill_req" aria-hidden="true"></i>&nbsp; Requirements: <?php echo $prereq; ?></p>
								<?php } ?>
								<?php if ($focus != "") { ?>
									<p><i class="fa fa-exclamation-triangle skill_req" aria-hidden="true"></i>&nbsp; Focus: <?php echo $focus; ?></p>
								<?php } ?>
								<?php if ($automatic != "") { ?>
									<p>Automatic: Yes</p>
								<?php } ?>
								<?php if ($frag_cost != "") { ?>
									<p>Frag Cost: <?php echo $frag_cost; ?></p>
								<?php } ?>
								<p>Multiple Purchases: <?php echo (($multiple) ? "Yes" : "No"); ?></p>
								<?php echo $description; ?>
								<hr />
								<p class="skill_meta"><a href="#" class="skill_closer"><i class="fa fa-times" aria-hidden="true"></i>&nbsp; close</a></p>
							</div>
						</div>
					`);

					var row_id = "row_" + Math.floor((Math.random() * 10000) + 1);
					skill_row.attr('id', row_id)


          skill_row.data('racial_skill', false);
					skill_row.data('class_skill', false);

					if(skill_type == "spell_sphere"){

						skill_row.data('category', `S`)
						skill_row.data('cat_string', `Scholar`)
          	skill_row.data('type', `spell sphere`);
						skill_row.data('spell_sphere', true);
						skill_row.find('.cost_strings').remove();

            builder_data.spell_spheres.push({
              name: `<?php echo $name ?>`,
              focus: `<?php echo $focus ?>`,
              spells: `<?php echo $spells ?>`,
              description: `<?php echo $description ?>`,
              frag_cost: `<?php echo $frag_cost ?>`
            });

					} else if(skill_type == "race_skill"){

            skill_row.data('racial_skill', true);
            skill_row.data('automatic', `<?php echo $automatic;?>`);
            skill_row.data('cost', 50)
						skill_row.find('.sphere_cost').remove();

					} else if(skill_type == "class_skill") {

            skill_row.data('class_level', `<?php echo $class_level;?>`);
            skill_row.data('class_skill', true);
            skill_row.data('vocation_skill', `<?php echo $vocation_ability; ?>`)
						skill_row.find('.sphere_cost').remove();

					} else {

						skill_row.data('type', `<?php echo $skill_type; ?>`);
						skill_row.find('.sphere_cost').remove();

					}

					skill_row.data('name', `<?php echo $name ?>`);
          skill_row.data('race', `<?php echo $race;?>`);
          skill_row.data('class', `<?php echo $pc_class;?>`);
					skill_row.data('cat_string', `<?php echo $category; ?>`)
					skill_row.data('frag_cost', `<?php echo $frag_cost; ?>`);
					skill_row.data('category', `<?php echo $cat; ?>`);
					skill_row.data('description', `<?php echo $description ?>`);
					skill_row.data('requirements', `<?php echo $prereq ?>`);
					skill_row.data('multiple', `<?php echo $multiple ?>`);
					skill_row.data('automatic', `<?php echo $automatic; ?>`);
					skill_row.data('max', <?php echo $max ?>);

					if(builder_data.circles.indexOf("<?php echo $name; ?>") >= 0){
						skill_row.data('spell_circle', true);
					}

					<?php if($prereq != ''){ ?>
						skill_row.addClass('has_req');
						skill_row.addClass('locked');
					<?php } ?>

					aliases = builder_data.skill_aliases["<?php echo $name; ?>"];
					if(typeof aliases !== 'undefined'){
						alias_rows = [];
						for (alias in aliases) {
							var alias_row = skill_row.clone(true);
							var row_id = "row_" + Math.floor((Math.random() * 10000) + 1);
							alias_row.attr('id', row_id)
							alias_row.data('name', aliases[alias]);
							alias_row.find('span.name').html(aliases[alias]);
							alias_row.appendTo("#skill_list");
						}
					} else {
						var name = "<?php echo $name?>";
						if(~name.indexOf("Circle")){
							var cost_string = `<span class="mer_cost skill_cost"><?php echo $mercenary_cost+10; ?></span>
							<span class="ran_cost skill_cost"><?php echo $ranger_cost+10; ?></span>
							<span class="tem_cost skill_cost"><?php echo $templar_cost+10; ?></span>
							<span class="nig_cost skill_cost"><?php echo $nightblade_cost+10; ?></span>
							<span class="ass_cost skill_cost"><?php echo $assassin_cost+10; ?></span>
							<span class="wit_cost skill_cost"><?php echo $witchhunter_cost+10; ?></span>
							<span class="mag_cost skill_cost"><?php echo $mage_cost+10; ?></span>
							<span class="dru_cost skill_cost"><?php echo $druid_cost+10; ?></span>
							<span class="bar_cost skill_cost"><?php echo $bard_cost+10; ?></span>
							<span class="dem_cost skill_cost"><?php echo $demagogue_cost+10; ?></span>
							<span class="cha_cost skill_cost"><?php echo $champion_cost+10; ?></span>`;

							var alias_row = skill_row.clone(true);
							var row_id = "row_" + Math.floor((Math.random() * 10000) + 1);
							alias_row.attr('id', row_id)
							alias_row.find('.cost_strings').html(cost_string);
							alias_row.data('name', "Spell Versatility: " + name);
							var name_string = "<span class='frag_cost'>"+"Spell Versatility: " + name+" ("+cost_string+"&nbsp;<i class='fa fa-diamond' aria-hidden='true'></i>)</span>"
							alias_row.find('span.name').html(name_string);
							alias_row.appendTo("#skill_list");
							alias_row.find('.row').addClass('frag_row');
							alias_row.data('requirements', name);
							alias_row.data('max', 5);
							alias_row.data('multiple', true);
							jQuery('#skill_list').append(alias_row);
						}
						jQuery('#skill_list').append(skill_row);
					}

				});
			</script>

	<?php
	}
}

function get_spells(){

  if( have_rows('spells', get_id_by_slug('codex-spells')) ):
    while( have_rows('spells', get_id_by_slug('codex-spells')) ): the_row();

       $spell = new stdClass();
       $spell->name = preg_replace('<type>', '[type]', get_sub_field('name'));
       $spell->sphere = get_sub_field('sphere');
       $spell->incant = preg_replace('<type>', '[type]', get_sub_field('incant'));
       $spell->level = get_sub_field('level');
       $spell->duration = get_sub_field('duration');
       $spell->desc = preg_replace('<type>', '[type]', get_sub_field('description'));

        if($spell_spheres[$spell->sphere] == null){
          $spell_spheres[$spell->sphere] = [];
        }
        if($spell_spheres[$spell->sphere][$spell->level] == null){
          $spell_spheres[$spell->sphere][$spell->level] = [];
        }
        array_push($spell_spheres[$spell->sphere][$spell->level], $spell);


     endwhile;
   endif;

   if( have_rows('spells', get_id_by_slug('codex-frag-spells')) ):
     while( have_rows('spells', get_id_by_slug('codex-frag-spells')) ): the_row();

       $spell = new stdClass();
       $spell->name = preg_replace('<type>', '[type]', get_sub_field('name'));
       $spell->sphere = get_sub_field('sphere');
       $spell->incant = preg_replace('<type>', '[type]', get_sub_field('incant'));
       $spell->level = get_sub_field('level');
       $spell->duration = get_sub_field('duration');
       $spell->desc = preg_replace('<type>', '[type]', get_sub_field('description'));

        if($spell_spheres[$spell->sphere] == null){
          $spell_spheres[$spell->sphere] = [];
        }
        if($spell_spheres[$spell->sphere][$spell->level] == null){
          $spell_spheres[$spell->sphere][$spell->level] = [];
        }
        array_push($spell_spheres[$spell->sphere][$spell->level], $spell);


     endwhile;
   endif;

	 return $spell_spheres;

}
