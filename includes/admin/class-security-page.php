<?php

namespace SourceFramework\Admin;

defined( 'ABSPATH' ) || exit;

use SourceFramework\Abstracts\Settings_Page;
use SourceFramework\Settings\Settings_Group_Field;

/**
 * Security_Page class
 *
 * @package        SourceFramework
 * @subpackage     Admin
 * @since          2.0.0
 * @author         Javier Prieto
 */
final class Security_Page extends Settings_Page {

  /**
   * Adds Settings_Page methods and properties
   * 
   * @since     2.0.0
   */
  use Traits\Settings_Page;

  /**
   * Constructor
   *
   * @since 2.0.0
   */
  public function __construct() {
    $this->option_page          = 'security_options';
    $this->option_group         = 'security_options';
    $this->option_name          = 'security_options';
    $this->page_description     = __( 'This is not intended to be an exhaustive solution of security settings on your site, '
            . 'they are the most common solutions for development and testing environments, '
            . 'we strongly recommend the use of additional security tools and measures to keep your site safe.', SF_TEXTDOMAIN );
    $this->settings_group_field = new Settings_Group_Field( $this->option_name );

    parent::__construct( 'options-general.php', $this->option_page );

    add_action( 'admin_menu', [ $this, 'add_security_page' ] );
    add_action( 'admin_init', [ $this, 'add_file_edit_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_header_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_xmlrpc_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_admin_bar_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_dashboard_settings_section' ] );
  }

  /**
   * Add Security page to Settings menu
   *
   * @since 2.0.0
   */
  public function add_security_page() {
    parent::add_submenu_page( __( 'Security', SF_TEXTDOMAIN ), __( 'Security', SF_TEXTDOMAIN ), 'activate_plugins' );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_file_edit_settings_section() {
    $this->add_settings_section( 'section-security-file-edit' );

    $fields = [
        'title'   => __( 'General', SF_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'disallow-file-edit',
                'label' => __( 'Disable the Plugin and Theme Editor', SF_TEXTDOMAIN ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-file-edit', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_header_settings_section() {
    $this->add_settings_section( 'section-security-header' );

    $fields = [
        'title'   => __( 'Header', SF_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'remove-wordpress-version',
                'label' => __( 'Remove WordPress version number', SF_TEXTDOMAIN ),
            ],
            [
                'id'    => 'remove-rsd-link',
                'label' => __( 'Remove the EditURI/RSD link from your header', SF_TEXTDOMAIN ),
                'desc'  => __( 'This option also removes the <b>Windows Live Writer</b> manifest link.', SF_TEXTDOMAIN ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-header', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_xmlrpc_settings_section() {
    $this->add_settings_section( 'section-security-xmlrpc' );

    $fields = [
        'title'   => 'XML-RPC',
        'type'    => 'checkbox',
        'options' => [
            [
                'id'    => 'disable-xmlrpc-pingback',
                'label' => __( 'Disable XML-RPC Pingback', SF_TEXTDOMAIN ),
                'desc'  => __( 'If you uses XML-RPC in your theme/plugin check this for disable only pingback method.', SF_TEXTDOMAIN ),
            ],
            [
                'id'    => 'disable-all-xmlrpc',
                'label' => __( 'Completely disable XML-RPC', SF_TEXTDOMAIN ),
                'desc'  => sprintf( __( 'This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="%s" target="_blank">More info</a>.', SF_TEXTDOMAIN ), 'https://www.littlebizzy.com/blog/disable-xml-rpc' ),
            ],
        ],
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-xmlrpc', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_admin_bar_settings_section() {
    $this->add_settings_section( 'section-security-admin-bar' );

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
        'title'    => __( 'Hide Toolbar', SF_TEXTDOMAIN ),
        'type'     => 'checkbox',
        'id'       => 'admin-bar-disabled',
        'desc'     => __( 'Hides the toolbar to user roles when viewing site.', SF_TEXTDOMAIN ),
        'multiple' => true,
        'options'  => $options,
    ];

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-admin-bar', $fields );
  }

  /**
   *
   * @since 2.0.0
   */
  public function add_dashboard_settings_section() {
    $this->add_settings_section( 'section-security-dashboard' );

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
        'title'    => __( 'Disable Dashboard', SF_TEXTDOMAIN ),
        'type'     => 'checkbox',
        'id'       => 'dashboard-disabled',
        'desc'     => __( 'Disable access to the dashboard to user roles.', SF_TEXTDOMAIN ),
        'multiple' => true,
        'options'  => $options,
    );

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-dashboard', $fields );
  }

}
