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
use SourceFramework\Template\Html;

/**
 * Assets class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.5.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Assets extends Singleton {

  /**
   * Static instance of this class
   * @since         1.0.0
   * @var           Assets
   */
  protected static $instance;

  /**
   * Base address to jsDelivr CDN
   * @since         1.5.0
   * @var           Assets
   */
  private $cdn_jsdelivr = 'https://cdn.jsdelivr.net/gh/jprieton/source-framework@';

  /**
   * Array of handlers of styles to add <code>integrity</code> property;
   *
   * @since         1.0.0
   * @var           array
   */
  private $style_integrity_handles = [];

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   *
   * @since         1.0.0
   * @var           array
   */
  private $scripts = [];

  /**
   * Array of handlers of scritps to add <code>integrity</code> property;
   *
   * @since         1.0.0
   * @var           array
   */
  private $script_integrity_handles = [];

  /**
   * Array of handlers of scritps to add <code>async</code> property;
   *
   * @since         1.0.0
   * @var           array
   */
  private $script_async_handles = [];

  /**
   * Array of handlers of scritps to add <code>defer</code> property;
   *
   * @since         1.0.0
   * @var           array
   */
  private $script_defer_handles = [];

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the <code>new</code> operator.
   *
   * @since         1.0.0
   */
  protected function __construct() {
    parent::__construct();

    /**
     * Register and enqueue styles
     * @since   1.0.0
     */
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );

    /**
     * Check handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_styles', array( $this, 'print_styles' ), 1 );

    /**
     * Add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'style_loader_tag', array( $this, 'style_loader_tag' ), 20, 2 );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    /**
     * Register and enqueue scripts
     * @since   1.0.0
     */
    add_action( 'wp_enqueue_scripts', array( $this, 'localize_scripts' ) );

    /**
     * Check handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_scripts', array( $this, 'print_scripts' ), 1 );

    /**
     * Add <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'script_loader_tag', array( $this, 'script_loader_tag' ), 20, 2 );
  }

  /**
   * Register admin styles
   *
   * @since 1.0.0
   */
  private function register_admin_styles() {
    $styles = [
        'source-framework-admin' => [
            'local'    => plugins_url( 'assets/css/admin.css', \SourceFramework\FILE ),
            'remote'   => $this->cdn_jsdelivr . \SourceFramework\VERSION . '/assets/css/admin.min.css',
            'ver'      => \SourceFramework\VERSION,
            'autoload' => is_admin()
        ],
    ];

    return apply_filters( 'register_admin_styles', $styles );
  }

  /**
   * Register public styles
   *
   * @since 1.0.0
   */
  private function register_styles() {
    global $tools_setting_group;

    if ( empty( $tools_setting_group ) ) {
      $tools_setting_group = new SettingGroup( 'tools_settings' );
    }

    $styles = [
        'hentry'           => [
            'local'    => plugins_url( 'assets/css/hentry.css', \SourceFramework\FILE ),
            'remote'   => $this->cdn_jsdelivr . \SourceFramework\VERSION . '/assets/css/hentry.css',
            'ver'      => \SourceFramework\VERSION,
            'autoload' => !is_admin()
        ],
        'source-framework' => [
            'local'    => plugins_url( 'assets/css/public.css', \SourceFramework\FILE ),
            'remote'   => $this->cdn_jsdelivr . \SourceFramework\VERSION . '/assets/css/public.min.css',
            'ver'      => \SourceFramework\VERSION,
            'deps'     => [ 'hentry' ],
            'autoload' => !is_admin()
        ],
        'font-awesome'     => [
            'remote'    => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            'ver'       => '4.7.0',
            'integrity' => 'sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN',
        ],
        'ionicons'         => [
            'remote' => 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
            'ver'    => '2.0.1',
        ],
        'animate'          => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'       => '3.5.2',
            'integrity' => 'sha256-j+P6EZJVrbXgwSR5Mx+eCS6FvP9Wq27MBRC/ogVriY0=',
            'media'     => 'screen',
        ],
        'hover'            => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.1/css/hover-min.css',
            'ver'       => '2.1.1',
            'integrity' => 'sha256-JdAl3R4Di+wuzDEa1a878QE+aqnlP4KeHc5z1qAzQa4=',
            'media'     => 'screen',
        ],
        'owl-carousel'     => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css',
            'ver'       => '2.2.1',
            'integrity' => 'sha256-AWqwvQ3kg5aA5KcXpX25sYKowsX97sTCTbeo33Yfyk0=',
        ],
        'bootstrap3'       => [
            'remote'    => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'ver'       => '3.3.7',
            'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
        ],
        'bootstrap4'       => [
            'remote'    => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
            'ver'       => '4.0.0',
            'integrity' => 'sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm',
        ],
        'bootstrap-extend' => [
            'local' => plugins_url( 'assets/css/bootstrap-extended.css', \SourceFramework\FILE ),
            'ver'   => \SourceFramework\VERSION,
            'deps'  => [ 'bootstrap' ],
        ],
        'frontend-helper'  => [
            'local'    => plugins_url( 'assets/css/frontend-helper.css', \SourceFramework\FILE ),
            'ver'      => \SourceFramework\VERSION,
            'media'    => 'screen',
            'autoload' => in_array( $tools_setting_group->get_option( 'frontend-helper-enabled' ), [ 'bootstrap3x', 'bootstrap4x' ] ),
        ],
    ];

    return apply_filters( 'register_styles', $styles );
  }

  /**
   * Register styles
   *
   * @since   1.0.0
   */
  public function enqueue_styles( $styles ) {
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
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
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
            'local'     => plugins_url( 'assets/js/admin.js', \SourceFramework\FILE ),
            'deps'      => array( 'jquery' ),
            'ver'       => \SourceFramework\VERSION,
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
      $api_setting_group = new SettingGroup( 'api_settings' );
    }

    $scripts = [
        'source-framework'             => [
            'local'     => plugins_url( 'assets/js/public.js', \SourceFramework\FILE ),
            'remote'    => $this->cdn_jsdelivr . \SourceFramework\VERSION . '/assets/js/public.min.js',
            'deps'      => [ 'jquery' ],
            'ver'       => \SourceFramework\VERSION,
            'in_footer' => true,
            'autoload'  => !is_admin(),
            'defer'     => true,
        ],
        'modernizr'                    => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
            'integrity' => 'sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=',
            'ver'       => '2.8.3',
            'autoload'  => false,
            'async'     => true,
            'defer'     => true,
        ],
        'recaptcha'                    => [
            'remote'    => 'http://www.google.com/recaptcha/api.js',
            'in_footer' => true,
            'autoload'  => !empty( $api_setting_group->get_option( 'recaptcha-site-key' ) ),
            'async'     => true,
            'defer'     => true,
        ],
        'popper'                       => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
            'integrity' => 'sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q',
            'deps'      => [ 'jquery' ],
            'ver'       => '1.11.0',
        ],
        'bootstrap4'                   => [
            'remote'    => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
            'integrity' => 'sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl',
            'deps'      => [ 'jquery', 'popper' ],
            'ver'       => '4.0.0',
        ],
        'owl-carousel'                 => [
            'remote'    => 'http://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js',
            'ver'       => '2.2.1',
            'integrity' => 'sha256-s5TTOyp+xlSmsDfr/aZhg0Gz+JejYr5iTJI8JxG1SkM=',
        ],
        'jquery-appear'                => [
            'remote'    => 'http://cdnjs.cloudflare.com/ajax/libs/jquery.appear/0.3.3/jquery.appear.min.js',
            'integrity' => 'sha256-VjbcbgNl0a7ldRQNPhmkEpW0GxCHnr52pGVkVjpnfSM=',
            'deps'      => [ 'jquery' ],
            'ver'       => '0.3.3',
            'in_footer' => true,
        ],
        'geodatasource-country-region' => [
            'remote'    => 'https://cdnjs.cloudflare.com/ajax/libs/country-region-dropdown-menu/1.2.0/geodatasource-cr.min.js',
            'integrity' => 'sha256-6ENYmFCxl6Qnjv3oTdqdR7WAvysKv878M6UvTReEorM=',
            'ver'       => '1.2.0',
            'in_footer' => true,
            'defer'     => true,
        ]
    ];

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
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
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
