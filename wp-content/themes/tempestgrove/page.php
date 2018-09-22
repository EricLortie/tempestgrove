<?php

// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('slick',     	ASSETS_DIR . 'vendor/slick.js',                  	array(), ASSET_VERSION, 1);
	wp_enqueue_script('forms',		ASSETS_DIR . 'js/components/forms/forms.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('gallery',	ASSETS_DIR . 'js/components/gallery/gallery.js',	array(), ASSET_VERSION, 1);
}

global $post;

$smarty = wp_smarty();
$smarty->assign('title', $post->post_title);
$smarty->assign('fields', get_fields());

get_header();
$smarty->display('pages/page.tpl');
get_footer();
