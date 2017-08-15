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

    $this->setting_group = new SettingGroup( 'source-framework' );

    /**
     * Disable WordPress Admin Bar in frontend for specific roles.
     * @since 1.0.0
     */
    $this->disable_admin_bar_by_role();

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
    $disabled_roles = (array) $this->setting_group->get_option( 'admin-bar-disabled', array() );
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
    if ( !$this->setting_group->get_bool_option( 'remove-rsd-link' ) ) {
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
    if ( $this->setting_group->get_bool_option( 'xmlrpc-all-disabled' ) ) {
      // Disable XML-RCP
      add_filter( 'xmlrpc_enabled', '__return_false' );

      // Disable all XML-RCP methods
      add_filter( 'xmlrpc_methods', '__return_empty_array' );

      return;
    }

    if ( $this->setting_group->get_bool_option( 'xmlrpc-pingback-disabled' ) ) {
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
    if ( !$this->setting_group->get_bool_option( 'remove-wordpress-version' ) ) {
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
    if ( !$this->setting_group->get_bool_option( 'frontend-helper-enabled' ) ) {
      return;
    }

    new FrontendHelper();
  }

}
