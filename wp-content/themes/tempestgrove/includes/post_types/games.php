<?php

add_action('init', 'register_post_type_games');
function register_post_type_games() {
    register_post_type('games', array(
            'labels' => array(
                'name' => 'Games',
                'singular_name' => 'Game'
            ),
            'public' => true,
            'show_ui' => true,
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'rewrite' => array('slug' => 'games', 'with_front' => false),
            'supports' => array('title'),
            'menu_icon' => 'dashicons-calendar-alt'
        )
    );
}
