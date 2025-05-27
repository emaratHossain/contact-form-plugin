<?php

class ContactFormAPI {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('contact-form/v1', '/submit', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_submission'],
            'permission_callback' => '__return_true',
            'args' => [
                'name' => ['required' => true],
                'email' => ['required' => true],
                'message' => ['required' => true],
            ]
        ]);
    }

    public function handle_submission($request) {
        $params = $request->get_json_params();

        if (empty($params['email'])) {
            return new WP_REST_Response(['error' => 'Invalid email'], 400);
        }

        $post_id = wp_insert_post([
            'post_type' => 'contact_submission',
            'post_title' => sanitize_text_field($params['name']),
            'post_status' => 'publish',
            'meta_input' => [
                'email' => sanitize_email($params['email']),
                'message' => sanitize_textarea_field($params['message']),
            ],
        ]);

        return new WP_REST_Response(['success' => true, 'id' => $post_id], 200);
    }
}

new ContactFormAPI();
