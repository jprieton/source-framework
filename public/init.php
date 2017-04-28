<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once SourceFramework\ABSPATH . '/includes/abstracts/abstract-singleton.php';
require_once SourceFramework\ABSPATH . '/public/class-public-init.php';
require_once SourceFramework\ABSPATH . '/includes/general-template.php';
require_once SourceFramework\ABSPATH . '/includes/shortcodes.php';
require_once SourceFramework\ABSPATH . '/includes/user.php';
require_once SourceFramework\ABSPATH . '/includes/class-microdata.php';

add_action( 'wp_enqueue_scripts', function() {
  $init = SourceFramework\Core\PublicInit::get_instance();

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
  $init = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in header of the singular template
   * @since 1.0.0
   */
  $init->singular_custom_code_header_script();
} );

add_action( 'before_main_content', function () {
  $init = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in footer of the singular template
   * @since 1.0.0
   */
  $init->singular_custom_code_body_script();
} );

add_action( 'wp_footer', function () {
  $init = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in footer of the singular template
   * @since 1.0.0
   */
  $init->singular_custom_code_footer_script();
} );
