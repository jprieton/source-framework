<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Load core dependencies
 */
require_once SourceFramework\ABSPATH . '/includes/abstracts/abstract-singleton.php';
require_once SourceFramework\ABSPATH . '/admin/class-admin-init.php';

/**
 * Enqueue admin script & styles
 * @since 1.0.0
 */
add_action( 'admin_enqueue_scripts', function() {
  $init = SourceFramework\Core\AdminInit::get_instance();

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
