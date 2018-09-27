<?php

add_action('init', 'register_post_type_alerts');
function register_post_type_alerts() {
    register_post_type('alerts', array(
            'labels' => array(
                'name' => 'Alerts',
                'singular_name' => 'Alert'
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'rewrite' => array('slug' => 'alerts', 'with_front' => false),
            'supports' => array('title', 'revisions'),
            'menu_icon' => 'dashicons-warning',
            'publicly_queryable' => false
        )
    );
}
