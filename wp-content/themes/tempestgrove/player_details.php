<?php

 /**
  * Template Name: Player Details
  *
  * @package WordPress
  * @subpackage Tempest Grove
  * @since Tempest Grove 2.0
  */


// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('slick',     	ASSETS_DIR . 'vendor/slick.js',                  	array(), ASSET_VERSION, 1);
	wp_enqueue_script('forms',		ASSETS_DIR . 'js/components/forms/forms.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('dialog',		ASSETS_DIR . 'js/components/dialog/dialog.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('gallery',	ASSETS_DIR . 'js/components/gallery/gallery.js',	array(), ASSET_VERSION, 1);
	wp_enqueue_script('tabs',	ASSETS_DIR . 'js/components/tabs/tabs.js',	array(), ASSET_VERSION, 1);
}

$smarty = wp_smarty();

if (isset($_GET['player_id'])) {
  $player_id = $_GET['player_id'];
	$characters = get_player_characters($player_id);
	$topics = bbp_get_user_topics_started($player_id);
	$replies = bbp_get_user_replies($player_id);
	$user = get_user_by('id', $player_id);
	$smarty->assign('title', $user->first_name);
	$smarty->assign('characters', $characters);
}

get_header();
$smarty->display('pages/player-details.tpl');
get_footer();
