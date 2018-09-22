<?php

 /**
  * Template Name: Events
  *
  * @package WordPress
  * @subpackage Tempest Grove
  * @since Tempest Grove 1.0
  */


// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('slick',     	ASSETS_DIR . 'vendor/slick.js',                  	array(), ASSET_VERSION, 1);
	wp_enqueue_script('forms',		ASSETS_DIR . 'js/components/forms/forms.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('gallery',	ASSETS_DIR . 'js/components/gallery/gallery.js',	array(), ASSET_VERSION, 1);
}

get_header();

?>
<!-- blocks -->
<section class="landing-blocks">
  <div class="landing-blocks__container container--xl flex-grid">
    <div class="landing-blocks__character box">

      <div class="landing-blocks__character-inner events-container">

            <?php the_content(); ?>

      </div>
    </div>
  </div>
</section>
<?php


get_footer();
