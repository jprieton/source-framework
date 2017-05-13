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
 * SourceFrameworkPublic class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class SourceFrameworkPublic extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFrameworkPublic
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

    /**
     * Shows a custom code in header of the singular template
     * @since 1.0.0
     */
    add_action( 'wp_head', [ $this, 'singular_custom_code_header_script' ] );

    /**
     * Shows a custom code on top of body
     * @since 1.0.0
     */
    add_action( 'before_main_content', [ $this, 'singular_before_main_content' ] );

    /**
     * Shows a custom code in footer of the singular template
     * @since 1.0.0
     */
    add_action( 'after_main_content', [ $this, 'singular_after_main_content' ] );

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
   * Register/enqueue scripts
   *
   * @since 1.0.0
   */
  public function scripts( $scripts ) {
    $scripts ['modernizr']                    = [
        'local'    => plugins_url( 'assets/js/modernizr.min.js' . \SourceFramework\PLUGIN_FILE ),
        'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
        'ver'      => '2.8.3',
        'autoload' => false
    ];
    $scripts ['source-framework']             = [
        'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\PLUGIN_FILE ),
        'deps'      => [ 'jquery', 'jquery-form' ],
        'ver'       => \SourceFramework\VERSION,
        'in_footer' => true,
        'autoload'  => true,
        'defer'     => true,
    ];
    $scripts ['geodatasource-country-region'] = [
        'local'     => plugins_url( 'assets/js/geodatasource-cr.min.js' . \SourceFramework\PLUGIN_FILE ),
        'remote'    => '//cdnjs.cloudflare.com/ajax/libs/country-region-dropdown-menu/1.0.1/geodatasource-cr.min.js',
        'ver'       => '1.0.1',
        'in_footer' => true,
        'autoload'  => false,
        'defer'     => true,
    ];
    return $scripts;
  }

  /**
   * Register/enqueue styles
   *
   * @since 1.0.0
   */
  public function styles( $styles ) {
    $styles['fontawesome']      = [
        'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
        'ver'    => '4.7.0',
    ];
    $styles['ionicons']         = [
        'remote' => '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'ver'    => '2.0.1',
    ];
    $styles['source-framework'] = [
        'local'    => plugins_url( 'assets/css/public.css', \SourceFramework\PLUGIN_FILE ),
        'ver'      => \SourceFramework\VERSION,
        'autoload' => true
    ];
    $styles['animate']          = [
        'local'  => plugins_url( 'assets/css/animate.min.css', \SourceFramework\PLUGIN_FILE ),
        'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        'ver'    => '3.5.2',
        'media'  => 'screen',
    ];
    $styles['hover']            = [
        'local'  => plugins_url( 'assets/css/hover.min.css', \SourceFramework\PLUGIN_FILE ),
        'remote' => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css',
        'ver'    => '2.1.0',
        'media'  => 'screen',
    ];
    return $styles;
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
  public function singular_after_main_content() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_after_main_content', true );

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
  public function singular_before_main_content() {
    if ( !(is_singular() && get_bool_option( 'enabled_singular_custom_code' )) ) {
      return;
    }

    global $post;

    $script = get_post_meta( $post->ID, '_before_main_content', true );

    if ( !empty( $script ) ) {
      echo (string) $script;
    }
  }

}
