<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

// Includes
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

add_action( 'plugins_loaded', function() {

  $init = \SourceFramework\Core\Core_Init::get_instance();
} );

add_action( 'init', function() {
  /**
   * Load plugin texdomain
   * @since 1.0.0
   */
  load_plugin_textdomain( SourceFramework\TEXDOMAIN, FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );
} );

add_filter( 'source_framework_localize_scripts', function() {
  /**
   * Localize script
   * @since 1.0.0
   */
  $localize_script = array(
      'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
      'messages' => array(
          'success' => __( 'Success!', SourceFramework\TEXDOMAIN ),
          'fail'    => __( 'Fail!', SourceFramework\TEXDOMAIN ),
          'error'   => __( 'Error!', SourceFramework\TEXDOMAIN ),
          'send'    => __( 'Send', SourceFramework\TEXDOMAIN ),
          'submit'  => __( 'Submit', SourceFramework\TEXDOMAIN ),
          'sending' => __( 'Sending...', SourceFramework\TEXDOMAIN ),
          'sent'    => __( 'Sent!', SourceFramework\TEXDOMAIN ),
      )
  );
  return $localize_script;
}, 0 );
