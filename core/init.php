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

add_action( 'plugins_loaded', function() {

  $init = \SourceFramework\Core\Core_Init::get_instance();

  /**
   * Load plugin texdomain
   * @since 1.0.0
   */
  $init->load_plugin_textdomain();
} );
