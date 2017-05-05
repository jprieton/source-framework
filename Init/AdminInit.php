<?php

namespace SourceFramework\Init;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;

/**
 * AdminInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AdminInit extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           PublicInit
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    /**
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
  
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 0.5.0
   */
  public function enqueue_scripts() {
    $scripts = [
        'source-framework-admin' => [
            'local'     => plugins_url( 'assets/js/admin.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true
        ],
    ];

    /**
     * Filter plugin scripts
     *
     * @since   0.5.0
     * @param   array   $scripts
     */
    $_scripts = apply_filters( 'source_framework_admin_register_scripts', $scripts );
    do_action( 'source_framework_enqueue_scripts', $_scripts );
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
            'ver'      => \SourceFramework\VERSION,
            'autoload' => true
        ],
    ];

    /**
     * Filter styles
     *
     * @since   1.0.0
     * @param   array   $styles
     */
    $_styles = apply_filters( 'source_framework_admin_register_styles', $styles );
    do_action( 'source_framework_enqueue_styles', $_styles );
  }

}
