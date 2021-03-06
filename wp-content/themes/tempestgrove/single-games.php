<?php

// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('slick',    ASSETS_DIR . 'vendor/slick.js',                  	array(), ASSET_VERSION, 1);
	wp_enqueue_script('forms',		ASSETS_DIR . 'js/components/forms/forms.js', 		  array(), ASSET_VERSION, 1);
	wp_enqueue_script('dialog',		ASSETS_DIR . 'js/components/dialog/dialog.js', 		array(), ASSET_VERSION, 1);
	wp_enqueue_script('gallery',	ASSETS_DIR . 'js/components/gallery/gallery.js',	array(), ASSET_VERSION, 1);
}

global $post;
$post->fields = get_fields($post->ID);

$search_criteria['field_filters'][] = array( 'key' => '10', 'value' => $post->ID );

$rp_awards = [];
$entries = GFAPI::get_entries( 1, $search_criteria);
foreach ($entries as $entry) {
  if(!empty($entry[11]) || !empty($entry[12])){
    if(empty($rp_awards[$entry[10]])){
      $rp_awards[$entry[10]]['name'] = get_the_title($entry[10]);
      $rp_awards[$entry[10]]['votes'] = [];
    }
    if(!isset($rp_awards[$entry[10]]['votes'][$entry[11]])){
      $rp_awards[$entry[10]]['votes'][$entry[11]]['name'] = get_the_title($entry[11]);
      $rp_awards[$entry[10]]['votes'][$entry[11]]['descriptions'] = [];
    }
    if(!isset($rp_awards[$entry[10]]['votes'][$entry[12]])){
      $rp_awards[$entry[10]]['votes'][$entry[12]] = [];
      $rp_awards[$entry[10]]['votes'][$entry[12]]['name'] = get_the_title($entry[12]);
      $rp_awards[$entry[10]]['votes'][$entry[12]]['descriptions'] = [];
    }
    array_push($rp_awards[$entry[10]]['votes'][$entry[11]]['descriptions'], $entry[7]);
    array_push($rp_awards[$entry[10]]['votes'][$entry[12]]['descriptions'], $entry[8]);

  }
}

$smarty = wp_smarty();

$post->time_remaining = get_game_time_remaining($post);

$smarty->assign('game', $post);
$smarty->assign('rp_awards', $rp_awards);
$smarty->assign('title', $post->post_title);
$smarty->assign('event_has_passed', (strtotime($post->fields['event_end']) > time()));

get_header();
$smarty->display('pages/single-games.tpl');
get_footer();
