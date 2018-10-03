<?php

 /**
  * Template Name: RP Awards
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
$entries = GFAPI::get_entries( 1 );

$results = [];
foreach ($entries as $entry) {
  if(!empty($entry[11]) || !empty($entry[12])){
    if(empty($results[$entry[10]])){
      $results[$entry[10]]['name'] = get_the_title($entry[10]);
      $results[$entry[10]]['votes'] = [];
    }
    if(!isset($results[$entry[10]]['votes'][$entry[11]])){
      $results[$entry[10]]['votes'][$entry[11]]['name'] = get_the_title($entry[11]);
      $results[$entry[10]]['votes'][$entry[11]]['descriptions'] = [];
    }
    if(!isset($results[$entry[10]]['votes'][$entry[12]])){
      $results[$entry[10]]['votes'][$entry[12]] = [];
      $results[$entry[10]]['votes'][$entry[12]]['name'] = get_the_title($entry[12]);
      $results[$entry[10]]['votes'][$entry[12]]['descriptions'] = [];
    }
    array_push($results[$entry[10]]['votes'][$entry[11]]['descriptions'], $entry[7]);
    array_push($results[$entry[10]]['votes'][$entry[12]]['descriptions'], $entry[8]);

  }
}


$smarty->assign('title', "RP Awards");
$smarty->assign('results', $results);


get_header();
$smarty->display('pages/rp_awards.tpl');
get_footer();
