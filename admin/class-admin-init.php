<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Admin_Init class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Admin_Init {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           AdminInit
   */
  protected static $instance;

  /**
   * @since         1.0.0
   * @return  static
   */
  public static function &get_instance() {
    if ( !isset( static::$instance ) ) {
      static::$instance = new static;
    }
    return static::$instance;
  }

  /**
   * Enqueue admin scripts.
   *
   * @since   1.0.0
   */
  public function enqueue_scripts() {
    $scripts = [
        'source-framework-admin' => [
            'local'     => SourceFramework\ABSPATH . 'assets/js/admin.js',
            'deps'      => array( 'jquery' ),
            'ver'       => SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true
        ],
    ];

    /**
     * Filter plugin admin scripts
     *
     * @since   1.0.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'source_framework_admin_enqueue_scripts', $scripts );
    do_action( 'source_framework_enqueue_scripts', $scripts );
  }

  /**
   * Register & enqueue plugin styles
   *
   * @since 1.0.0
   */
  public function enqueue_styles() {
    /**
     * Plugin styles
     *
     * @since 1.0.0
     */
    $styles = [
        'source-framework' => [
            'local'    => plugins_url( 'assets/css/admin.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => SourceFramework\VERSION,
            'autoload' => true
        ],
    ];

    /**
     * Filter styles
     *
     * @since   1.0.0
     * @param   array   $styles
     */
    $styles = apply_filters( 'source_framework_admin_enqueue_styles', $styles );
    do_action( 'source_framework_enqueue_styles', $styles );
  }

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {

  }

  /**
   * Declared as private to prevent cloning of an instance of the class via the clone operator.
   *
   * @since         1.0.0
   */
  private function __clone() {

  }

  /**
   * declared as private to prevent unserializing of an instance of the class via the global function unserialize().
   *
   * @since         1.0.0
   */
  private function __wakeup() {

  }

  /**
   * Declared as protected to prevent serializg of an instance of the class via the global function serialize().
   *
   * @since         1.0.0
   */
  protected function __sleep() {

  }

}
