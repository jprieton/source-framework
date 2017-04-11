<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Core_Init class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class Core_Init {

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
   * Register and optionally enqueue styles
   * @since   1.0.0
   */
  public static function register_styles( $styles ) {

    $defaults = [
        'local' => '',
        'remote' => '',
        'deps' => [],
        'ver' => null,
        'media' => 'all',
        'autoload' => false
    ];

    $use_cdn = get_bool_option( 'enable-cdn' );

    foreach ( $styles as $handle => $style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      $deps = $style['deps'];
      $ver = $style['ver'];
      $media = $style['media'];

      /* Register styles */
      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        /* Enqueue styles if autolad in enabled */
        wp_enqueue_style( $handle );
      }
    }
  }

  /**
   * Register and optionally enqueue scripts
   * @since   1.0.0
   */
  public static function register_scripts( $scripts ) {
    $defaults = [
        'local' => '',
        'remote' => '',
        'deps' => [],
        'ver' => null,
        'in_footer' => false,
        'autoload' => false
    ];

    $use_cdn = get_bool_option( 'enable-cdn' );

    foreach ( $scripts as $handle => $script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      $deps = $script['deps'];
      $ver = $script['ver'];
      $in_footer = $script['in_footer'];

      /* Register admin scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Filter localize scripts
     *
     * @since   1.0.0
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'source_framework_localize_scripts', [] );

    wp_localize_script( 'source-framework-admin', 'SourceFrameworkLocale', $localize_script );
  }

  /**
   * Localize script
   * @since 1.0.0
   */
  public static function localize_scripts() {
    $localize_script = array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'messages' => array(
            'success' => __( 'Success!', \SourceFramework\TEXDOMAIN ),
            'fail' => __( 'Fail!', \SourceFramework\TEXDOMAIN ),
            'error' => __( 'Error!', \SourceFramework\TEXDOMAIN ),
            'send' => __( 'Send', \SourceFramework\TEXDOMAIN ),
            'submit' => __( 'Submit', \SourceFramework\TEXDOMAIN ),
            'sending' => __( 'Sending...', \SourceFramework\TEXDOMAIN ),
            'sent' => __( 'Sent!', \SourceFramework\TEXDOMAIN ),
        )
    );
    return $localize_script;
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
