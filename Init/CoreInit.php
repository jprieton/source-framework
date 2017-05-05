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
 * Core class
 *
 * @package        SourceFramework
 * @subpackage     Init
 *
 * @since          1.0.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class CoreInit extends Singleton {

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
     * Load plugin texdomain
     * @since 1.0.0
     */
    add_action( 'init', [ $this, 'plugin_textdomain' ] );

    /**
     * Enable theme suports
     * @since 1.0.0
     */
    add_action( 'init', [ $this, 'theme_supports' ] );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'source_framework_register_scripts', [ $this, 'register_scripts' ] );

    /**
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_action( 'source_framework_register_styles', [ $this, 'register_styles' ] );

    /**
     * Localize script
     * @since 1.0.0
     */
    add_filter( 'source_framework_localize_scripts', [ $this, 'localize_scripts' ] );
  }

  /**
   * Load plugin texdomain
   * 
   * @since 1.0.0
   */
  public function plugin_textdomain() {
    load_plugin_textdomain( \SourceFramework\TEXDOMAIN, FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );
  }

  /**
   * Enable theme suports
   * 
   * @since 1.0.0
   */
  public function theme_supports() {
    /**
     * Enables Post Formats support for a theme. 
     * @since 1.0.0
     */
    add_theme_support( 'post-formats' );

    /**
     * This feature enables Post Thumbnails support for a theme. 
     * @since 1.0.0
     */
    add_theme_support( 'post-thumbnails' );

    /**
     * Enables plugins and themes to manage the document title tag. 
     * @since 1.0.0
     */
    add_theme_support( 'title-tag' );

    /**
     * enables Automatic Feed Links for post and comment in the head.
     * @since 1.0.0
     */
    add_theme_support( 'automatic-feed-links' );
  }

  /**
   * Register and enqueue plugin scripts
   *
   * @since 1.0.0
   */
  public function register_scripts( $scripts ) {
    $defaults = [
        'local'     => '',
        'remote'    => '',
        'deps'      => [],
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    ];

    $use_cdn = get_bool_option( 'use_cdn' );

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

      /**
       *  Register scripts
       */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /**
         * Enqueue scripts
         */
        wp_enqueue_script( $handle );
      }
    }
  }

  /**
   * Localize script
   * 
   * @since 1.0.0
   */
  public function localize_scripts() {
    $localize_script = array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'messages' => array(
            'success'   => __( 'Success!', \SourceFramework\TEXDOMAIN ),
            'fail'      => __( 'Fail!', \SourceFramework\TEXDOMAIN ),
            'error'     => __( 'Error!', \SourceFramework\TEXDOMAIN ),
            'send'      => __( 'Send', \SourceFramework\TEXDOMAIN ),
            'submit'    => __( 'Submit', \SourceFramework\TEXDOMAIN ),
            'submiting' => __( 'Submiting...', \SourceFramework\TEXDOMAIN ),
            'sending'   => __( 'Sending...', \SourceFramework\TEXDOMAIN ),
            'sent'      => __( 'Sent!', \SourceFramework\TEXDOMAIN ),
        )
    );
    return $localize_script;
  }

  /**
   * Register and enqueue plugin styles
   * 
   * @since   1.0.0
   */
  public function register_styles( $styles ) {

    $defaults = [
        'local'    => '',
        'remote'   => '',
        'deps'     => [],
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    ];

    $use_cdn = get_bool_option( 'use_cdn' );

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

      // Register styles
      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        // Enqueue styles if autolad in enabled
        wp_enqueue_style( $handle );
      }
    }
  }

}
