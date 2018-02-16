<?php

namespace SourceFramework\Core;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\Singleton;
use SourceFramework\Settings\SettingsGroup;

/**
 * Assets class
 *
 * @package        Core
 * @subpackage     Assets
 * @since          2.0.0
 * @author         Javier Prieto
 */
class Security extends Singleton {

  /**
   * Single instance of this class
   *
   * @since     1.0.0
   * @var       Assets
   */
  protected static $instance;

  /**
   * Declared as protected to prevent creating a new instance outside of the class via the new operator.
   *
   * @since     2.0.0
   *
   * @global    SettingsGroup     $security_options
   */
  protected function __construct() {
    parent::__construct();

    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new SettingsGroup( 'security_options' );
    }

    if ( $security_options->get_bool_option( 'remove-wordpress-version' ) ) {
      add_action( 'wp_head', [ $this, 'remove_wordpress_version' ], -1 );
    }

    if ( $security_options->get_bool_option( 'remove_rsd_link' ) ) {
      add_action( 'wp_head', [ $this, 'remove_rsd_link' ] );
    }

    if ( $security_options->get_bool_option( 'disable_xmlrpc_pingback' ) ) {
      $this->disable_xmlrpc_pingback();
    }

    if ( $security_options->get_bool_option( 'disable_all_xmlrpc' ) ) {
      $this->disable_all_xmlrpc();
    }

    add_action( 'admin_init', [ $this, 'disable_admin_bar' ] );
  }

  /**
   * @since     2.0.0
   */
  public function remove_wordpress_version() {
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
   * @since     2.0.0
   */
  public function remove_rsd_link() {
    // Remove the EditURI/RSD link from head
    remove_action( 'wp_head', 'rsd_link' );

    // Remove the Windows Live Writer manifest link from head
    remove_action( 'wp_head', 'wlwmanifest_link' );
  }

  /**
   * @since     2.0.0
   */
  public function disable_all_xmlrpc() {
    // Disable XML-RCP
    add_filter( 'xmlrpc_enabled', '__return_false' );

    // Disable all XML-RCP methods
    add_filter( 'xmlrpc_methods', '__return_empty_array' );
  }

  /**
   * @since     2.0.0
   */
  public function disable_xmlrpc_pingback() {
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

  /**
   * Disable WordPress Admin Bar in frontend for specific roles.
   *
   * @since     2.0.0
   *
   * @global    SettingsGroup     $security_options
   */
  public function disable_admin_bar() {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new SettingsGroup( 'security_options' );
    }

    $disabled_roles = (array) $security_options->get_option( 'admin-bar-disabled', array() );
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
   * Disable access to admin side of WordPress
   *
   * @since 1.0.0
   *
   * @global SettingGroup $advanced_setting_group
   */
  public function disable_admin_access() {
    global $security_options;

    if ( empty( $security_options ) ) {
      $security_options = new SettingsGroup( 'security_options' );
    }

    $disabled_roles = (array) $security_options->get_option( 'admin-bar-disabled', array() );

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !is_user_logged_in() ) {
      return;
    }

    $user = wp_get_current_user();

    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        exit( wp_redirect( home_url( '/' ) ) );
        break;
      }
    }
  }

}
