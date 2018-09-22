<?php

register_nav_menu('main_menu', 'Main Menu');
register_nav_menu('footer_menu', 'Footer Menu');

function get_nav_tree($location){
    $theme_locations = get_nav_menu_locations();
    $menu_id = $theme_locations[$location];
    $items = wp_get_nav_menu_items($menu_id);
    return  $items ? buildTree($items, 0) : null;
}

function buildTree( array &$elements, $parent = 0 ){
    global $tab_bar_count;
    $branch = array();
    $tab_bar_count = 0;
    foreach ($elements as &$element){
        if($element->menu_item_parent == $parent){
            $children = buildTree($elements, $element->ID);
            if ($children){
                $element->children = $children;
            }
            $branch[$element->ID] = $element;
            unset($element);
        }
        if (!isset($element)) { continue; }
        $show_in_tab_bar = get_field('show_in_tab_bar', $element->ID);
        $show_on_mobile_only = get_field('show_on_mobile_only', $element->ID);
        if($show_in_tab_bar)
            $element->in_tab_bar = $show_in_tab_bar;
        if($show_on_mobile_only)
            $element->mobile_more = $show_on_mobile_only;


        if($element->in_tab_bar && $element->menu_item_parent == 0){
            $tab_bar_count++;
        }
        if($element->mobile_more){
            $tab_bar_count++;
        }
    }
    if($tab_bar_count > 5){
        $tab_bar_count = 5;
    }
    return $branch;
}

function assign_menus(&$wp_smarty){
    global $tab_bar_count;
    $nav_tree = get_nav_tree('main_menu');
    if(!empty($nav_tree)){
        $menu = array_values(get_nav_tree('main_menu'));
        $wp_smarty->assign('main_menu', $menu);
        $wp_smarty->assign('tab_bar_count', $tab_bar_count);
    }

    $footer_nav_tree = get_nav_tree('footer_menu');
    if(!empty($footer_nav_tree)){
        $footer_menu = array_values(get_nav_tree('footer_menu'));
        $wp_smarty->assign('footer_menu', $footer_menu);
    }
}
