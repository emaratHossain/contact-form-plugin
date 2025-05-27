<?php

// Load WP test suite from vendor
require_once __DIR__ . '/../vendor/wp-phpunit/wp-phpunit/includes/functions.php';

tests_add_filter( 'muplugins_loaded', function () {
    require dirname( __DIR__ ) . '/your-plugin-file.php';
} );

// Start the WP testing environment
require __DIR__ . '/../vendor/wp-phpunit/wp-phpunit/includes/bootstrap.php';
