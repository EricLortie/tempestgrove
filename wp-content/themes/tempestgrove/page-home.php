<?php
/*
 * Template Name: Homepage
 */

global $post;

$smarty = wp_smarty();
$fields = get_fields();

$characters = get_characters(4);

$smarty->assign('is_home', true);
$smarty->assign('fields', $fields);
$smarty->assign('characters', $characters);

get_header();
$smarty->display('pages/page-home.tpl');
get_footer();
