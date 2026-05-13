<?php
/**
 * Plugin Name: Digicells Events Manager
 * Plugin URI: https://digicellinternational.shinisa.com
 * Description: Professional events management plugin with custom post types, metaboxes, frontend listing, and registration form.
 * Version: 1.0.0
 * Author: Sardar ALi Khamosh (Digicells)
 * Text Domain: Digicells
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DEAM_EVENTS_VERSION', '1.0.0');
define('DEAM_EVENTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DEAM_EVENTS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once DEAM_EVENTS_PLUGIN_DIR . 'includes/post-types.php';
require_once DEAM_EVENTS_PLUGIN_DIR . 'includes/metaboxes.php';
require_once DEAM_EVENTS_PLUGIN_DIR . 'includes/shortcodes.php';
require_once DEAM_EVENTS_PLUGIN_DIR . 'includes/ajax-handlers.php';

// Enqueue admin styles
add_action('admin_enqueue_scripts', 'deam_events_admin_styles');
function deam_events_admin_styles() {
    wp_enqueue_style('deam-events-admin-style', DEAM_EVENTS_PLUGIN_URL . 'assets/css/admin-style.css', array(), DEAM_EVENTS_VERSION);
}

// Enqueue frontend styles and scripts
add_action('wp_enqueue_scripts', 'deam_events_frontend_assets');
function deam_events_frontend_assets() {
    // Enqueue Google Fonts - Poppins
    wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    // Enqueue frontend styles
    wp_enqueue_style('deam-events-frontend-style', DEAM_EVENTS_PLUGIN_URL . 'assets/css/frontend-style.css', array(), DEAM_EVENTS_VERSION);
    
    // Enqueue jQuery and frontend scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('deam-events-frontend-script', DEAM_EVENTS_PLUGIN_URL . 'assets/js/frontend-script.js', array('jquery'), DEAM_EVENTS_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('deam-events-frontend-script', 'deam_events_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('deam_events_nonce')
    ));
}

// Activation hook - create custom database table for registrations
register_activation_hook(__FILE__, 'deam_events_activate');
function deam_events_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'deam_event_registrations';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        event_id mediumint(9) NOT NULL,
        name varchar(255) NOT NULL,
        contact_number varchar(50) NOT NULL,
        email varchar(255) NOT NULL,
        address text NOT NULL,
        nationality varchar(100) NOT NULL,
        gender varchar(20) NOT NULL,
        registration_date datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Flush rewrite rules for custom post type
    deam_events_register_post_type();
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'deam_events_deactivate');
function deam_events_deactivate() {
    flush_rewrite_rules();
}
// Add this to deam-events-manager.php
function deam_events_get_template($template_name, $args = array()) {
    if (!empty($args) && is_array($args)) {
        extract($args);
    }
    
    $template_path = DEAM_EVENTS_PLUGIN_DIR . 'templates/' . $template_name;
    $theme_template_path = get_template_directory() . '/deam-events/' . $template_name;
    
    if (file_exists($theme_template_path)) {
        $template_path = $theme_template_path;
    }
    
    if (file_exists($template_path)) {
        include $template_path;
    }
}