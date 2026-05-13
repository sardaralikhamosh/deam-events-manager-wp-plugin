<?php
// Register custom post type for events
function deam_events_register_post_type() {
    $labels = array(
        'name'               => __('Events', 'deam-events'),
        'singular_name'      => __('Event', 'deam-events'),
        'menu_name'          => __('DEAM Events', 'deam-events'),
        'add_new'            => __('Add New Event', 'deam-events'),
        'add_new_item'       => __('Add New Event', 'deam-events'),
        'edit_item'          => __('Edit Event', 'deam-events'),
        'new_item'           => __('New Event', 'deam-events'),
        'view_item'          => __('View Event', 'deam-events'),
        'search_items'       => __('Search Events', 'deam-events'),
        'not_found'          => __('No events found', 'deam-events'),
        'not_found_in_trash' => __('No events found in trash', 'deam-events'),
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'event'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'show_in_rest'        => true,
    );
    
    register_post_type('deam_event', $args);
}
add_action('init', 'deam_events_register_post_type');

// Add custom template for single event pages
add_filter('single_template', 'deam_events_single_template');
function deam_events_single_template($single) {
    global $post;
    
    if ($post->post_type == 'deam_event') {
        $template_path = DEAM_EVENTS_PLUGIN_DIR . 'templates/single-event.php';
        if (file_exists($template_path)) {
            return $template_path;
        }
    }
    
    return $single;
}