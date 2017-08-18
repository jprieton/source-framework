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
   * @since         1.0.0
   * @var           SettingGroup
   */
  private $setting_group;

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
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
  }

  /**
   * Register styles
   *
   * @since 1.0.0
   */
  private function register_styles() {
    $styles = [
        'source-framework-admin' => [
            'local'    => plugins_url( 'assets/css/admin.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'autoload' => is_admin()
        ],
        'wordpress-core'         => [
            'local' => plugins_url( 'assets/css/wordpress-core.css', \SourceFramework\PLUGIN_FILE ),
            'ver'   => \SourceFramework\VERSION,
        ],
        'source-framework'       => [
            'local'    => plugins_url( 'assets/css/public.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'deps'     => [ 'wordpress-core' ],
            'autoload' => !is_admin()
        ],
        'fontawesome'            => [
            'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
            'ver'    => '4.7.0',
        ],
        'ionicons'               => [
            'remote' => '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
            'ver'    => '2.0.1',
        ],
        'animate'                => [
            'local'  => plugins_url( 'assets/css/animate.min.css', \SourceFramework\PLUGIN_FILE ),
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'    => '3.5.2',
            'media'  => 'screen',
        ],
        'hover'                  => [
            'local'  => plugins_url( 'assets/css/hover.min.css', \SourceFramework\PLUGIN_FILE ),
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.0/css/hover-min.css',
            'ver'    => '2.1.0',
            'media'  => 'screen',
        ],
        'bootstrap'              => [
            'remote' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'ver'    => '3.3.7',
        ],
        'bootstrap-extend'       => [
            'local' => plugins_url( 'assets/css/bootstrap-extended.css', \SourceFramework\PLUGIN_FILE ),
            'ver'   => \SourceFramework\VERSION,
            'deps'  => [ 'bootstrap' ],
        ],
        'frontend-helper'        => [
            'local'    => plugins_url( 'assets/css/frontend-helper.css', \SourceFramework\PLUGIN_FILE ),
            'ver'      => \SourceFramework\VERSION,
            'media'    => 'screen',
            'autoload' => false,
        ],
    ];

    $filter = is_admin() ? 'source_framework_admin_styles' : 'source_framework_styles';

    return apply_filters( $filter, $styles );
  }

  /**
   * Register styles
   *
   * @since   1.0.0
   */
  public function enqueue_styles( $styles ) {
    $styles   = $this->register_styles();
    $defaults = [
        'local'    => '',
        'remote'   => '',
        'deps'     => [],
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    ];

    if ( empty( $this->setting_group ) ) {
      $this->setting_group = new SettingGroup( 'source-framework' );
    }

    $use_cdn = $this->setting_group->get_bool_option( 'cdn-enabled' );

    foreach ( $styles as $handle => $style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      wp_register_style( $handle, $src, (array) $style['deps'], $style['ver'], $style['media'] );

      if ( $style['autoload'] ) {
        wp_enqueue_style( $handle );
      }
    }
  }

}
