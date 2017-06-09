<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\Setting;

/**
 * SourceFramework class
 *
 * @package     SourceFramework
 * @subpackage  Core
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
final class SourceFramework extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFramework
   */
  protected static $instance;

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   * @var array
   */
  private $script_async_handles = [];

  /**
   * Array of handlers of scritps to add <code>defer</code> property;
   * @var array
   */
  private $script_defer_handles = [];

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * This hook is called once any activated plugins have been loaded
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );

    if ( is_admin() ) {
      /**
       * Initialize admin
       * @since   1.0.0
       */
      SourceFrameworkAdmin::get_instance();
    } else {
      /**
       * Initialize public
       * @since   1.0.0
       */
      SourceFrameworkPublic::get_instance();
    }
  }

  /**
   * This hook is called once any activated plugins have been loaded
   *
   * @since 1.0.0
   */
  public function plugins_loaded() {
    /**
     * Load plugin textdomain
     * @since 1.0.0
     */
    load_plugin_textdomain( \SourceFramework\TEXTDOMAIN, FALSE, basename( dirname( \SourceFramework\BASENAME ) ) . '/languages/' );
  }

}
