<?php
/*
Plugin Name: Contact Form Plugin
Description: Accepts contact form submissions via REST API and stores them using custom post type.
Version: 1.0
Author: Your Name
*/

defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/ContactFormAPI.php';

add_action('init', function () {
    register_post_type('contact_submission', [
        'label' => 'Contact Submissions',
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'custom-fields'],
    ]);
});
