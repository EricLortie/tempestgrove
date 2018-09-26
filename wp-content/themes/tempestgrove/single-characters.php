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
$post->thumbnail_url = get_the_post_thumbnail_url($post->ID);
$post->permalink = get_the_permalink($post->ID);
$post->fields = get_fields($post->ID);
$post->content = the_content();

$smarty = wp_smarty();
$smarty->assign('title', $post->post_title);
$post->content = apply_filters('the_content', get_post_field('post_content', $post->ID));
if ($post->content == "") {
	$post->content = $post->post_excerpt;
}
if($post->fields['player']){
	$post->profile_url = "/player-details?player_id=" . $post->fields['player']['ID'];
}
$smarty->assign('character', $post);

get_header();
$smarty->display('pages/single-characters.tpl');
get_footer();
