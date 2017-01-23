<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Load dependencies
 */
require_once SourceFramework\ABSPATH . '/public/class-public-init.php';

use SourceFramework\Core\PublicInit;

add_action( 'admin_enqueue_scripts', function() {

  $init = PublicInit::get_instance();

  /**
   * Register and enqueue plugin scripts
   * @since 1.0.0
   */
  $init->enqueue_scripts();

  /**
   * Register and enqueue plugin styles
   * @since 1.0.0
   */
  $init->enqueue_styles();
} );
