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
use SourceFramework\Core\FrontEnd;

/**
 * Init class
 *
 * @package     SourceFramework
 * @subpackage  Core
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
final class Init extends Singleton {

  /**
   * Static instance of this class
   *
   * @since         1.0.0
   * @var           Init
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
     * This hook is called once any activated plugins have been loaded
     * @since 1.0.0
     */
    add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );

    /**
     * This hook check if is enabled cli and filter hook action
     * @since 1.0.0
     */
    $this->enable_cli_commands();

    add_action( 'after_setup_theme', [ $this, 'theme_support' ] );

    /**
     * Add Filter to allow to plugins/themes add/override social networks
     * @since 1.0.0
     */
    add_filter( 'social_networks', [ $this, 'social_networks' ], 0 );

    /**
     * Register custom post types
     * @since 1.0.0
     */
    $this->register_custom_post_types();

    if ( is_admin() ) {
      /**
       * Initialize admin
       * @since   1.0.0
       */
      Admin::get_instance();
    } else {
      /**
       * Initialize public
       * @since   1.0.0
       */
      FrontEnd::get_instance();
      SourceFrameworkPublic::get_instance();
    }
  }

  /**
   * This hook is called once any activated plugins have been loaded
   *
   * @since 1.0.0
   */
  public function load_plugin_textdomain() {
    /**
     * Load plugin textdomain
     * @since 1.0.0
     */
    load_plugin_textdomain( \SourceFramework\TEXTDOMAIN, FALSE, basename( dirname( \SourceFramework\BASENAME ) ) . '/languages/' );
  }

  public function theme_support() {
    /**
     * Add theme support for Featured Images
     * @since 0.5.0
     */
    add_theme_support( 'post-thumbnails' );

    /**
     * Add theme support for document Title tag
     * @since 0.5.0
     */
    add_theme_support( 'title-tag' );

    /**
     * To enable the use of a custom logo in your theme
     * @since 0.5.0
     */
    add_theme_support( 'custom-logo' );
  }

  /**
   * Check if is enabled CLI and filter hook action
   *
   * Shell example usage<br>
   * <code>
   * php /wordpress-path/wp-admin/admin-ajax.php --my_option
   * </code>
   *
   * @since 1.0.0
   * @return boolean
   */
  private function enable_cli_commands() {
    // Check if SettingGroup is instanciated
    if ( empty( $this->setting_group ) ) {
      $this->setting_group = new SettingGroup( 'source-framework' );
    }

    // Check if is enabled
    if ( !$this->setting_group->get_bool_option( 'cli_commands_enabled' ) ) {
      return false;
    }

    // CLI only
    if ( !defined( 'STDERR' ) ) {
      return false;
    }

    add_filter( 'allowed_http_origin', [ $this, 'allowed_http_origin' ] );
    return true;
  }

  /**
   * Set $_REQUEST param for use of CLI
   *
   * @since 1.0.0
   * @param array $origin
   */
  public function allowed_http_origin( $origin ) {
    $GLOBALS['_REQUEST']['action'] = 'source_framework_cli';
    return $origin;
  }

  /**
   *
   * @return array
   */
  public function social_networks() {
    $networks = [
        'social-email'       => 'Email',
        'social-facebook'    => 'Facebook',
        'social-dribbble'    => 'Dribble',
        'social-google-plus' => 'Google+',
        'social-instagram'   => 'Instagram',
        'social-linkedin'    => 'LinkedIn',
        'social-pinterest'   => 'Pinterest',
        'social-rss'         => 'RSS',
        'social-twitter'     => 'Twitter',
        'social-yelp'        => 'Yelp',
        'social-youtube'     => 'YouTube',
    ];
    return $networks;
  }

  /**
   *
   */
  public function register_custom_post_types() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    $post_types = $advanced_setting_group->get_option( 'post-types' );

    if ( empty( $post_types ) ) {
      return;
    }

    $custom_post_type_classes = [
        'office'      => 'SourceFramework\PostType\Office',
        'place'       => 'SourceFramework\PostType\Place',
        'portfolio'   => 'SourceFramework\PostType\Portfolio',
        'product'     => 'SourceFramework\PostType\Product',
        'review'      => 'SourceFramework\PostType\Review',
        'service'     => 'SourceFramework\PostType\Service',
        'slider'      => 'SourceFramework\PostType\Slider',
        'testimonial' => 'SourceFramework\PostType\Testimonial',
    ];

    if ( function_exists( 'WC' ) ) {
      unset( $custom_post_type_classes['product'] );
    }

    $custom_post_type_classes = apply_filters( 'custom_post_type_classes', $custom_post_type_classes );

    foreach ( $custom_post_type_classes as $key => $class_name ) {
      if ( in_array( $key, $post_types ) ) {
        new $class_name;
      }
    }
  }

}
