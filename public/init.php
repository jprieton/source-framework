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
require_once SourceFramework\ABSPATH . '/includes/class-tag.php';

require_once SourceFramework\ABSPATH . '/includes/general-template.php';
require_once SourceFramework\ABSPATH . '/includes/shortcodes.php';
require_once SourceFramework\ABSPATH . '/includes/user.php';
require_once SourceFramework\ABSPATH . '/includes/class-microdata.php';

add_action( 'wp_enqueue_scripts', function() {
  $public = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Register and enqueue plugin scripts
   * @since 1.0.0
   */
  $public->enqueue_scripts();

  /**
   * Register and enqueue plugin styles
   * @since 1.0.0
   */
  $public->enqueue_styles();
} );

add_action( 'wp_head', function () {
  $public = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in header of the singular template
   * @since 1.0.0
   */
  $public->singular_custom_code_header_script();
} );

add_action( 'before_main_content', function () {
  $public = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in footer of the singular template
   * @since 1.0.0
   */
  $public->singular_custom_code_body_script();
} );

add_action( 'wp_footer', function () {
  $public = SourceFramework\Core\PublicInit::get_instance();

  /**
   * Shows a custom code in footer of the singular template
   * @since 1.0.0
   */
  $public->singular_custom_code_footer_script();
} );
