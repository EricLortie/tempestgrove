<?php

// Add Page Javascripts
add_action('wp_enqueue_scripts', 'add_page_javascripts');
function add_page_javascripts(){
	wp_enqueue_script('particles',     	ASSETS_DIR . 'js/components/particles/particles.js', 	array(), ASSET_VERSION, 1);
}

$smarty = wp_smarty();
$smarty->assign('is_404', true);

get_header();
$smarty->display('pages/404.tpl');
get_footer();
