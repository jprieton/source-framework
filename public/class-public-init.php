<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use WP_Post;

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
    $scripts = [
        'modernizr'        => [
            'local'    => SMGDEVTOOLS_URL . 'assets/js/modernizr.min.js',
            'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
            'ver'      => '2.8.3',
            'autoload' => false
        ],
        'source-framework' => [
            'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery', 'jquery-form' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true,
        ],
    ];

    /**
     * Filter plugin scripts
     *
     * @since   0.5.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'source_framework_enqueue_scripts', $scripts );

    $defaults = [
        'local'     => '',
        'remote'    => '',
        'deps'      => [],
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    ];

    $use_cdn = get_bool_option( 'cdn-enabled', false );

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
    $localize_script = apply_filters( 'source_framework_localize_scripts', [] );
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
    $styles = [
        'fontawesome'      => [
            'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            'ver'    => '4.7.0',
        ],
        'ionicons'         => [
            'remote' => '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
            'ver'    => '2.0.1',
        ],
        'source-framework' => [
            'local'    => plugins_url( 'assets/css/public.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'autoload' => true
        ],
        'animate'          => [
            'local'  => plugins_url( 'assets/css/animate.min.css', \SourceFramework\PLUGIN_FILE ),
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'    => '3.5.2',
            'media'  => 'screen',
        ],
        'hover'            => [
            'local'  => plugins_url( 'assets/css/hover.min.css', \SourceFramework\PLUGIN_FILE ),
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css',
            'ver'    => '2.1.0',
            'media'  => 'screen',
        ],
    ];

    /**
     * Filter styles
     *
     * @since   1.0.0
     * @param   array   $styles
     */
    $styles = apply_filters( 'source_framework_enqueue_styles', $styles );

    $defaults = array(
        'local'    => '',
        'remote'   => '',
        'deps'     => [],
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    );

    $use_cdn = get_bool_option( 'cdn-enabled', false );

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

  /**
   * Shows a custom code in header of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_custom_code_header_script() {
    if ( !is_singular() || !get_bool_option( 'enabled_singular_custom_code' ) ) {
      return;
    }

    global $post;

    $header_script = get_post_meta( $post->ID, '_header_custom_code', true );

    if ( !empty( $header_script ) ) {
      echo (string) $header_script;
    }
  }

  /**
   * Shows a custom code in footer of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_custom_code_footer_script() {
    if ( !is_singular() || !get_bool_option( 'enabled_singular_custom_code' ) ) {
      return;
    }

    global $post;

    $footet_script = get_post_meta( $post->ID, '_footer_custom_code', true );

    if ( !empty( $footet_script ) ) {
      echo (string) $footet_script;
    }
  }

}
