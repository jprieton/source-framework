<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

// Core functions
require_once SourceFramework\ABSPATH . '/core/functions.php';

// Setup plugin
require_once SourceFramework\ABSPATH . '/core/class-setup.php';

// Includes
include_once SourceFramework\ABSPATH . '/helpers/init.php';
require_once SourceFramework\ABSPATH . '/includes/option.php';
require_once SourceFramework\ABSPATH . '/includes/format.php';

// Core
require_once SourceFramework\ABSPATH . '/core/class-core-init.php';

// Html
require_once SourceFramework\ABSPATH . '/core/html/class-tag.php';

// Forms
require_once SourceFramework\ABSPATH . '/core/forms/class-form.php';
require_once SourceFramework\ABSPATH . '/core/forms/class-element.php';
require_once SourceFramework\ABSPATH . '/core/forms/elements/class-email.php';
require_once SourceFramework\ABSPATH . '/core/forms/elements/class-hidden.php';
require_once SourceFramework\ABSPATH . '/core/forms/elements/class-text.php';
require_once SourceFramework\ABSPATH . '/core/forms/elements/class-textarea.php';
require_once SourceFramework\ABSPATH . '/core/forms/elements/class-password.php';

add_action( 'init', function() {
  /**
   * Load plugin texdomain
   * @since 1.0.0
   */
  load_plugin_textdomain( SourceFramework\TEXDOMAIN, FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );
} );

add_filter( 'source_framework_localize_scripts', function() {
  $init = SourceFramework\Core\Core_Init::get_instance();

  /**
   * Localize script
   * @since 1.0.0
   */
  return $init->localize_scripts();
}, 0 );

add_action( 'source_framework_register_styles', function( $styles ) {
  $init = SourceFramework\Core\Core_Init::get_instance();

  /**
   * Register and optionally enqueue styles
   * @since   1.0.0
   */
  $init->register_styles( $styles );
} );

add_action( 'source_framework_register_scripts', function( $scripts ) {
  $init = SourceFramework\Core\Core_Init::get_instance();

  /**
   * Register and optionally enqueue scripts
   * @since   1.0.0
   */
  $init->register_scripts( $scripts );
} );

if ( is_admin() ) {
  /**
   * Init admin
   */
  include_once SourceFramework\ABSPATH . '/includes/admin-init.php';
} else {
  /**
   * Init public
   */
  include_once SourceFramework\ABSPATH . '/includes/public-init.php';
}
