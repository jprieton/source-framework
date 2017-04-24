<?php

namespace SourceFramework\Core;

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
   * @var           AdminInit
   */
  protected static $instance;

  /**
   * Enqueue admin scripts.
   *
   * @since   1.0.0
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
    $styles = apply_filters( 'source_framework_admin_enqueue_styles', $styles );
    do_action( 'source_framework_enqueue_styles', $styles );
  }

}
