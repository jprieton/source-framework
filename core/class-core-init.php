<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

namespace SourceFramework\Core;

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
   * @author        Javier Prieto <jprieton@gmail.com>
   * @var           CoreInit
   */
  protected static $instance;

  /**
   * Load plugin texdomain
   *
   * @since         1.0.0
   * @author        Javier Prieto <jprieton@gmail.com>
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'source-framework', FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );
  }

}
