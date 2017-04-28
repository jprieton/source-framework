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
require_once SourceFramework\ABSPATH . '/admin/class-admin-init.php';

/**
 * Enqueue admin script & styles
 * @since 1.0.0
 */
add_action( 'admin_enqueue_scripts', function() {
  $admin = SourceFramework\Core\AdminInit::get_instance();

  /**
   * Register and enqueue plugin scripts
   * @since 1.0.0
   */
  $admin->enqueue_scripts();

  /**
   * Register and enqueue plugin styles
   * @since 1.0.0
   */
  $admin->enqueue_styles();
} );
