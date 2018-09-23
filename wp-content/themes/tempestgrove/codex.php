

 <?php
 /**
  * Template Name: Codex
  *
  * @package WordPress
  * @subpackage Illdy
  * @since Illdy 1.0
  */

  // Add Page Javascripts
  add_action('wp_enqueue_scripts', 'add_page_javascripts');
  function add_page_javascripts(){
  	wp_enqueue_script('dialog',		ASSETS_DIR . 'js/components/dialog/dialog.js', 		array(), ASSET_VERSION, 1);
  }
 ?>
<?php get_header(); ?>
<div id="fb-root"></div>
<!-- Landing Banner -->
<section class="sub">
    <div class="container--xl text-center">
        <a href="/" class="landing-banner__logo-link">
            <img src="/wp-content/themes/tempestgrove/assets/img/logo--black.png" alt="" class="landing-banner__logo">
        </a>
				<?php
				if( have_posts() ):
					while( have_posts() ):
            $slug = get_post_field( 'post_name' );
						the_post();
            ?>

            <h1 class="landing-banner__title"><?php the_title();?></h1>

            <p><?php the_content(); ?></p>

            <?php
					endwhile;
				else:
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
    </div>
</section>

<div class="container--xl flex--row">

        <?php $races = array(); ?>
        <?php $classes = array(); ?>
        <?php $vocations = array(); ?>
        <?php $occupations = array(); ?>
        <br/>
        <script type="text/javascript">
          var builder_data = {};
          builder_data.character = {};
          builder_data.character.class = "";
          builder_data.character.race = "";
          builder_data.character.skills = {};
          builder_data.character.class_skills = {};
          builder_data.character.frags_avail = 0;
          builder_data.character.frags_spent = 0;
          builder_data.character.skill_count = 0;
          builder_data.races = [];
          builder_data.vocations = [];
          builder_data.occupations = [];
          builder_data.pc_classes = [];
          builder_data.spell_spheres = [];
          builder_data.character_states = [];
          builder_data.skills = [];
        </script>

        <?php if($slug == "codex-spells" || $slug == 'codex-frag-spells'): ?>

            <?php $spell_spheres = get_spells(); ?>

            <p><i class="fa fa-info-circle" aria-hidden="true" style="color: yellow;"></i> Click for spell details</p>

            <div id="spheres" class="flex-grid">
              <?php $count = 1; ?>
              <?php foreach ($spell_spheres as $sphere => $spells) {?>
                <div class="full med-1of3 lg-1of4">

                  <div class="builder-photo__block">
                      <div class="builder-photo__content">
                          <div class="builder-photo__content-inner sphere_col">
                            <table class="sphere" border="1">
                              <tr>
                                <th colspan="2" class="sphere_header"><label><?php echo $sphere; ?></label></th>
                              </tr>
                                <?php foreach($spells as $level){ ?>
                                  <tr>
                                    <?php foreach($level as $spell){ ?>
                                      <td class="spell_data">
                                        <?php echo $spell->name; ?>&nbsp<a href="#" class="dialog__trigger spell_expander" data-dialog="spell-details"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                        <?php if( $spell->desc == ""){ ?>
                                          <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red;"></i>
                                          <?php } ?>
                                        <div class="spell_info">
                                          <p><strong>Incant: <?php echo $spell->incant; ?></strong></p>
                                          <p>Duration: <?php echo $spell->duration; ?></p>
                                          <hr/>
                                          <p><?php echo $spell->desc; ?></p>
                                        </div>
                                      </td>
                                    <?php } ?>
                                  </tr>
                                <?php } ?>
                            </table>
                          </div>
                      </div>
                  </div>


                </div>
                <?php $count++; ?>
              <?php } ?>
            </div>

        <?php endif; ?>

        <?php if( have_rows('races') ): ?>
            <?php while( have_rows('races')): the_row(); ?>


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
        <?php endif; ?>

        <?php if( have_rows('classes') ): ?>
          <?php while( have_rows('classes')): the_row(); ?>

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
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('spell_spheres') ): ?>

          <?php $spell_spheres = get_spells(); ?>

          <div class="race-content switcher-content">

            <div id="cf-magic" class="cf-repeater">
              <div class="row repeater-content rf-hidden">
                <div class="lg-1of1 box">

                  <?php while( have_rows('spell_spheres') ): the_row(); ?>



                    <?php // vars
                    $name = get_sub_field('name');
                    $description = get_sub_field('description');
                    $focus = get_sub_field('focus');
                    $frag_cost = get_sub_field('frag_cost');
                    $spells = $spell_spheres[$name];

                    ?>

                    <div class="sphere-row flex-grid">

                      <div class="small-1of1 med-6of12 box">

                        <h1><?php echo $name; ?></h1>

                        <h5><i>Focus: <?php echo $focus; ?></i></h5>
                        <?php if ($frag_cost != "") { ?>
                          <h4><i>Frag Cost: <?php echo $frag_cost; ?></i></h4>
                        <?php } ?>

                        <?php echo $description; ?>

                      </div>

                      <div class="small-1of1 med-6of12 box">

                        <div class="builder-photo__block">
                            <div class="builder-photo__content">
                                <div class="builder-photo__content-inner">

                                  <table class="sphere" border="1">
                                    <?php foreach($spells as $level){ ?>
                                      <tr>
                                        <?php foreach($level as $spell){ ?>
                                          <td class="spell_data">
                                            <?php echo $spell->name; ?>&nbsp<i class="fa fa-info-circle spell_expander" aria-hidden="true"></i>
                                            <?php if( $spell->desc == ""){ ?>
                                              <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red;"></i>
                                              <?php } ?>
                                            <div class="spell_info">
                                              <p><strong>Incant: <?php echo $spell->incant; ?></strong></p>
                                              <p>Duration: <?php echo $spell->duration; ?></p>
                                              <hr/>
                                              <p><?php echo $spell->desc; ?></p>
                                            </div>
                                          </td>
                                        <?php } ?>
                                      </tr>
                                    <?php } ?>
                                  </table>
                                </div>
                              </div>
                            </div>

                      </div>
                    </div>

                    <script type="text/javascript">
                      builder_data.spell_spheres.push({
                        name: `<?php echo $name ?>`,
                        focus: `<?php echo $focus ?>`,
                        spells: `<?php echo $spells ?>`,
                        description: `<?php echo $description ?>`,
                        frag_cost: `<?php echo $frag_cost ?>`
                      });
                    </script>

                  <?php endwhile; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if( have_rows('skills') ): ?>
          <div class="container--xl skill-content switcher-content flex--row">

            <div class="lg-1of1 box">

              <div class="flex--row skill_header">
                <div class="small-1of4">
                  Name
                </div>
                <div class="small-1of12">
                  M
                </div>
                <div class="small-1of12">
                  R
                </div>
                <div class="small-1of12">
                  T
                </div>
                <div class="small-1of12">
                  N
                </div>
                <div class="small-1of12">
                  A
                </div>
                <div class="small-1of12">
                  W
                </div>
                <div class="small-1of12">
                  M
                </div>
                <div class="small-1of12">
                  D
                </div>
                <div class="small-1of12">
                  B
                </div>
              </div>

              <?php while( have_rows('skills') ): the_row(); ?>

                <?php // vars
                $name = get_sub_field('name');

                $category = get_sub_field('category');
                $description = get_sub_field('description');
                $prereq = get_sub_field('prerequesites');
                $mercenary_cost = get_sub_field('mercenary_cost');
                $ranger_cost = get_sub_field('ranger_cost');
                $templar_cost = get_sub_field('templar_cost');
                $nightblade_cost = get_sub_field('nightblade_cost');
                $assassin_cost = get_sub_field('assassin_cost');
                $witchhunter_cost = get_sub_field('witchblade_cost');
                $mage_cost = get_sub_field('mage_cost');
                $druid_cost = get_sub_field('druid_cost');
                $bard_cost = get_sub_field('bard_cost');

                ?>

                <div class="flex--row skill_row ">
                  <div class="small-1of4">
                    <?php echo $name; ?>&nbsp <i class="fa fa-info-circle skill_expander" aria-hidden="true"></i>
                  </div>
                  <div class="small-1of12">
                    <?php echo $mercenary_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $ranger_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $templar_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $nightblade_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $assassin_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $witchhunter_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $mage_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $druid_cost; ?>
                  </div>
                  <div class="small-1of12">
                    <?php echo $bard_cost; ?>
                  </div>
                  <div class="small-11of12 skill_desc" style="display:none;">
                    <?php echo $description; ?>
                    <hr />
                    <p class="skill_meta"><a href="#" class="skill_closer"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;close</a></p>
                  </div>
                </div>

              <?php endwhile; ?>
            </div>
          </div>

        <?php endif; ?>

        <?php if(count($races) > 0 ) { ?>
          <div id="" class="small-1of1 box mobile">

            <div id="race-menu" class="small-1of4">
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

                    <option value="<?php echo preg_replace('/ \(.*/', "", $race->name); ?>"><?php echo $race_string ?></option>
                  <?php  }?>
                </select>
              </span></p>
            </div>

            <div id="race-content" class="small-1of1">
              <?php foreach ($races as $race) { ?>
                <div class="race content repeater-content" data-name="<?php echo preg_replace('/ \(.*/', "", $race->name); ?>">

                  <div class="flex-grid">
                    <div class="full med-1of3 box race_meta">

                      <div class="builder-photo__block">
                          <div class="builder-photo__content">
                              <div class="builder-photo__content-inner">

                                <img src="<?php echo $race->photo ?>" class="img-responsive builder_photo" alt="<?php echo $race->name ?>" title="<?php echo $race->name ?>"/>

                                <h4>Lifespan</h4>

                                <p><?php echo $race->life_span; ?></p>

                                <h4>Racial Characteristics</h4>

                                <p><?php echo $race->racial_characteristics; ?></p>
                              </div>
                          </div>
                      </div>

                    </div>
                    <div class="full med-2of3 box race_info <?php echo (wp_is_mobile()) ? "mobile" : "desktop"; ?> builder-photo__block">

                      <h4>Description</h4>
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
        <?php } ?>

        <?php if(count($classes) > 0 ) { ?>
          <div id="" class="small-1of1 box mobile">

            <div id="class-menu" class="small-1of4">
              <p><span class="custom-dropdown custom-dropdown--red">
                <select id="class-dropdown" class="builder_selector custom-dropdown__select custom-dropdown__select--red">
                <option>Select a class</option>
                  <?php foreach ($classes as $class) { ?>
                    <?php $class_string = ($class->frag_cost > 0) ? $class->name . " (" . $class->frag_cost . " FRAGS)" : $class->name; ?>
                    <option value="<?php echo $class->name; ?>"><?php echo $class_string ?></option>
                  <?php } ?>
                </select>
              </span></p>
            </div>

            <div id="class-content" class="small-1of1">
              <?php foreach ($classes as $pc_class) { ?>
                <div class="class content repeater-content" data-name="<?php echo $pc_class->name; ?>">

                  <div class="flex-grid">
                    <div class="full med-1of3 box class_meta">

                      <div class="builder-photo__block">
                          <div class="builder-photo__content">
                              <div class="builder-photo__content-inner">

                                <img src="<?php echo $pc_class->photo ?>" class="img-responsive builder_photo" alt="<?php echo $pc_class->name ?>" title="<?php echo $pc_class->name ?>"/>

                              </div>
                          </div>
                      </div>

                    </div>
                    <div class="full med-2of3 box class_info builder-photo__block">

                      <h4>Description</h4>
                      <?php echo $pc_class->description; ?>

                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
</div><!--/.container-->

<script type="text/javascript" src="<?php site_url(); ?>/wp-content/themes/tempestgrove/assets/js/character-builder.js"></script>
<script type="text/javascript" src="<?php site_url(); ?>/wp-content/themes/tempestgrove/assets/js/codex.js"></script>
<?php get_footer(); ?>


<div class="dialog__overlay dialog__close"></div>
<div class="dialog" data-dialog="spell-details">
  <!-- Close Icon -->
  <a href="#" class="dialog__close-button dialog__close">
      X
  </a>
  <!-- Content -->
  <div class="modal-header">
      <h4 class="modal-title">Spell Details</h4>
  </div>
  <div id="spell_info" class="modal-body">
  </div>
</div>
