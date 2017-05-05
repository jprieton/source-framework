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
 * PublicInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class PublicInit extends Singleton {

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
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 0 );

    /**
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 0 );

    /**
     * Localize script
     * @since 1.0.0
     */
    add_filter( 'source_framework_localize_scripts', [ $this, 'localize_scripts' ] );

    /**
     * Shows a custom code in header of the singular template
     * @since 1.0.0
     */
    add_action( 'wp_head', [ $this, 'singular_custom_code_header_script' ] );

    /**
     * Shows a custom code on top of body
     * @since 1.0.0
     */
    add_action( 'before_main_content', [ $this, 'singular_custom_code_body_script' ] );

    /**
     * Shows a custom code in footer of the singular template
     * @since 1.0.0
     */
    add_action( 'wp_footer', [ $this, 'singular_custom_code_footer_script' ] );

    /**
     * Add shortcodes
     * @since 1.0.0
     */
    $this->add_shorcodes();
  }

  /**
   * Add shortcodes
   *
   * @since 1.0.0
   */
  public function add_shorcodes() {
    /**
     * Add an ofuscate mailto link to prevent spam-bots from sniffing it.
     * @since 1.0.0
     */
    add_shortcode( 'mailto', [ 'SourceFramework\Template\Shortcode', 'mailto' ] );
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 1.0.0
   */
  public function enqueue_scripts() {
    $scripts = [
        'modernizr'                    => [
            'local'    => plugins_url( 'assets/js/modernizr.min.js' . \SourceFramework\PLUGIN_FILE ),
            'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
            'ver'      => '2.8.3',
            'autoload' => false
        ],
        'source-framework'             => [
            'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery', 'jquery-form' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => true,
        ],
        'geodatasource-country-region' => [
            'local'     => plugins_url( 'assets/js/geodatasource-cr.min.js' . \SourceFramework\PLUGIN_FILE ),
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/country-region-dropdown-menu/1.0.1/geodatasource-cr.min.js',
            'ver'       => '1.0.1',
            'in_footer' => true,
            'autoload'  => false
        ],
    ];

    /**
     * Filter plugin scripts
     *
     * @since   1.0.0
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
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_header_custom_code', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
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
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_footer_custom_code', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

  /**
   * Shows a custom code in top of body of the singular template
   *
   * @since 1.0.0
   *
   * @global WP_Post $post
   */
  public function singular_custom_code_body_script() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_body_custom_code', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

}
