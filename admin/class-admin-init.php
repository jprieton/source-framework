<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * AdminInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AdminInit {

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
   * @since         1.0.0
   */
  protected function __construct() {
    /**
     * Declared as protected to prevent creating a new instance outside of the class via the new operator.
     */
  }

  /**
   * @since         1.0.0
   */
  private function __clone() {
    /**
     * Declared as private to prevent cloning of an instance of the class via the clone operator.
     */
  }

  /**
   * @since         1.0.0
   */
  private function __wakeup() {
    /**
     * declared as private to prevent unserializing of an instance of the class via the global function unserialize() .
     */
  }

  /**
   * @since   1.0.0
   */
  protected function __sleep() {
    // Avoid Serializg of Object
  }

  /**
   * Enqueue admin scripts.
   *
   * @since   1.0.0
   */
  public function enqueue_scripts() {
    $scripts = array(
        'source-framework-admin' => array(
            'local'     => \SourceFramework\ABSPATH . 'assets/js/admin.js',
            'deps'      => array( 'jquery' ),
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true
        ),
    );

    /**
     * Filter plugin admin scripts
     *
     * @since   0.5.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'source_framework_asmin_register_scripts', $scripts );

    $defaults = array(
        'local'     => '',
        'remote'    => '',
        'deps'      => array(),
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'enable-cdn' );

    foreach ( $scripts as $handle => $script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      $deps      = $script['deps'];
      $ver       = $script['ver'];
      $in_footer = $script['in_footer'];

      /* Register admin scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue admin scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Filter localize scripts
     *
     * @since   1.0.0
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'source_framework_localize_scripts', array() );

    wp_localize_script( 'source-framework-admin', 'SMGDevTools', $localize_script );
  }

}
