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
 * CoreInit class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class CoreInit extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           CoreInit
   */
  protected static $instance;

  /**
   * Init plugin
   * 
   * @since 1.0.0
   */
  public static function init() {
    /**
     * Load plugin texdomain
     * @since 1.0.0
     */
    load_plugin_textdomain( SourceFramework\TEXDOMAIN, FALSE, basename( dirname( __DIR__ ) ) . '/languages/' );

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

}
