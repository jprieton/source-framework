<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * CoreInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class CoreInit extends \SourceFramework\Abstracts\Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           CoreInit
   */
  protected static $instance;

  /**
   * Load plugin texdomain
   *
   * @since         1.0.0
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'source-framework', FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );
  }

}
