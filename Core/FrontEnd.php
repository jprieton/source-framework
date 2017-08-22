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
use SourceFramework\Tools\FrontendHelper;
use SourceFramework\Template\Tag;

/**
 * Admin class
 *
 * @package        Core
 * @subpackage     Init
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class FrontEnd extends Singleton {

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
     * Disable WordPress Admin Bar in frontend for specific roles.
     * @since 1.0.0
     */
    add_action( 'init', [ $this, 'disable_admin_bar_by_role' ] );

    /**
     * Shows Google Site Verification code
     * @since 0.5.0
     */
    add_action( 'wp_head', [ $this, 'google_site_verification' ], 0 );

    /**
     * Shows Bing Site Verification code
     * @since 0.5.0
     */
    add_action( 'wp_head', [ $this, 'bing_site_verification' ], 0 );

    /**
     * Shows Facebook Pixel code before the closing <head> tag.
     * @since 0.5.0
     */
    add_action( 'wp_head', [ $this, 'facebook_pixel_code' ], 99 );

    /**
     * Shows Google Universal Analytics code before the closing <head> tag.
     * @since 0.5.0
     */
    add_action( 'wp_head', [ $this, 'google_universal_analytics' ], 99 );

    /**
     * Shows Google Universal Analytics code before the closing <head> tag.
     * @since 0.5.0
     */
    add_action( 'before_main_content', [ $this, 'google_tag_manager' ] );

    /**
     * Disable XML-RPC.
     * @since 1.0.0
     */
    $this->disable_xmlrpc();

    /**
     * Remove the EditURI/RSD link from your header.
     * @since 1.0.0
     */
    $this->remove_rsd_link();

    /**
     * Remove WordPress version number from header, feed, styles and scripts.
     * @since 1.0.0
     */
    $this->remove_wordpress_version();

    /**
     * Enables FrontEnd Helper to shows Boostrap breakpoints
     * @since 1.0.0
     */
    $this->enable_frontend_helper();

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
   * Disable WordPress Admin Bar in frontend for specific roles.
   *
   * @since 1.0.0
   */
  public function disable_admin_bar_by_role() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    $disabled_roles = (array) $advanced_setting_group->get_option( 'admin-bar-disabled', array() );
    $user           = wp_get_current_user();

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !$user ) {
      return;
    }


    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
        break;
      }
    }
  }

  /**
   * Remove the EditURI/RSD link and Windows Live Writer manifest link.
   *
   * @since 1.0.0
   */
  public function remove_rsd_link() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    if ( !$advanced_setting_group->get_bool_option( 'remove-rsd-link' ) ) {
      return;
    }

    // Remove the EditURI/RSD link from head
    remove_action( 'wp_head', 'rsd_link' );
    // Remove the Windows Live Writer manifest link from head
    remove_action( 'wp_head', 'wlwmanifest_link' );
  }

  /**
   * Disable XML-RCP/Pingback.
   *
   * @since 1.0.0
   *
   * @see https://www.littlebizzy.com/blog/disable-xml-rpc
   */
  public function disable_xmlrpc() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    if ( $advanced_setting_group->get_bool_option( 'xmlrpc-all-disabled' ) ) {
      // Disable XML-RCP
      add_filter( 'xmlrpc_enabled', '__return_false' );

      // Disable all XML-RCP methods
      add_filter( 'xmlrpc_methods', '__return_empty_array' );

      return;
    }

    if ( $advanced_setting_group->get_bool_option( 'xmlrpc-pingback-disabled' ) ) {
      // Remove Pingback methods
      add_filter( 'xmlrpc_methods', function ( $methods ) {
        unset( $methods['pingback.ping'] );
        unset( $methods['pingback.extensions.getPingbacks'] );
        return $methods;
      } );

      // Remove Pingback header
      add_filter( 'wp_headers', function ( $headers ) {
        unset( $headers['X-Pingback'] );
        return $headers;
      } );
    }
  }

  /**
   * Remove WordPress Version Number from header and feeds
   *
   * @since 1.0.0
   */
  public function remove_wordpress_version() {
    global $advanced_setting_group;

    if ( empty( $advanced_setting_group ) ) {
      $advanced_setting_group = new SettingGroup( 'advanced_settings' );
    }

    if ( !$advanced_setting_group->get_bool_option( 'remove-wordpress-version' ) ) {
      return;
    }

    remove_action( 'wp_head', 'wp_generator' );
    add_filter( 'the_generator', '__return_empty_string' );

    $remove_version = function ( $src ) {
      $src = remove_query_arg( 'ver', $src );
      return $src;
    };

    add_filter( 'style_loader_src', $remove_version, 10, 2 );
    add_filter( 'script_loader_src', $remove_version, 10, 2 );
  }

  /**
   * Enables FrontEnd Helper to shows Boostrap breakpoints
   *
   * @since 1.0.0
   */
  public function enable_frontend_helper() {
    global $tools_setting_group;

    if ( empty( $tools_setting_group ) ) {
      $tools_setting_group = new SettingGroup( 'tools_settings' );
    }

    if ( $tools_setting_group->get_bool_option( 'frontend-helper-enabled' ) ) {
      new FrontendHelper();
    }
  }

  /**
   * Shows Google Site Verification code
   *
   * @since 0.5.0
   */
  public function google_site_verification() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    global $analytics_setting_group;

    if ( empty( $analytics_setting_group ) ) {
      $analytics_setting_group = new SettingGroup( 'analytics_settings' );
    }

    $google_site_verification = $analytics_setting_group->get_option( 'google-site-verification', '' );
    if ( !empty( $google_site_verification ) ) {
      $google_site_verification = strip_tags( $google_site_verification );
      echo Tag::html( 'meta', null, [ 'name' => 'google-site-verification', 'content' => $google_site_verification ] );
      echo "\n";
    }
  }

  /**
   * Shows Bing Site Verification code
   *
   * @since 0.5.0
   */
  public function bing_site_verification() {
    // If is Yoast active do nothing;
    if ( defined( 'WPSEO_VERSION' ) ) {
      return;
    }

    global $analytics_setting_group;

    if ( empty( $analytics_setting_group ) ) {
      $analytics_setting_group = new SettingGroup( 'analytics_settings' );
    }

    $bing_site_verification = $analytics_setting_group->get_option( 'bing-site-verification', '' );
    if ( !empty( $bing_site_verification ) ) {
      $bing_site_verification = strip_tags( $bing_site_verification );
      echo Tag::html( 'meta', null, [ 'name' => 'msvalidate.01', 'content' => $bing_site_verification ] );
      echo "\n";
    }
  }

  /**
   * Shows Facebook Pixel Code before the closing <head> tag.
   *
   * @since 0.5.0
   */
  public function facebook_pixel_code() {
    global $analytics_setting_group;

    if ( empty( $analytics_setting_group ) ) {
      $analytics_setting_group = new SettingGroup( 'analytics_settings' );
    }

    $facebook_pixel_code = $analytics_setting_group->get_option( 'facebook-pixel-code', '' );
    if ( !empty( $facebook_pixel_code ) ) {
      echo (string) $facebook_pixel_code;
      echo "\n";
    }
  }

  /**
   * Shows Google Tag Manager script
   *
   * @since 0.5.0
   */
  public function google_tag_manager() {
    global $analytics_setting_group;

    if ( empty( $analytics_setting_group ) ) {
      $analytics_setting_group = new SettingGroup( 'analytics_settings' );
    }

    $google_tag_manager = $analytics_setting_group->get_option( 'google-tag-manager', '' );
    if ( !empty( $google_tag_manager ) ) {
      echo (string) $google_tag_manager;
      echo "\n";
    }
  }

  /**
   * Shows Google Universal Analytics script
   *
   * @since 0.5.0
   */
  public function google_universal_analytics() {
    global $analytics_setting_group;

    if ( empty( $analytics_setting_group ) ) {
      $analytics_setting_group = new SettingGroup( 'analytics_settings' );
    }

    $google_universal_analytics = $analytics_setting_group->get_option( 'google-universal-analytics', '' );
    if ( !empty( $google_universal_analytics ) ) {
      echo (string) $google_universal_analytics;
      echo "\n";
    }
  }

}
