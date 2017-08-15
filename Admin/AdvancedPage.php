<?php

namespace SourceFramework\Admin;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use SourceFramework\Abstracts\SettingPage;
use SourceFramework\Settings\SettingField;

/**
 * AdvancedPage class
 *
 * @package        Admin
 * @subpackage     SettingPages
 * @since          1.0.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
final class AdvancedPage extends SettingPage {

  /**
   * Constructor
   *
   * @since 1.0.0
   */
  public function __construct() {
    $this->title  = __( 'Advanced Settings', \SourceFramework\TEXTDOMAIN );
    parent::__construct( 'source-framework', 'source-framework-advanced' );
    $this->add_submenu_page( __( 'Advanced', \SourceFramework\TEXTDOMAIN ), __( 'Advanced', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
    $this->fields = new SettingField( 'source-framework', 'source-framework' );
    // General Section
    $this->general_section();
    $this->security_section();
  }

  /**
   * Adds General setting section to Tools menu.
   *
   * @since 1.0.0
   */
  public function general_section() {
    $this->add_setting_section( 'source-framework-advanced-general', __( 'General', \SourceFramework\TEXTDOMAIN ) );

    $args = [
        'type'    => 'checkbox',
        'name'    => __( 'Featured Post', \SourceFramework\TEXTDOMAIN ),
        'options' => []
    ];

    $post_types = get_post_types( [ 'show_ui' => true ], 'objects' );

    foreach ( $post_types as $item ) {
      $args['options'][] = [
          'id'    => 'featured-' . $item->name,
          'label' => $item->label
      ];
    }
    $this->fields->add_field( $args );

    $args = [
        'type' => 'checkbox',
        'name' => __( 'Enable CDN', \SourceFramework\TEXTDOMAIN ),
        'id'   => 'cdn-enabled',
        'desc' => __( "This option enables the use of CDN in plugin's registered scripts and styles.", \SourceFramework\TEXTDOMAIN ),
    ];
    $this->fields->add_field( $args );
  }

  public function security_section() {
    $this->add_setting_section( 'source-framework-advanced-security', __( 'Security', \SourceFramework\TEXTDOMAIN ) );

    $this->fields->add_field( array(
        'name'    => __( 'Header', \SourceFramework\TEXTDOMAIN ),
        'type'    => 'checkbox',
        'id'      => 'security-header',
        'options' => array(
            array(
                'id'    => 'remove-wordpress-version',
                'label' => __( 'Remove WordPress version number', \SourceFramework\TEXTDOMAIN ),
                'desc'  => __( 'Remove WordPress version number from header, feed, styles and scripts.', \SourceFramework\TEXTDOMAIN ),
            ),
            array(
                'id'    => 'remove-rsd-link',
                'label' => __( 'Remove EditURI link', \SourceFramework\TEXTDOMAIN ),
                'desc'  => __( 'Remove the EditURI/RSD link from your header. This option also removes the <b>Windows Live Writer</b> manifest link.', \SourceFramework\TEXTDOMAIN ),
            ),
        ),
    ) );

    $this->fields->add_field( array(
        'name'    => 'XML-RPC',
        'type'    => 'checkbox',
        'id'      => 'security-xmlrcp',
        'options' => array(
            array(
                'id'    => 'xmlrpc-pingback-disabled',
                'label' => 'Disable XML-RPC Pingback',
                'desc'  => __( 'If you uses XML-RPC in your theme/plugins check this for disable only pingback method.', \SourceFramework\TEXTDOMAIN ),
            ),
            array(
                'id'    => 'xmlrpc-pingback-disabled',
                'label' => 'Completely disable XML-RPC',
                'desc'  => __( 'Disable XML-RPC completely. This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="https://www.littlebizzy.com/blog/disable-xml-rpc" target="_blank">More info</a>.', \SourceFramework\TEXTDOMAIN ),
            ),
        ),
    ) );

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

    $this->fields->add_field( array(
        'name'     => 'Admin Bar Disable',
        'type'     => 'checkbox',
        'id'       => 'admin-bar-disabled',
        'multiple' => true,
        'options'  => $options,
    ) );
  }

}
