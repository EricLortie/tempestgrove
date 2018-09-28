<?php

// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('slick',     	ASSETS_DIR . 'vendor/slick.js',                  	array(), ASSET_VERSION, 1);
	wp_enqueue_script('forms',		ASSETS_DIR . 'js/components/forms/forms.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('dialog',		ASSETS_DIR . 'js/components/dialog/dialog.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('gallery',	ASSETS_DIR . 'js/components/gallery/gallery.js',	array(), ASSET_VERSION, 1);
}

global $post;
$post->fields = get_fields($post->ID);

$smarty = wp_smarty();

$post->time_remaining = get_game_time_remaining($post);

$smarty->assign('game', $post);
$smarty->assign('title', $post->post_title);
$smarty->assign('event_has_passed', (strtotime($post->fields['event_end']) > time()));

get_header();
$smarty->display('pages/single-games.tpl');
get_footer();
