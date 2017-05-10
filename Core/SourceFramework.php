<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\Setting;

/**
 * SourceFramework class
 *
 * @package     SourceFramework
 * @subpackage  Core
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
class SourceFramework extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFramework
   */
  protected static $instance;

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   * @var array
   */
  private $script_async_handles = [];

  /**
   * Array of handlers of scritps to add <code>defer</code> property;
   * @var array
   */
  private $script_defer_handles = [];

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * This hook is called once any activated plugins have been loaded
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );

    /**
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'localize_scripts' ] );

    /**
     * Check handle names to add <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_scripts', [ $this, 'wp_print_scripts' ], 1 );

    /**
     * Add <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'script_loader_tag', [ $this, 'script_loader_tag' ], 20, 2 );

    if ( is_admin() ) {
      /**
       * Initialize admin
       * @since   1.0.0
       */
      Admin::get_instance();
    }
  }

  /**
   * This hook is called once any activated plugins have been loaded
   *
   * @since 1.0.0
   */
  public function plugins_loaded() {
    /**
     * Load plugin textdomain
     * @since 1.0.0
     */
    load_plugin_textdomain( \SourceFramework\TEXTDOMAIN, FALSE, basename( dirname( \SourceFramework\BASENAME ) ) . '/languages/' );
  }

  /**
   * Register scripts
   *
   * @since 1.0.0
   */
  public function scripts() {
    $scripts  = apply_filters( 'source_framework_scripts', [] );
    $defaults = [
        'local'     => '',
        'remote'    => '',
        'deps'      => [],
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false,
        'async'     => false,
        'defer'     => false,
    ];

    $use_cdn = Setting::get_bool_option( 'use_cdn' );

    foreach ( $scripts as $handle => $script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      if ( $script['async'] ) {
        $this->script_async_handles[] = $handle;
      }

      if ( $script['defer'] ) {
        $this->script_defer_handles[] = $handle;
      }

      $deps      = $script['deps'];
      $ver       = $script['ver'];
      $in_footer = $script['in_footer'];

      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
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
    $data = array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'messages' => array(
            'success'   => __( 'Success!', \SourceFramework\TEXTDOMAIN ),
            'fail'      => __( 'Fail!', \SourceFramework\TEXTDOMAIN ),
            'error'     => __( 'Error!', \SourceFramework\TEXTDOMAIN ),
            'send'      => __( 'Send', \SourceFramework\TEXTDOMAIN ),
            'submit'    => __( 'Submit', \SourceFramework\TEXTDOMAIN ),
            'submiting' => __( 'Submiting...', \SourceFramework\TEXTDOMAIN ),
            'sending'   => __( 'Sending...', \SourceFramework\TEXTDOMAIN ),
            'sent'      => __( 'Sent!', \SourceFramework\TEXTDOMAIN ),
        )
    );
    wp_localize_script( 'source-framework', 'SourceFrameworkLocale', apply_filters( 'source_framework_localize_scripts', $data ) );
  }

  /**
   * Register styles
   *
   * @since   1.0.0
   */
  public function styles( $styles ) {
    $styles   = apply_filters( 'source_framework_styles', [] );
    $defaults = [
        'local'    => '',
        'remote'   => '',
        'deps'     => [],
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    ];

    $use_cdn = Setting::get_bool_option( 'use_cdn' );

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

      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        wp_enqueue_style( $handle );
      }
    }
  }

  /**
   * Filter handle names to add <code>async</code> and/or <code>defer</code> attributes
   *
   * @since   1.0.0
   */
  public function wp_print_scripts() {
    /**
     * Filter handle names of scripts to add <code>async</code> attribute;
     * @since   1.0.0
     */
    $script_async_handles       = (array) apply_filters( 'filter_async_scripts', $this->script_async_handles );
    $this->script_async_handles = array_unique( $script_async_handles );

    /**
     * Filter handle names of scripts to add <code>defer</code> attribute;
     * @since   1.0.0
     */
    $script_defer_handles       = (array) apply_filters( 'filter_defer_scripts', $this->script_defer_handles );
    $this->script_defer_handles = array_unique( $script_defer_handles );
  }

  /**
   * Adds <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
   *
   * @since   1.0.0
   *
   * @param   string    $tag
   * @param   string    $handle
   * @return  string
   */
  public function script_loader_tag( $tag, $handle ) {
    if ( in_array( $handle, $this->script_async_handles ) ) {
      $tag = str_replace( '></script>', ' async></script>', $tag );
    }

    if ( in_array( $handle, $this->script_defer_handles ) ) {
      $tag = str_replace( '></script>', ' defer></script>', $tag );
    }
    return $tag;
  }

}
