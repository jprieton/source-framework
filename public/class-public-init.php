<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Public_Init class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Public_Init {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Public_Init
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
   * @since         1.0.0
   */
  protected function __sleep() {
    // Avoid Serializg of Object
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 0.5.0
   */
  public function enqueue_scripts() {
    $scripts = array(
        'source-framework' => array(
            'local'     => \SourceFramework\ABSPATH . 'assets/js/public.min.js',
            'deps'      => array( 'jquery' ),
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true
        ),
    );

    /**
     * Filter plugin scripts
     *
     * @since   0.5.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'source_framework_register_scripts', $scripts );

    $defaults = array(
        'local'     => '',
        'remote'    => '',
        'deps'      => array(),
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'cdn-enabled' );

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

      /* Register scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Filter localize scripts
     *
     * @since   0.5.0
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'source_framework_localize_scripts', array() );
    wp_localize_script( 'source-framework', 'SourceFrameworkLocale', $localize_script );
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
    $styles = array(
        'source-framework' => array(
            'local'    => \SourceFramework\ABSPATH . 'assets/css/public.css',
            'ver'      => \SourceFramework\VERSION,
            'autoload' => true
        ),
    );

    /**
     * Filter styles
     *
     * @since   1.0.0
     * @param   array   $styles
     */
    $styles = apply_filters( 'source_framework_register_styles', $styles );

    $defaults = array(
        'local'    => '',
        'remote'   => '',
        'deps'     => array(),
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'cdn-enabled' );

    foreach ( $styles as $handle => $style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      $deps  = $style['deps'];
      $ver   = $style['ver'];
      $media = $style['media'];

      /* Register styles */
      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        /* Enqueue styles if autolad in enabled */
        wp_enqueue_style( $handle );
      }
    }
  }

}
