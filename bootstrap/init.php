<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

if ( !get_bool_option( 'bootstrap_enabled' ) ) {
  return;
}

use SourceFramework\Bootstrap\Bootstrap_Init;

require_once SourceFramework\ABSPATH . '/bootstrap/class-bootstrap-init.php';
require_once SourceFramework\ABSPATH . '/bootstrap/general-template.php';

/**
 * Add Bootstrap scripts
 *
 * @since 1.0.0
 */
add_filter( 'source_framework_enqueue_scripts', [ Bootstrap_Init::get_instance(), 'enqueue_scripts' ] );

/**
 * Add Bootstrap styles
 *
 * @since 1.0.0
 */
add_filter( 'source_framework_enqueue_styles', [ Bootstrap_Init::get_instance(), 'enqueue_styles' ] );
