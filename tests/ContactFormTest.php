<?php

class ContactFormTest extends WP_UnitTestCase {

    public function setUp(): void {
        parent::setUp();
        // Ensure routes are registered
        new ContactFormAPI();
        do_action( 'rest_api_init' );
    }

    public function test_handle_submission_success() {
        $request = new WP_REST_Request( 'POST', '/contact-form/v1/submit' );
        $request->set_header( 'Content-Type', 'application/json' );
        $request->set_body( json_encode([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, this is a test.',
        ]) );


        $response = rest_do_request( $request );
        $data = $response->get_data();

        $this->assertEquals( 200, $response->get_status() );
        $this->assertTrue( $data['success'] );
        $this->assertIsInt( $data['id'] );
    }

    public function test_handle_submission_invalid_email() {
        $request = new WP_REST_Request( 'POST', '/contact-form/v1/submit' );
        $request->set_header( 'Content-Type', 'application/json' );
        $request->set_body( json_encode([
            'name' => 'John Doe',
            'email' => '',
            'message' => 'Hello, this is a test.',
        ]) );

        $response = rest_do_request( $request );
        $data = $response->get_data();

        $this->assertEquals( 400, $response->get_status() );
        $this->assertEquals( 'Invalid email', $data['error'] );
    }
}
