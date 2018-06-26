<?php

namespace SourceFramework\Admin;

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

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
   * @var Settings_Group_Field
   */
  private $settings_group_field;

  /**
   * Constructor
   *
   * @since 2.0.0
   */
  public function __construct() {
    $this->option_page          = 'security-options';
    $this->option_group         = 'security-options';
    $this->option_name          = 'security_options';
    $this->settings_group_field = new Settings_Group_Field( $this->option_name );

    parent::__construct( 'options-general.php', $this->option_page );

    add_action( 'admin_menu', [ $this, 'add_security_page' ] );
    add_action( 'admin_init', [ $this, 'add_file_edit_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_header_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_xmlrpc_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_admin_bar_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_dashboard_settings_section' ] );
    add_action( 'admin_init', [ $this, 'add_htaccess_settings_section' ] );
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

  /**
   *
   * @since 2.0.0
   */
  public function add_htaccess_settings_section() {
    $this->add_settings_section( 'section-security-htaccess' );

    $options = [
        [
            'label' => __( 'Disable directory index', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-disable-indexes',
        ],
        [
            'label' => __( 'Disable CONNECT|DEBUG|MOVE|PUT|TRACE|TRACK methods', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-block-request-methods',
        ],
        [
            'label' => __( 'Block unsafe query strings', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-block-query-strings',
        ],
        [
            'label' => __( 'Block unsafe request strings', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-block-request-strings',
        ],
        [
            'label' => __( 'Block direct access to critical files', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-block-direct-access',
        ],
        [
            'label' => __( 'Block user enumeration', SF_TEXTDOMAIN ),
            'id'    => 'htaccess-block-user-enumeration',
        ],
    ];

    unset( $options['administrator'] );

    $fields = array(
        'title'   => '.htaccess',
        'type'    => 'checkbox',
        'id'      => 'htaccess-settings',
        'desc'    => __( 'This option requires regenerate permalinks', SF_TEXTDOMAIN ),
        'options' => $options,
    );

    $this->settings_group_field->add_settings_field( $this->submenu_slug, 'section-security-htaccess', $fields );
  }

}
