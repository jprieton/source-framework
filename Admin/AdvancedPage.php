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
    $this->title = __( 'Advanced Settings', \SourceFramework\TEXTDOMAIN );
    /**
     * Allow override menu slug
     * @since 1.0.0
     */
    $menu_slug   = apply_filters( 'source_framework_advanced_menu_slug', 'source-framework' );

    parent::__construct( $menu_slug, 'source-framework-advanced' );
    $this->add_submenu_page( __( 'Advanced', \SourceFramework\TEXTDOMAIN ), __( 'Advanced', \SourceFramework\TEXTDOMAIN ), 'activate_plugins' );
    $this->fields = new SettingField( 'advanced_settings', 'advanced_settings' );
    // General Section
    $this->general_section();
    $this->security_section();
    $this->custom_post_type_section();

    do_action( 'advanced-setting-page', $this );
  }

  /**
   * Adds General setting section to Tools menu.
   *
   * @since 1.0.0
   */
  public function general_section() {
    $this->add_setting_section( 'source-framework-advanced-general', __( 'General', \SourceFramework\TEXTDOMAIN ) );

    $args = [
        'id'       => 'thumbnail-column',
        'type'     => 'checkbox',
        'name'     => __( 'Thumbnail Column', \SourceFramework\TEXTDOMAIN ),
        'multiple' => true,
        'options'  => []
    ];

    $post_types = get_post_types( [ 'show_ui' => true ], 'objects' );

    foreach ( $post_types as $item ) {
      $args['options'][$item->name] = [
          'value' => $item->name,
          'label' => $item->label
      ];
    }

    unset( $args['options']['attachment'] );
    if ( function_exists( 'WC' ) ) {
      unset( $args['options']['product'] );
    }

    $this->fields->add_field( $args );

    $args['id']   = 'featured-posts';
    $args['name'] = __( 'Featured Posts', \SourceFramework\TEXTDOMAIN );
    $this->fields->add_field( $args );

    $args = [
        'type'  => 'checkbox',
        'name'  => __( 'Favorite Post', \SourceFramework\TEXTDOMAIN ),
        'id'    => 'favorite-post-enabled',
        'label' => __( "This option enables to the user mark posts as favorite.", \SourceFramework\TEXTDOMAIN ),
    ];
    $this->fields->add_field( $args );

    $args = [
        'type'  => 'checkbox',
        'name'  => __( 'Rich text editor in excerpts', \SourceFramework\TEXTDOMAIN ),
        'id'    => 'excerpt-rich-editor-enabled',
        'label' => __( "This option enables the rich text editor in excerpts.", \SourceFramework\TEXTDOMAIN ),
    ];
    $this->fields->add_field( $args );

    $args = [
        'type'  => 'checkbox',
        'name'  => __( 'Enable CDN', \SourceFramework\TEXTDOMAIN ),
        'id'    => 'cdn-enabled',
        'label' => __( "This option enables the use of CDN in plugin's registered scripts and styles.", \SourceFramework\TEXTDOMAIN ),
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
      $options[$key] = array(
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
        'desc'     => __( 'Disable the admin bar in frontend by role', \SourceFramework\TEXTDOMAIN ),
    ) );

    unset( $options['administrator'] );

    $this->fields->add_field( array(
        'name'     => 'Admin Access Disable',
        'type'     => 'checkbox',
        'id'       => 'admin-access-disabled',
        'multiple' => true,
        'options'  => $options,
        'desc'     => __( 'Disable access to the wp-admin in by role', \SourceFramework\TEXTDOMAIN ),
    ) );
  }

  public function custom_post_type_section() {
    $this->add_setting_section( 'custom-post-type', __( 'Post Types', \SourceFramework\TEXTDOMAIN ) );

    $args = [
        'name'     => __( 'Post Types', \SourceFramework\TEXTDOMAIN ),
        'type'     => 'checkbox',
        'id'       => 'post-types',
        'multiple' => true,
        'options'  => []
    ];

    $post_types = [
        'office'      => [
            'label' => __( 'Offices', \SourceFramework\TEXTDOMAIN ),
        ],
        'place'       => [
            'label' => __( 'Places', \SourceFramework\TEXTDOMAIN ),
        ],
        'portfolio'   => [
            'label' => __( 'Portfolios', \SourceFramework\TEXTDOMAIN ),
        ],
        'product'     => [
            'label' => __( 'Products <span class="description">(This option has no effect when WooCommerce is actived)</span>', \SourceFramework\TEXTDOMAIN ),
        ],
        'review'      => [
            'label' => __( 'Reviews', \SourceFramework\TEXTDOMAIN ),
        ],
        'service'     => [
            'label' => __( 'Services', \SourceFramework\TEXTDOMAIN ),
        ],
        'slider'      => [
            'label' => __( 'Slider', \SourceFramework\TEXTDOMAIN ),
        ],
        'testimonial' => [
            'label' => __( 'Testimonials', \SourceFramework\TEXTDOMAIN ),
        ],
    ];

    $post_types = apply_filters( 'custom_post_types', $post_types );

    foreach ( $post_types as $key => $value ) {
      $value['value']    = $key;
      $args['options'][] = $value;
    }

    $this->fields->add_field( $args );
  }

}
