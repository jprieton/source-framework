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
require_once SourceFramework\ABSPATH . '/admin/class-advanced-settings.php';

use SourceFramework\Core\Admin_Init;
use SourceFramework\Admin\Advanced_Settings;

add_action( 'admin_enqueue_scripts', function() {

  $init = Admin_Init::get_instance();

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

add_action( 'admin_menu', function() {

  /**
   * Register Advanced Settings
   * @since 1.0.0
   */
  new Advanced_Settings();
} );
