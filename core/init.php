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
require_once SourceFramework\ABSPATH . '/core/class-core-init.php';

add_action( 'plugins_loaded', function() {

  $init = \SourceFramework\Core\Core_Init::get_instance();

  /**
   * Load plugin texdomain
   * @since 1.0.0
   */
  $init->load_plugin_textdomain();
} );
