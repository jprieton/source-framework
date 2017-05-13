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
 * Admin class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class SourceFrameworkAdmin extends Singleton {

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
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_filter( 'source_framework_styles', [ $this, 'styles' ], 0 );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_filter( 'source_framework_scripts', [ $this, 'scripts' ], 0 );
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 1.0.0
   */
  public function scripts( $scripts ) {
    $scripts['source-framework-admin'] = [
        'local'     => plugins_url( 'assets/js/admin.js', \SourceFramework\PLUGIN_FILE ),
        'deps'      => [ 'jquery' ],
        'ver'       => \SourceFramework\VERSION,
        'in_footer' => true,
        'autoload'  => true,
        'defer'     => true,
    ];
    return $scripts;
  }

  /**
   * Register & enqueue plugin styles
   *
   * @since 1.0.0
   */
  public function enqueue_styles() {
    $styles['source-framework-admin'] = [
        'local'    => plugins_url( 'assets/css/admin.css', \SourceFramework\PLUGIN_FILE ),
        'ver'      => \SourceFramework\VERSION,
        'autoload' => true
    ];
    return $styles;
  }

}
