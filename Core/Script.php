<?php

namespace SourceFramework\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\SettingGroup;

/**
 * Script class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Script extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFrameworkPublic
   */
  protected static $instance;

  /**
   * @since         1.0.0
   * @var           SettingGroup
   */
  private $setting_group;

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
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', [ $this, 'localize_scripts' ] );

    /**
     * Check handle names to add <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1 );

    /**
     * Add <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'script_loader_tag', [ $this, 'script_loader_tag' ], 20, 2 );
  }

  /**
   * Register scripts
   *
   * @since 1.0.0
   */
  private function register_scripts() {
    $scripts = [
        'source-framework-admin'       => [
            'local'     => plugins_url( 'assets/js/admin.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => is_admin(),
            'defer'     => true,
        ],
        'source-framework'             => [
            'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\PLUGIN_FILE ),
            'deps'      => [ 'jquery', 'jquery-form' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => !is_admin(),
            'defer'     => true,
        ],
        'modernizr'                    => [
            'local'    => plugins_url( 'assets/js/modernizr.min.js', \SourceFramework\PLUGIN_FILE ),
            'remote'   => '//cdn.jsdelivr.net/modernizr/3.3.1/modernizr.min.js',
            'ver'      => '3.3.1',
            'autoload' => false,
        ],
        'bootstrap'                    => [
            'local'    => plugins_url( 'assets/js/bootstrap.min.js', \SourceFramework\PLUGIN_FILE ),
            'remote'   => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            'ver'      => '3.3.7',
            'autoload' => false,
        ],
        'jquery-appear'                => [
            'local'     => plugins_url( 'assets/js/jquery.appear.min.js', \SourceFramework\PLUGIN_FILE ),
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/jquery.appear/0.3.3/jquery.appear.min.js',
            'deps'      => [ 'jquery' ],
            'ver'       => '0.3.3',
            'in_footer' => true,
            'autoload'  => false
        ],
        'geodatasource-country-region' => [
            'local'     => plugins_url( 'assets/js/geodatasource-cr.min.js', \SourceFramework\PLUGIN_FILE ),
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/country-region-dropdown-menu/1.0.1/geodatasource-cr.min.js',
            'ver'       => '1.0.1',
            'in_footer' => true,
            'autoload'  => false,
            'defer'     => true,
        ]
    ];

    $filter = is_admin() ? 'source_framework_admin_scripts' : 'source_framework_scripts';

    return apply_filters( $filter, $scripts );
  }

  /**
   * Enqueue scripts
   *
   * @since 1.0.0
   */
  public function enqueue_scripts() {
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

    if ( empty( $this->setting_group ) ) {
      $this->setting_group = new SettingGroup( 'source-framework' );
    }

    $use_cdn = $this->setting_group->get_bool_option( 'cdn-enabled' );

    $scripts = $this->register_scripts();
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

      wp_register_script( $handle, $src, (array) $script['deps'], $script['ver'], (bool) $script['in_footer'] );

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
    $data   = array(
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
    $handle = is_admin() ? 'source-framework-admin' : 'source-framework';

    wp_localize_script( $handle, 'SourceFrameworkLocale', apply_filters( 'source_framework_localize_scripts', $data ) );
  }

  /**
   * Filter handle names to add <code>async</code> and/or <code>defer</code> attributes
   *
   * @since   1.0.0
   */
  public function print_scripts() {
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
