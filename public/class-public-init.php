<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Core\Scripts;
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
    $scripts = apply_filters( 'source_framework_public_enqueue_scripts', $scripts );
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
    $styles = apply_filters( 'source_framework_public_enqueue_styles', $styles );
    do_action( 'source_framework_enqueue_styles', $styles );
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
