<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingsPage;
use SourceFramework\Settings\SettingsGroupField;

/**
 * SecurityPage class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
final class SecurityPage extends SettingsPage {

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_group = '';

  /**
   * Option group
   * @since   1.0.0
   * @var     string
   */
  protected $option_page = '';

  /**
   *
   * @var SettingsGroupField
   */
  private $settings_group_field;

  /**
   * Constructor
   *
   * @since 2.0.0
   */
  public function __construct() {
    $this->option_page          = 'source-framework-security';
    $this->option_group         = 'source-framework-security';
    $this->option_name          = 'security-options';
    $this->settings_group_field = new SettingsGroupField( 'security-options' );

    parent::__construct( 'options-general.php', $this->option_page );

    add_action( 'admin_menu', [ $this, 'add_submenu_page' ] );
    add_action( 'admin_init', [ $this, 'add_header_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_xmlrpc_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_admin_bar_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_admin_access_settings_section' ] );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_submenu_page( $page_title = '', $menu_title = '', $capability = '' ) {
    parent::add_submenu_page( __( 'Security', SF_TEXTDOMAIN ), __( 'Security', SF_TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_header_settings_section() {
    $this->add_settings_section( 'source-framework-security-header' );

    $fields = [
        'title'   => __( 'Header', SF_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'remove-wordpress-version',
                'label' => __( 'Remove WordPress version number', SF_TEXTDOMAIN ),
                'desc'  => __( 'Remove WordPress version number from header, feed, styles and scripts.', SF_TEXTDOMAIN ),
            ],
            [
                'id'    => 'remove-rsd-link',
                'label' => __( 'Remove EditURI link', SF_TEXTDOMAIN ),
                'desc'  => __( 'Remove the EditURI/RSD link from your header. This option also removes the <b>Windows Live Writer</b> manifest link.', SF_TEXTDOMAIN ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'source-framework-security-header', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_xmlrpc_settings_section() {
    $this->add_settings_section( 'source-framework-security-xmlrpc' );

    $fields = [
        'title'   => 'XML-RPC',
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'xmlrpc-pingback-disabled',
                'label' => 'Disable XML-RPC Pingback',
                'desc'  => __( 'If you uses XML-RPC in your theme/plugins check this for disable only pingback method.', SF_TEXTDOMAIN ),
            ],
            [
                'id'    => 'xmlrpc-all-disabled',
                'label' => 'Completely disable XML-RPC',
                'desc'  => sprintf( __( 'Disable XML-RPC completely. This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="%s" target="_blank">More info</a>.', SF_TEXTDOMAIN ), 'https://www.littlebizzy.com/blog/disable-xml-rpc' ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'source-framework-security-xmlrpc', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_admin_bar_settings_section() {
    $this->add_settings_section( 'source-framework-security-admin-bar' );

    global $wp_roles;

    if ( !isset( $wp_roles ) ) {
      $wp_roles = new WP_Roles();
    }

    $_roles = $wp_roles->get_names();

    $options = array();
    foreach ( $_roles as $key => $label ) {
      $options[] = array(
          'label' => $label,
          'value' => $key,
      );
    }

    $fields = [
        'title'   => 'Hide the Admin Bar',
        'type'    => 'checkbox',
        'id'      => 'admin-bar-disabled',
        'desc'    => __( 'Hides the Admin Bar for the front side of your website.', SF_TEXTDOMAIN ),
        'options' => $options,
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'source-framework-security-admin-bar', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_admin_access_settings_section() {
    $this->add_settings_section( 'source-framework-security-admin-access' );

    global $wp_roles;

    if ( !isset( $wp_roles ) ) {
      $wp_roles = new WP_Roles();
    }

    $_roles = $wp_roles->get_names();

    $options = array();
    foreach ( $_roles as $key => $label ) {
      $options[$key] = array(
          'label' => $label,
          'value' => $key,
      );
    }

    unset( $options['administrator'] );

    $fields = array(
        'title'   => 'Disabled access to admin',
        'type'    => 'checkbox',
        'id'      => 'admin-access-disabled',
        'desc'    => __( 'Disable access to the wp-admin in by role', SF_TEXTDOMAIN ),
        'options' => $options,
    );

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'source-framework-security-admin-access', $fields );
  }

}
