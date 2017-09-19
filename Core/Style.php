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
use SourceFramework\Template\Tag;

/**
 * Style class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Style extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           SourceFrameworkPublic
   */
  protected static $instance;

  /**
   * Array of handlers of styles to add <code>integrity</code> property;
   * @var array
   */
  private $style_integrity_handles = [];

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
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );

    /**
     * Check handle names to add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes;
     * @since   1.0.0
     */
    add_action( 'wp_print_styles', [ $this, 'print_styles' ], 1 );

    /**
     * Add <code>integrity</code>, <code>async</code> and/or <code>defer</code> attributes to tag if is enabled
     * @since   1.0.0
     */
    add_action( 'style_loader_tag', [ $this, 'style_loader_tag' ], 20, 2 );
  }

  /**
   * Register admin styles
   *
   * @since 1.0.0
   */
  private function register_admin_styles() {
    $styles = [
        'source-framework-admin' => [
            'local'    => plugins_url( 'assets/css/admin.css', \SourceFramework\PLUGIN_FILE ),
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
        'wordpress-core'   => [
            'local'    => plugins_url( 'assets/css/wordpress-core.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'autoload' => !is_admin()
        ],
        'source-framework' => [
            'local'    => plugins_url( 'assets/css/public.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'deps'     => [ 'wordpress-core' ],
            'autoload' => !is_admin()
        ],
        'fontawesome'      => [
            'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            'ver'    => '4.7.0',
        ],
        'ionicons'         => [
            'remote' => '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
            'ver'    => '2.0.1',
        ],
        'animate'          => [
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'       => '3.5.2',
            'integrity' => 'sha256-j+P6EZJVrbXgwSR5Mx+eCS6FvP9Wq27MBRC/ogVriY0=',
            'media'     => 'screen',
        ],
        'hover'            => [
            'remote'    => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.1/css/hover-min.css',
            'ver'       => '2.1.1',
            'integrity' => 'sha256-JdAl3R4Di+wuzDEa1a878QE+aqnlP4KeHc5z1qAzQa4=',
            'media'     => 'screen',
        ],
        'bootstrap3'       => [
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'ver'       => '3.3.7',
            'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
        ],
        'bootstrap4'       => [
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css',
            'ver'       => '4.0.0-beta',
            'integrity' => 'sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M',
        ],
        'bootstrap-extend' => [
            'local' => plugins_url( 'assets/css/bootstrap-extended.css', \SourceFramework\PLUGIN_FILE ),
            'ver'   => \SourceFramework\VERSION,
            'deps'  => [ 'bootstrap' ],
        ],
        'frontend-helper'  => [
            'local'    => plugins_url( 'assets/css/frontend-helper.css', \SourceFramework\PLUGIN_FILE ),
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

    foreach ( $this->styles as $handle => &$style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      if ( !empty( $style['integrity'] ) ) {
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
      $tag  = str_replace( ' />', ' ' . Tag::parse_attributes( $attr ) . ' />', $tag );
    }

    return $tag;
  }

}
