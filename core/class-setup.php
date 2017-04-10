<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Core_Setup class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Setup {

  /**
   * The code that runs during plugin activation.
   *
   * @since         1.0.0
   */
  public static function activate() {

  }

  /**
   * The code that runs during plugin deactivation.
   *
   * @since         1.0.0
   */
  public static function deactivate() {

  }

  /**
   * The code that runs during plugin deactivation.
   *
   * @since         1.0.0
   */
  public static function uninstall() {
    $options = [];
    foreach ( $options as $option ) {
      delete_option( $option );
    }
  }

}
