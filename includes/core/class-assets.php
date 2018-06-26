<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\Settings_Group;
use SourceFramework\Template\Html;

/**
 * Assets class
 *
 * @package        Core
 * @subpackage     Assets
 * @since          1.5.0
 * @author         Javier Prieto
 */
class Assets extends Singleton {

  const BS_VER = '4.1.1';
  const FA_VER = '5.1.0';

  /**
   * Single instance of this class
   *
   * @since     1.0.0
   * @var       Assets
   */
  protected static $instance;

  /**
   * Array of handlers of styles to add <code>integrity</code> property;
   *
   * @since     1.0.0
   * @var       array
   */
  private $style_integrity_handles = [];

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   *
   * @since     1.0.0
   * @var       array
   */
  private $scripts = [];

  /**
   * Array of handlers of scritps to add <code>integrity</code> property;
   *
   * @since     1.0.0
   * @var       array
   */
  private $script_integrity_handles = [];

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   *
   * @since     1.0.0
   * @var       array
   */
  private $script_async_handles = [];

  /**
   * Array of handlers of scritps to add <code>defer</code> property;
   *
   * @since     1.0.0
   * @var       array
   */
  private $script_defer_handles = [];

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     1.0.0
   */
  protected function __construct() {
    parent::__construct();

    // Register and enqueue styles
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );

    // Register and enqueue scripts
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'localize_scripts' ] );

    // Check handle names to add integrity, async and/or defer attributes
    add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1 );
    add_action( 'wp_print_scripts', [ $this, 'print_scripts' ], 1 );

    // Add integrity, async and/or defer attributes to tag if is enabled
    add_action( 'style_loader_tag', [ $this, 'style_loader_tag' ], 20, 2 );
    add_action( 'script_loader_tag', [ $this, 'script_loader_tag' ], 20, 2 );
  }

  /**
   * Register admin styles
   *
   * @since   1.0.0
   *
   * @return  array
   */
  private function register_admin_styles() {
    $styles = [
        'source-framework-admin' => [
            'local'    => plugins_url( 'assets/css/admin.css', SF_FILENAME ),
            'ver'      => SF_VERSION,
            'autoload' => true
        ],
    ];

    return apply_filters( 'register_admin_styles', $styles );
  }

  /**
   * Register public styles
   *
   * @since   1.0.0
   *
   * @return  array
   */
  private function register_styles() {
    global $tools_setting_group;

    if ( empty( $tools_setting_group ) ) {
      $tools_setting_group = new Settings_Group( 'tools_settings' );
    }

    $styles = [
        'bootstrap'                   => [
            'remote'   => 'https://maxcdn.bootstrapcdn.com/bootstrap/' . self::BS_VER . '/css/bootstrap.min.css',
            'ver'      => self::BS_VER,
            'autoload' => true,
        ],
        'fontawesome-all'             => [
            'remote' => 'https://use.fontawesome.com/releases/v' . self::FA_VER . '/css/all.css',
            'ver'    => self::FA_VER,
        ],
        'fontawesome'                 => [
            'remote' => 'https://use.fontawesome.com/releases/v' . self::FA_VER . '/css/fontawesome.css',
            'ver'    => self::FA_VER,
        ],
        'fontawesome-brands'          => [
            'remote' => 'https://use.fontawesome.com/releases/v' . self::FA_VER . '/css/brands.css',
            'deps'   => [ 'fontawesome' ],
            'ver'    => self::FA_VER,
        ],
        'fontawesome-regular'         => [
            'remote' => 'https://use.fontawesome.com/releases/v' . self::FA_VER . '/css/regular.css',
            'deps'   => [ 'fontawesome' ],
            'ver'    => self::FA_VER,
        ],
        'fontawesome-solid'           => [
            'remote' => 'https://use.fontawesome.com/releases/v' . self::FA_VER . '/css/solid.css',
            'deps'   => [ 'fontawesome' ],
            'ver'    => self::FA_VER,
        ],
        'source-framework'            => [
            'local'    => plugins_url( 'assets/css/public.css', SF_FILENAME ),
            'ver'      => SF_VERSION,
            'autoload' => true,
        ],
        'wordpress-content'           => [
            'local'    => plugins_url( 'assets/css/wordpress-content.css', SF_FILENAME ),
            'ver'      => SF_VERSION,
            'autoload' => true,
        ],
        'bootstrap-breakpoint-helper' => [
            'local'    => plugins_url( 'assets/css/bootstrap-breakpoint-helper.css', SF_FILENAME ),
            'ver'      => SF_VERSION,
            'autoload' => get_theme_mod( 'bootstrap-breakpoint-helper', false ),
        ],
    ];

    $has_node_modules = file_exists( plugin_dir_path( SF_FILENAME ) . 'node_modules' );

    if ( $has_node_modules && file_exists( plugin_dir_path( SF_FILENAME ) . 'node_modules/bootstrap/dist/css/bootstrap.min.css' ) ) {
      $styles['bootstrap']['local'] = plugins_url( 'node_modules/bootstrap/dist/css/bootstrap.min.css', SF_FILENAME );
    }

    return apply_filters( 'register_styles', $styles );
  }

  /**
   * Register styles
   *
   * @since   1.0.0
   */
  public function enqueue_styles() {
    $this->styles = is_admin() ? $this->register_admin_styles() : $this->register_styles();
    $defaults     = [
        'local'       => '',
        'remote'      => '',
        'integrity'   => '',
        'crossorigin' => 'anonymous',
        'deps'        => [],
        'ver'         => null,
        'media'       => 'all',
        'autoload'    => false
    ];

    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new Settings_Group( 'advanced_settings' );
    }

    $use_cdn = $advanced_setting_group->get_bool_option( 'cdn-enabled' );
    $use_sri = $advanced_setting_group->get_bool_option( 'sri-enabled' );

    foreach ( $this->styles as $handle => &$style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      if ( !empty( $style['integrity'] ) && $use_sri ) {
        $this->style_integrity_handles[] = $handle;
      }

      wp_register_style( $handle, $src, (array) $style['deps'], $style['ver'], $style['media'] );

      if ( $style['autoload'] ) {
        wp_enqueue_style( $handle );
      }
    }
    unset( $style );
  }

  /**
   * Filter handle names to add <code>integrity</code> attribute
   *
   * @since   1.0.0
   */
  public function print_styles() {
    /**
     * Filter handle names of scripts to add <code>integrity</code> attribute;
     * @since   1.0.0
     */
    $style_integrity_handles       = (array) apply_filters( 'style_integrity_handless', $this->style_integrity_handles );
    $this->style_integrity_handles = array_unique( $style_integrity_handles );
  }

  /**
   * Adds <code>integrity</code> attribute to tag if is enabled
   *
   * @since   1.0.0
   *
   * @param   string    $tag
   * @param   string    $handle
   * @return  string
   */
  public function style_loader_tag( $tag, $handle ) {
    if ( in_array( $handle, $this->style_integrity_handles ) ) {
      $attr = [
          'integrity'   => $this->styles[$handle]['integrity'],
          'crossorigin' => $this->styles[$handle]['crossorigin'],
      ];
      $tag  = str_replace( ' />', ' ' . Html::parse_attributes( $attr ) . ' />', $tag );
    }

    return $tag;
  }

  /**
   * Register admin scripts
   *
   * @since 1.0.0
   */
  private function register_admin_scripts() {
    $scripts = array(
        'source-framework-admin' => array(
            'local'     => plugins_url( 'assets/js/admin.js', SF_FILENAME ),
            'deps'      => array( 'jquery' ),
            'ver'       => SF_VERSION,
            'in_footer' => true,
            'autoload'  => true,
            'defer'     => true,
        )
    );

    return apply_filters( 'register_admin_scripts', $scripts );
  }

  /**
   * Register public scripts
   *
   * @since 1.0.0
   */
  private function register_scripts() {
    global $api_setting_group;

    if ( empty( $api_setting_group ) ) {
      $api_setting_group = new Settings_Group( 'api_settings' );
    }

    $scripts = [
        'source-framework' => [
            'local'     => plugins_url( 'assets/js/public.js', SF_FILENAME ),
            'deps'      => [ 'jquery' ],
            'ver'       => SF_VERSION,
            'in_footer' => true,
            'autoload'  => true,
            'defer'     => true,
        ],
        'popper'           => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js',
            'deps'      => [ 'jquery' ],
            'ver'       => '1.14.3',
            'in_footer' => true,
            'autoload'  => true,
        ],
        'bootstrap'        => [
            'remote'    => 'https://maxcdn.bootstrapcdn.com/bootstrap/' . self::BS_VER . '/js/bootstrap.min.js',
            'deps'      => [ 'jquery', 'popper' ],
            'ver'       => self::BS_VER,
            'in_footer' => true,
            'autoload'  => true,
        ],
    ];

    $has_node_modules = file_exists( plugin_dir_path( SF_FILENAME ) . 'node_modules' );

    if ( $has_node_modules && file_exists( plugin_dir_path( SF_FILENAME ) . 'node_modules/bootstrap/dist/js/bootstrap.min.js' ) ) {
      $scripts['bootstrap']['local'] = plugins_url( 'node_modules/bootstrap/dist/js/bootstrap.min.js', SF_FILENAME );
    }

    return apply_filters( 'register_scripts', $scripts );
  }

  /**
   * Enqueue scripts
   *
   * @since 1.0.0
   */
  public function enqueue_scripts() {
    $defaults = [
        'local'       => '',
        'remote'      => '',
        'integrity'   => '',
        'crossorigin' => 'anonymous',
        'deps'        => [],
        'ver'         => null,
        'in_footer'   => false,
        'autoload'    => false,
        'async'       => false,
        'defer'       => false,
    ];

    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new Settings_Group( 'advanced_settings' );
    }

    $use_cdn = $advanced_setting_group->get_bool_option( 'cdn-enabled' );

    $this->scripts = is_admin() ? $this->register_admin_scripts() : $this->register_scripts();

    foreach ( $this->scripts as $handle => &$script ) {
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

      if ( !empty( $script['integrity'] ) ) {
        $this->script_integrity_handles[] = $handle;
      }

      wp_register_script( $handle, $src, (array) $script['deps'], $script['ver'], (bool) $script['in_footer'] );

      if ( $script['autoload'] ) {
        wp_enqueue_script( $handle );
      }
    }
    unset( $script );
  }

  /**
   * Localize script
   *
   * @since 1.0.0
   */
  public function localize_scripts() {
    $data   = [
        'messages' => [
            'success'   => __( 'Success!', SF_TEXTDOMAIN ),
            'fail'      => __( 'Fail!', SF_TEXTDOMAIN ),
            'error'     => __( 'Error!', SF_TEXTDOMAIN ),
            'send'      => __( 'Send', SF_TEXTDOMAIN ),
            'submit'    => __( 'Submit', SF_TEXTDOMAIN ),
            'submiting' => __( 'Submiting...', SF_TEXTDOMAIN ),
            'sending'   => __( 'Sending...', SF_TEXTDOMAIN ),
            'sent'      => __( 'Sent!', SF_TEXTDOMAIN ),
        ],
    ];
    $handle = is_admin() ? 'source-framework-admin' : 'source-framework';

    wp_localize_script( $handle, 'ajaxurl', admin_url( 'admin-ajax.php' ) );
    wp_localize_script( $handle, 'SourceFrameworkLocale', apply_filters( 'source_framework_localize_scripts', $data ) );
  }

  /**
   * Filter handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes
   *
   * @since   1.0.0
   */
  public function print_scripts() {
    /**
     * Filter handle names of scripts to add <code>integrity</code> attribute;
     * @since   1.0.0
     */
    $script_integrity_handles       = (array) apply_filters( 'filter_integrity_scripts', $this->script_integrity_handles );
    $this->script_integrity_handles = array_unique( $script_integrity_handles );

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
    if ( in_array( $handle, $this->script_integrity_handles ) ) {
      $attr = [
          'integrity'   => $this->scripts[$handle]['integrity'],
          'crossorigin' => $this->scripts[$handle]['crossorigin'],
      ];
      $tag  = str_replace( '></script>', ' ' . Html::parse_attributes( $attr ) . '></script>', $tag );
    }

    if ( in_array( $handle, $this->script_async_handles ) ) {
      $tag = str_replace( '></script>', ' async></script>', $tag );
    }

    if ( in_array( $handle, $this->script_defer_handles ) ) {
      $tag = str_replace( '></script>', ' defer></script>', $tag );
    }
    return $tag;
  }

}
