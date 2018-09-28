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
$date = strtotime($post->fields['event_start']);
$remaining = $date - time();
$days_remaining = floor($remaining / 86400);
$hours_remaining = floor(($remaining % 86400) / 3600);
$post->time_remaining = "This event has passed.";
if(strtotime($post->fields['event_start']) > time()){
	$post->time_remaining = "In $days_remaining days, $hours_remaining hours.";
}
$smarty->assign('game', $post);
$smarty->assign('title', $post->post_title);
$smarty->assign('event_has_passed', (strtotime($post->fields['event_end']) > time()));

get_header();
$smarty->display('pages/single-games.tpl');
get_footer();
