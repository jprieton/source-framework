<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Core\Public_Init;
use SourceFramework\Core\User;

require_once SourceFramework\ABSPATH . '/public/class-public-init.php';
require_once SourceFramework\ABSPATH . '/bootstrap/init.php';

add_action( 'wp_enqueue_scripts', function() {
  $init = Public_Init::get_instance();

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

add_action( 'wp_head', function () {
  $init = Public_Init::get_instance();

  /**
   * Shows a custom code in header of the singular template
   * @since 1.0.0
   */
  $init->singular_custom_code_header_script();
} );

add_action( 'wp_footer', function () {
  $init = Public_Init::get_instance();

  /**
   * Shows a custom code in footer of the singular template
   * @since 1.0.0
   */
  $init->singular_custom_code_footer_script();
} );

add_action( 'wp_ajax_nopriv_user_create_profile', function() {
  require_once SourceFramework\ABSPATH . '/includes/class-user.php';

  $user = new User();

  /**
   * Creates an user profile
   * @since 1.0.0
   */
  $user->ajax_create_profile();
} );

add_action( 'wp_ajax_user_update_profile', function() {
  require_once SourceFramework\ABSPATH . '/includes/class-user.php';

  $user = new User();

  /**
   * Updates an user profile
   * @since 1.0.0
   */
  $user->ajax_update_profile();
} );
