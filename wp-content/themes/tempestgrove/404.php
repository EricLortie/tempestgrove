<?php

$smarty = wp_smarty();
$smarty->assign('is_404', true);

get_header();
$smarty->display('pages/404.tpl');
get_footer();
