<?php

namespace SourceFramework\Bootstrap;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Bootstrap_Init class
 *
 * @package        Bootstrap
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Bootstrap_Init {

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

  /**
   * Register & enqueue plugin scripts
   *
   * @since         1.0.0
   */
  public function enqueue_scripts( $scripts ) {
    $scripts['bootstrap'] = [
        'local'     => plugins_url( 'assets/js/bootstrap.min.js', \SourceFramework\PLUGIN_FILE ),
        'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'deps'      => [ 'jquery' ],
        'ver'       => '3.3.7',
        'in_footer' => true,
        'autoload'  => true,
    ];
    return $scripts;
  }

  /**
   * Register & enqueue plugin styles
   *
   * @since         1.0.0
   */
  public function enqueue_styles( $styles ) {
    $styles['bootstrap']      = [
        'remote'   => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'ver'      => '3.3.7',
        'autoload' => true,
    ];
    $styles['bootstrap-flex'] = [
        'local'    => plugins_url( 'assets/css/bootstrap-flex.css', \SourceFramework\PLUGIN_FILE ),
        'deps'     => [ 'bootstrap' ],
        'ver'      => \SourceFramework\VERSION,
        'autoload' => true,
    ];
    return $styles;
  }

}
