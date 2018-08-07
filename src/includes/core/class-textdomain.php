<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Textdomain class
 *
 * @package        SourceFramework
 * @subpackage     Init
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Textdomain {

  /**
   * Load plugin textdomain
   *
   * @since     1.1.0
   */
  public static function load_plugin_textdomain() {
    load_plugin_textdomain( SF_TEXTDOMAIN, FALSE, basename( dirname( SF_BASENAME ) ) . '/languages/' );
  }

  /**
   * Adds tanslation to plugin description
   *
   * @since     2.0.0
   * @param     array $all_plugins
   * @return    array
   */
  public static function modify_plugin_description( $all_plugins = [] ) {
    if ( key_exists( SF_BASENAME, $all_plugins ) ) {
      $all_plugins[SF_BASENAME]['Description'] = __( 'An extensible object-oriented micro-framework for WordPress '
              . 'that helps you to develop themes and plugins.', SF_TEXTDOMAIN );
    }
    return $all_plugins;
  }

}
