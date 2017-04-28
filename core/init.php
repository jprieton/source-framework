<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}


require_once SourceFramework\ABSPATH . '/includes/functions.php';

add_action( 'init', function() {
  $core = SourceFramework\Core\CoreInit::get_instance();

  /**
   * Init plugin
   * @since 1.0.0
   */
  $core->init();
} );

add_filter( 'source_framework_localize_scripts', function() {
  $core = SourceFramework\Core\CoreInit::get_instance();

  /**
   * Localize script
   * @since 1.0.0
   */
  return $core->localize_scripts();
}, 0 );

add_action( 'source_framework_register_styles', function( $styles ) {
  $core = SourceFramework\Core\CoreInit::get_instance();

  /**
   * Register and optionally enqueue styles
   * @since   1.0.0
   */
  $core->register_styles( $styles );
} );

add_action( 'source_framework_register_scripts', function( $scripts ) {
  $core = SourceFramework\Core\CoreInit::get_instance();

  /**
   * Register and optionally enqueue scripts
   * @since   1.0.0
   */
  $core->register_scripts( $scripts );
} );
