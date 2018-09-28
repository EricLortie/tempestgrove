<?php

add_action('init', 'register_post_type_rp_awards');
function register_post_type_rp_awards() {
    register_post_type('rp_awards', array(
            'labels' => array(
                'name' => 'RP Awards',
                'singular_name' => 'RP Awards'
            ),
            'public' => true,
            'show_ui' => true,
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'rewrite' => array('slug' => 'rp_awards', 'with_front' => false),
            'supports' => array('title', 'revisions'),
            'menu_icon' => 'dashicons-thumbs-up',
            'publicly_queryable' => false
        )
    );
}
